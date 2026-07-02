<?php

class TechnicianRepository
{
    private mysqli $conn;

    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }

    public function getApprovedForPublic(): array
    {
        $sql = "SELECT t.id, t.company_name, t.years_experience, t.license_number, t.national_id,
                       t.specialization, t.service_radius, t.verification_status,
                       u.full_name, u.email, u.phone
                FROM technicians t
                INNER JOIN users u ON u.id = t.user_id
                WHERE t.verification_status = 'approved' AND u.status = 'active'
                ORDER BY t.id DESC";
        $result = $this->conn->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function getApprovedList(): array
    {
        $sql = "SELECT t.id, u.full_name, t.specialization, t.service_radius
                FROM technicians t
                INNER JOIN users u ON u.id = t.user_id
                WHERE t.verification_status = 'approved' AND u.status = 'active'
                ORDER BY u.full_name ASC";
        $result = $this->conn->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function getByUserId(int $userId): ?array
    {
        $stmt = $this->conn->prepare("SELECT * FROM technicians WHERE user_id = ? LIMIT 1");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        return $row ?: null;
    }

    public function setVerificationByUser(int $userId, string $verificationStatus): bool
    {
        $stmt = $this->conn->prepare("UPDATE technicians SET verification_status = ? WHERE user_id = ?");
        $stmt->bind_param("si", $verificationStatus, $userId);
        return $stmt->execute();
    }
}

