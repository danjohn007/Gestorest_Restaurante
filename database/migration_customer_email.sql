-- Migration to add email field to customers table
-- MySQL 5.7 compatible
-- This allows storing customer email addresses for reservation confirmations

-- Add email column to customers table
ALTER TABLE customers 
ADD COLUMN email VARCHAR(255) NULL AFTER phone;

-- Add index for email lookups
CREATE INDEX idx_customers_email ON customers(email);

-- Update existing records to have NULL email (default)
-- No data update needed as column allows NULL
