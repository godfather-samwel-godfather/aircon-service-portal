<?php

class PaymentRepository
{
    private mysqli $conn;

    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }

    public function createPending(int $bookingId, float $amount): bool
    {
        $method = 'manual';
        $reference = 'PENDING-' . $bookingId . '-' . time();
        $status = 'pending';
        $stmt = $this->conn->prepare(
            "INSERT INTO payments (booking_id, amount, payment_method, transaction_reference, status)
             VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->bind_param("idsss", $bookingId, $amount, $method, $reference, $status);
        return $stmt->execute();
    }

    public function getByBookingId(int $bookingId): ?array
    {
        $stmt = $this->conn->prepare("SELECT * FROM payments WHERE booking_id = ? ORDER BY id DESC LIMIT 1");
        $stmt->bind_param("i", $bookingId);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        return $row ?: null;
    }

    public function markPaid(int $bookingId): bool
    {
        $status = 'paid';
        $reference = 'TXN-' . $bookingId . '-' . time();
        $stmt = $this->conn->prepare(
            "UPDATE payments
             SET status = ?, transaction_reference = ?, paid_at = NOW()
             WHERE booking_id = ?"
        );
        $stmt->bind_param("ssi", $status, $reference, $bookingId);
        return $stmt->execute();
    }
}

