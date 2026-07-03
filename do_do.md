# AirCon Service Booking - To-Do List

## ✅ COMPLETED TASKS (This Session)

### Contact Us System Implementation
- [x] Create contact_us.php dynamic page with message submission form
- [x] Create actions/contact_process.php form handler
- [x] Create admin/content/messages.php admin dashboard
- [x] Create actions/admin/reply_message.php reply processor
- [x] Create includes/repositories/ContactMessageRepository.php data access layer
- [x] Add ContactMessageRepository to includes/bootstrap.php
- [x] Add helper functions to includes/helpers.php (setFlash, redirectTo, requireLogin)
- [x] Add "Messages" link to admin sidebar (sidebars/admin.php)
- [x] Create includes/public_bootstrap.php for public pages

### Path & URL Fixes
- [x] Fix shared/navbar.html - change all relative paths to absolute paths
- [x] Fix shared/topnav.php - change relative paths to absolute paths
- [x] Fix auth.php redirects - use absolute paths for login redirects
- [x] Fix login_process.php technician redirect - absolute path
- [x] Fix technician/pending.php login redirect - absolute path
- [x] Fix contact_us.php form action - absolute path to /ACSS/airconservices_booking/actions/contact_process.php
- [x] Fix admin/content/messages.php reply form action - absolute path

### Documentation
- [x] Create CONTACT_SYSTEM_DOCS.md with full implementation details
- [x] Document complete message flow (customer → admin → reply)
- [x] Provide testing scenarios and checkpoints

---

## ⏳ TODO: Next Tasks

### Database Setup
- [ ] Run SQL ALTER on contact_messages table to add columns:
  - subject, reply, replied_at, admin_id
  - Add indexes on email and status columns

### Testing & Validation
- [ ] TEST 1: Anonymous user submit message
- [ ] TEST 2: Logged-in customer view message history
- [ ] TEST 3: Admin view and reply to message
- [ ] TEST 4: Customer see admin reply
- [ ] Test form validation (missing required fields)
- [ ] Test flash messages (success/error display)
- [ ] Test message status badge styling
- [ ] Test modal dialog opening/closing
- [ ] Test page responsiveness on mobile

### Email Notifications (FUTURE)
- [ ] Send email to admin when new message arrives
- [ ] Send email to customer when admin replies
- [ ] Email template for notifications

### UI Enhancements (FUTURE)
- [ ] Add pagination to admin messages table
- [ ] Add search/filter by email in admin dashboard
- [ ] Add bulk mark as read/replied functionality
- [ ] Add message delete/archive functionality
- [ ] Add reply character counter in admin modal
- [ ] Add loading spinner while submitting form

### Security Enhancements (FUTURE)
- [ ] Add CSRF token protection to forms
- [ ] Rate limit contact form submissions (prevent spam)
- [ ] Add captcha to contact form
- [ ] Validate email domain
- [ ] Add admin notes field (internal comments on message)

### Additional Features (FUTURE)
- [ ] Export contact messages to CSV
- [ ] Message attachment support (images/files)
- [ ] Message categories/tags
- [ ] Auto-reply templates for common responses
- [ ] Message priority levels (normal/high/urgent)
- [ ] Assign messages to different admins
- [ ] Message read tracking

---

## 📋 SUMMARY

**Completed**: 20+ tasks
**Status**: Contact messaging system fully implemented and integrated
**Next Step**: Run SQL ALTER, then test all scenarios

**Files Created**: 4
- contact_process.php
- messages.php
- reply_message.php
- ContactMessageRepository.php
- public_bootstrap.php

**Files Modified**: 8
- contact_us.php
- navbar.html
- topnav.php
- bootstrap.php
- helpers.php
- admin.php sidebar
- auth.php
- login_process.php

**Database**: Ready for SQL ALTER

---

Generated: July 2, 2026

CUSTOMER FLOW
① Mkaka/mke anapikiza Contact Us page
   URL: http://localhost/ACSS/airconservices_booking/contact_us.php

② Anajaza form:
   - Full Name (required)
   - Email (required)
   - Phone (optional)
   - Service Type (required): AC Installation, Repair, Maintenance, Emergency, General
   - Message (required)

③ Anaclick "Send Message" button
   Form POSTs to: /ACSS/airconservices_booking/actions/contact_process.php

