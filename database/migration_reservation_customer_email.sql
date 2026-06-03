-- Migration to add customer_email column to reservations table
-- MySQL 5.7 compatible
-- This allows storing the customer email directly in the reservation record
-- for reliable confirmation email delivery

ALTER TABLE reservations
ADD COLUMN customer_email VARCHAR(255) NULL AFTER customer_phone;

-- Back-fill existing reservations with the email from the customers table.
-- The customers.phone column has a UNIQUE constraint, so the join is safe.
UPDATE reservations r
JOIN customers c ON c.phone = r.customer_phone
SET r.customer_email = c.email
WHERE r.customer_email IS NULL AND c.email IS NOT NULL;
