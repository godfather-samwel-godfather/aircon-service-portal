<?php

class FaultReportRepository
{
    private mysqli $conn;

    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }

    public function create(int $customerId, int $airConditionerId, string $faultCategory, string $description, ?string $media, string $urgencyLevel): int
    {
        $status = 'new';
        $stmt = $this->conn->prepare(
            "INSERT INTO fault_reports
            (customer_id, air_conditioner_id, fault_category, description, media, urgency_level, status)
            VALUES (?, ?, ?, ?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "iisssss",
            $customerId,
            $airConditionerId,
            $faultCategory,
            $description,
            $media,
            $urgencyLevel,
            $status
        );
        $stmt->execute();
        return (int) $this->conn->insert_id;
    }

    public function getByCustomer(int $customerId): array
    {
        $sql = "SELECT fr.*, ac.nickname AS ac_name, ac.brand, ac.model
                FROM fault_reports fr
                INNER JOIN air_conditioners ac ON ac.id = fr.air_conditioner_id
                WHERE fr.customer_id = ?
                ORDER BY fr.created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $customerId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getUnitsByCustomer(int $customerId): array
    {
        $stmt = $this->conn->prepare(
            "SELECT id, nickname, brand, model
             FROM air_conditioners
             WHERE customer_id = ?
             ORDER BY created_at DESC"
        );
        $stmt->bind_param("i", $customerId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getById(int $id): ?array
    {
        $stmt = $this->conn->prepare(
            "SELECT fr.*, ac.nickname AS ac_name, ac.brand, ac.model
             FROM fault_reports fr
             INNER JOIN air_conditioners ac ON ac.id = fr.air_conditioner_id
             WHERE fr.id = ? LIMIT 1"
        );
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        return $row ?: null;
    }
}