④ Validation happens:
   ✅ If valid: Message saved to database, shows "Thank you" message
   ❌ If invalid: Shows validation errors, form stays

⑤ Page shows success message: 
   "Thank you for your message. We will get back to you shortly."

   LOGEDIN CUSTOMER FLOW
   ① Same as above - customer fills form at /contact_us.php

② AFTER form submits successfully:
   - Page reloads showing form again (clear for new message)
   - BELOW form: "Your Messages & Replies" section appears

③ Sehemu hii inaonyesha:
   - All messages sent from that user's email
   - Status badge: "New" (yellow) or "Replied" (green)
   - Date message was sent
   - Full message text
   - IF admin replied: Shows reply in blue box with reply date

④ Timeline format:
   Most recent message at top → Oldest at bottom
   Each message can have:
   ┌─ Message subject (AC Installation, Repair, etc.)
   ├─ Sent date/time
   ├─ Status badge
   ├─ Your message text
   └─ [IF REPLIED] Admin's reply + reply date

   ADMIN DASHBOARD FLOW
   
① Admin anapikiza admin dashboard:
   URL: http://localhost/ACSS/airconservices_booking/admin/dashboard.php

② Anaclick "Messages" link kwenye sidebar
   Page: /admin/dashboard.php?page=messages

③ Messages page inaonyesha:
   📊 Stat cards at top:
      - "New Messages" count (red badge)
      - "Replied" count (green badge)

④ Below stats: Table showing ALL messages
   Columns:
   | From Name | Email | Subject | Status | Date | Action |
   
   Example:
   | John Doe | john@email.com | AC Repair | New | Jul 2, 2026 | View & Reply |
   | Jane Smith | jane@email.com | Maintenance | Replied | Jul 1, 2026 | View & Reply |

⑤ Admin anaclick "View & Reply" button
   Modal dialog opens showing:
   
   📋 Customer Info:
      - From: [Name] ([Email])
      - Phone: [Phone]
      - Subject: [Service Type]
      - Message Date: [Date/Time]
   
   💬 Customer's original message (light gray box)
   
   ➡️ TWO OPTIONS:
   
   OPTION A: Message NOT YET REPLIED
   → Shows textarea "Your Reply"
   → Admin types reply
   → Clicks "Send Reply" button
   → Message updates:
      - Status changes to "Replied"
      - Timestamp recorded
      - Admin ID saved
   → Customer sees reply next time on contact page
   
   OPTION B: Message ALREADY REPLIED
   → Shows previous reply in green box
   → Shows when it was replied
   → Cannot edit reply (view only)


   DATABASE FLOW

   📁 Table: contact_messages
   Columns:
   ├─ id (PRIMARY KEY)
   ├─ name (customer name)
   ├─ email (customer email)
   ├─ phone (optional)
   ├─ subject (AC Installation, Repair, etc.)
   ├─ message (message text)
   ├─ reply (admin reply text) - NULL if not replied
   ├─ status (enum: 'new', 'read', 'replied')
   ├─ created_at (when message sent)
   ├─ replied_at (when admin replied) - NULL if not replied
   └─ admin_id (which admin replied) - NULL if not replied

Example row after customer submits:
┌──────────────────────────────────────────────────┐
│ id: 1                                            │
│ name: "John Doe"                                 │
│ email: "john@email.com"                          │
│ phone: "0712345678"                              │
│ subject: "AC Repair"                             │
│ message: "My AC is making noise, please help"    │
│ reply: NULL                                      │
│ status: "new"                                    │
│ created_at: 2026-07-02 14:30:00                 │
│ replied_at: NULL                                 │
│ admin_id: NULL                                   │
└──────────────────────────────────────────────────┘

Example row AFTER admin replies:
┌──────────────────────────────────────────────────┐
│ id: 1                                            │
│ name: "John Doe"                                 │
│ email: "john@email.com"                          │
│ phone: "0712345678"                              │
│ subject: "AC Repair"                             │
│ message: "My AC is making noise, please help"    │
│ reply: "We received your request. Our technician│
│        will visit on Jul 3 at 2PM. Thanks"       │
│ status: "replied"                                │
│ created_at: 2026-07-02 14:30:00                 │
│ replied_at: 2026-07-02 16:45:00                 │
│ admin_id: 5 (admin user ID)                      │
└──────────────────────────────────────────────────┘


