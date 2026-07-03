<?php

class ContactMessageRepository {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    /**
     * Get all messages
     */
    public function getAll() {
        $stmt = $this->conn->prepare("
            SELECT id, name, email, phone, subject, message, reply, status, created_at, replied_at, admin_id
            FROM contact_messages
            ORDER BY created_at DESC
        ");
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Get messages by status
     */
    public function getByStatus($status) {
        $stmt = $this->conn->prepare("
            SELECT id, name, email, phone, subject, message, reply, status, created_at, replied_at, admin_id
            FROM contact_messages
            WHERE status = ?
            ORDER BY created_at DESC
        ");
        $stmt->bind_param('s', $status);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Get count by status
     */
    public function countByStatus($status) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) as count FROM contact_messages WHERE status = ?");
        $stmt->bind_param('s', $status);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['count'];
    }

    /**
     * Get message by ID
     */
    public function getById($id) {
        $stmt = $this->conn->prepare("
            SELECT id, name, email, phone, subject, message, reply, status, created_at, replied_at, admin_id
            FROM contact_messages
            WHERE id = ?
        ");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    /**
     * Get messages by email
     */
    public function getByEmail($email) {
        $stmt = $this->conn->prepare("
            SELECT id, name, email, phone, subject, message, reply, status, created_at, replied_at, admin_id
            FROM contact_messages
            WHERE email = ?
            ORDER BY created_at DESC
        ");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Save reply message
     */
    public function saveReply($id, $reply, $adminId) {
        $stmt = $this->conn->prepare("
            UPDATE contact_messages 
            SET reply = ?, status = 'replied', replied_at = NOW(), admin_id = ?
            WHERE id = ?
        ");
        $stmt->bind_param('sii', $reply, $adminId, $id);
        return $stmt->execute();
    }

    /**
     * Insert new contact message
     */
    public function insert($name, $email, $phone, $subject, $message) {
        $stmt = $this->conn->prepare("
            INSERT INTO contact_messages (name, email, phone, subject, message, status, created_at)
            VALUES (?, ?, ?, ?, ?, 'new', NOW())
        ");
        $stmt->bind_param('sssss', $name, $email, $phone, $subject, $message);
        return $stmt->execute();
    }

    /**
     * Mark message as read
     */
    public function markAsRead($id) {
        $stmt = $this->conn->prepare("UPDATE contact_messages SET status = 'read' WHERE id = ? AND status = 'new'");
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }
}
