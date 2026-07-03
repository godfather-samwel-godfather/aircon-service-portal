# Contact Us Dynamic System - Implementation Summary

## Overview
Transformed the static contact_us.php into a dynamic messaging system with admin reply capability.

## Files Modified

### 1. **contact_us.php** (Public Page)
- Added PHP backend to load user's messages from database
- Displays contact form for message submission
- Shows message history and admin replies for logged-in users
- Includes form validation and flash messages (success/error)

### 2. **actions/contact_process.php** (Form Handler - NEW)
- Handles form POST submissions from contact_us.php
- Validates: name, email, message (required)
- Inserts messages into contact_messages table with status='new'
- Redirects with success/error flash message

### 3. **admin/content/messages.php** (Admin Dashboard - NEW)
- Lists all contact messages with status badges
- Shows count of new vs replied messages
- Modal dialog per message to view full details
- Admin reply form in modal (if not already replied)
- Displays customer's previous replies below message

### 4. **actions/admin/reply_message.php** (Admin Reply Handler - NEW)
- Role-protected to admin only (requireRole('admin'))
- Updates contact_messages: reply text, status→'replied', timestamp, admin_id
- Sends success/error flash message
- Redirects to admin messages dashboard

### 5. **includes/repositories/ContactMessageRepository.php** (Data Access - NEW)
- `getAll()` - Get all messages ordered by newest first
- `getByStatus($status)` - Get messages by 'new'/'read'/'replied' status
- `countByStatus($status)` - Count messages in each status
- `getById($id)` - Get specific message
- `getByEmail($email)` - Get messages from email address
- `saveReply($id, $reply, $adminId)` - Save reply and update status
- `insert()` - Insert new message
- `markAsRead($id)` - Mark message as read (optional)

### 6. **includes/bootstrap.php** (Updated)
- Added `require_once` for ContactMessageRepository.php

### 7. **includes/helpers.php** (Updated)
- Added `setFlash($type, $message)` - Set flash messages in session
- Added `redirectTo($url)` - Redirect helper
- Added `requireLogin()` - Login check middleware

### 8. **sidebars/admin.php** (Updated)
- Added "Messages" link in admin sidebar navigation
- Links to `dashboard.php?page=messages`

## Database Schema Changes

Run this SQL to add required columns to contact_messages table:

```sql
ALTER TABLE `contact_messages` 
ADD COLUMN `subject` VARCHAR(255) DEFAULT 'General Inquiry' AFTER `phone`,
ADD COLUMN `reply` TEXT DEFAULT NULL AFTER `message`,
ADD COLUMN `replied_at` TIMESTAMP NULL DEFAULT NULL AFTER `reply`,
ADD COLUMN `admin_id` INT UNSIGNED DEFAULT NULL AFTER `replied_at`,
ADD INDEX `idx_contact_messages_email` (`email`),
ADD INDEX `idx_contact_messages_status` (`status`);
```

## Message Flow

### Customer Perspective
1. User visits `/contact_us.php`
2. Fills form (name, email, phone, subject, message)
3. Form submits to `/actions/contact_process.php`
4. Message saved to database with status='new'
5. Success message displayed
6. **If logged in**: User sees their message history and any admin replies

### Admin Perspective
1. Admin visits `/admin/dashboard.php?page=messages`
2. Views all contact messages in table (status badges)
3. Clicks "View & Reply" button on message
4. Modal opens showing:
   - Customer details (name, email, phone)
   - Customer's message
   - **If not replied**: Reply textarea form
   - **If replied**: Shows previous admin reply with timestamp
5. Admin types reply and clicks "Send Reply"
6. Message status updates to 'replied' with timestamp and admin_id
7. Customer sees reply when they visit contact_us.php

## Features

✅ **Message Submission**
- Form validation (name, email, message required)
- Status tracking (new → read → replied)
- Timestamps for created_at and replied_at

✅ **Customer-Facing**
- View personal message history on contact_us.php
- See admin replies inline
- Status badges (New, Read, Replied)
- Flash messages after submission

✅ **Admin Management**
- Dashboard page to view all messages
- Count indicators (new, replied)
- Modal dialog per message
- Reply form with submission handling
- Automatic status update and timestamp

✅ **Data Relationships**
- Contact messages linked by email for logged-in users
- Admin ID tracked when reply sent
- Timestamps for audit trail

## Security

- Admin reply form only shows if user is logged in AND admin
- `requireRole('admin')` protects reply action
- Flash messages sanitized with `e()` helper
- Prepared statements prevent SQL injection
- CSRF tokens not implemented (consider adding)

## Testing Checklist

- [ ] Run SQL ALTER to add columns
- [ ] Test form submission (anonymous user)
- [ ] Check message appears in admin dashboard
- [ ] Test admin reply
- [ ] Verify reply appears in customer's contact_us.php (if logged in)
- [ ] Test validation (missing name/email/message)
- [ ] Test different status displays (new, read, replied)
- [ ] Verify timestamps are correct

## Future Enhancements

1. Add CSRF token protection to forms
2. Email notification when admin replies
3. Pagination for admin messages list
4. Search/filter by email or date
5. Bulk mark as read/replied
6. Reply message soft delete
7. Message read status on admin view
8. Email capture without login for follow-up
