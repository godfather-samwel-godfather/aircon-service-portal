-- Add columns to contact_messages table to support replies
ALTER TABLE `contact_messages` 
ADD COLUMN `subject` VARCHAR(255) DEFAULT 'General Inquiry' AFTER `phone`,
ADD COLUMN `reply` TEXT DEFAULT NULL AFTER `message`,
ADD COLUMN `replied_at` TIMESTAMP NULL DEFAULT NULL AFTER `reply`,
ADD COLUMN `admin_id` INT UNSIGNED DEFAULT NULL AFTER `replied_at`,
ADD INDEX `idx_contact_messages_email` (`email`),
ADD INDEX `idx_contact_messages_status` (`status`);

-- Optional: Add foreign key for admin_id if you want referential integrity
-- ALTER TABLE `contact_messages` 
-- ADD CONSTRAINT `fk_contact_messages_admin` 
-- FOREIGN KEY (`admin_id`) REFERENCES `users`(`id`) ON DELETE SET NULL;