MESSEGE LIFE CYCLE COMPLETE


STAGE 1: SUBMISSION (Public/Customer)
├─ User fills contact form
├─ Form submits to /actions/contact_process.php
├─ Validates data
├─ Saves to contact_messages table (status='new')
└─ Shows success: "Thank you for your message"

         ⬇️

STAGE 2: DISPLAY TO CUSTOMER (If logged in)
├─ When customer visits contact_us.php again
├─ System checks: Is user logged in?
├─ If YES: Shows "Your Messages & Replies" section
├─ Lists all messages from that customer's email
└─ Shows reply status (green "Replied" / yellow "New")

         ⬇️

STAGE 3: ADMIN NOTIFICATION
├─ Admin sees "New Messages" count in sidebar
├─ Navigates to Messages dashboard
├─ Sees message in table with status "new"
└─ Can view customer details and original message

         ⬇️

STAGE 4: ADMIN REPLY
├─ Admin clicks "View & Reply"
├─ Modal opens with customer info
├─ Admin types reply message
├─ Clicks "Send Reply"
├─ Form POSTs to /actions/admin/reply_message.php
├─ Validates (must be logged in as admin)
├─ Updates database:
│  - reply = [admin message]
│  - status = 'replied'
│  - replied_at = NOW()
│  - admin_id = [admin user id]
└─ Shows "Reply sent successfully to [email]"

         ⬇️

STAGE 5: CUSTOMER SEES REPLY
├─ Customer logs in and visits /contact_us.php
├─ System loads messages from contact_messages
├─ Shows all messages + replies
├─ Replied message shows:
│  - Status badge: "Replied" (green)
│  - Original message
│  - Blue box: "Admin Reply:" + message
│  - "Replied on [date/time]"
└─ Customer reads admin's response
 KEY FEATURES
✅ Public Access: Anyone can submit without login
✅ Message History: Logged-in users see past messages
✅ Status Tracking: New → Replied states
✅ Email Tracking: Messages linked by email address
✅ Admin Control: Only admins can reply
✅ Timestamps: All actions recorded with dates
✅ Validation: Required fields enforced
✅ Flash Messages: Success/error feedback

7️⃣ REQUIRED DATABASE SETUP
Run this SQL before testing:

8️⃣ TEST SCENARIOS
Pole pole sasa! 🚀 Hii ndio complete system flow!

Claude Haiku 4.5 • 2.7 credits

ALTER TABLE `contact_messages` 
ADD COLUMN `subject` VARCHAR(255) DEFAULT 'General Inquiry' AFTER `phone`,
ADD COLUMN `reply` TEXT DEFAULT NULL AFTER `message`,
ADD COLUMN `replied_at` TIMESTAMP NULL DEFAULT NULL AFTER `reply`,
ADD COLUMN `admin_id` INT UNSIGNED DEFAULT NULL AFTER `replied_at`,
ADD INDEX `idx_contact_messages_email` (`email`),
ADD INDEX `idx_contact_messages_status` (`status`);

TEST SCENARIO
TEST 1: Anonymous User Submits
Step 1: Go to /contact_us.php (not logged in)
Step 2: Fill form & submit
Step 3: See "Thank you" message
Step 4: Check database - message should exist with status='new'
✓ PASS if: Success message shows, form clears

TEST 2: Logged-in Customer Submits & Views
Step 1: Login as customer
Step 2: Go to /contact_us.php
Step 3: Submit form
Step 4: See success message
Step 5: Page shows "Your Messages & Replies" section
Step 6: Message appears with status "New" (yellow)
✓ PASS if: Message history displays correctly

TEST 3: Admin Views & Replies
Step 1: Login as admin
Step 2: Go to /admin/dashboard.php?page=messages
Step 3: See message in table
Step 4: Click "View & Reply"
Step 5: Modal opens with customer info
Step 6: Type reply in textarea
Step 7: Click "Send Reply"
Step 8: See success: "Reply sent successfully to [email]"
✓ PASS if: Message status changes to "Replied"

TEST 4: Customer Sees Admin Reply
Step 1: Login as same customer from TEST 2
Step 2: Go to /contact_us.php
Step 3: Scroll to "Your Messages & Replies"
Step 4: See message with green "Replied" badge
Step 5: See admin reply in blue box below message
✓ PASS if: Reply displays with reply timestamp

