<?php

class BookingRepository
{
    private mysqli $conn;

    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }

    public function create(array $data): int
    {
        $status = 'pending_payment';
        $stmt = $this->conn->prepare(
            "INSERT INTO bookings
            (customer_id, technician_id, air_conditioner_id, preferred_date, preferred_time, problem_description, emergency, status)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "iiisssis",
            $data['customer_id'],
            $data['technician_id'],
            $data['air_conditioner_id'],
            $data['preferred_date'],
            $data['preferred_time'],
            $data['problem_description'],
            $data['emergency'],
            $status
        );
        $stmt->execute();
        return (int) $this->conn->insert_id;
    }

    public function attachService(int $bookingId, int $serviceCategoryId, float $price): bool
    {
        $stmt = $this->conn->prepare(
            "INSERT INTO booking_services (booking_id, service_category_id, price) VALUES (?, ?, ?)"
        );
        $stmt->bind_param("iid", $bookingId, $serviceCategoryId, $price);
        return $stmt->execute();
    }

    public function getByCustomerId(int $customerId): array
    {
        $sql = "SELECT b.*, u.full_name AS technician_name, ac.nickname AS ac_name
                FROM bookings b
                LEFT JOIN technicians t ON t.id = b.technician_id
                LEFT JOIN users u ON u.id = t.user_id
                LEFT JOIN air_conditioners ac ON ac.id = b.air_conditioner_id
                WHERE b.customer_id = ?
                ORDER BY b.created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $customerId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getById(int $bookingId): ?array
    {
        $sql = "SELECT b.*, cu.full_name AS customer_name, u.full_name AS technician_name,
                       ac.nickname AS ac_name, ac.brand AS ac_brand, ac.model AS ac_model
                FROM bookings b
                LEFT JOIN customers c ON c.id = b.customer_id
                LEFT JOIN users cu ON cu.id = c.user_id
                LEFT JOIN technicians t ON t.id = b.technician_id
                LEFT JOIN users u ON u.id = t.user_id
                LEFT JOIN air_conditioners ac ON ac.id = b.air_conditioner_id
                WHERE b.id = ?
                LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $bookingId);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        return $row ?: null;
    }

    public function countByCustomerAndStatus(int $customerId, string $status): int
    {
        $stmt = $this->conn->prepare("SELECT COUNT(*) AS c FROM bookings WHERE customer_id = ? AND status = ?");
        $stmt->bind_param("is", $customerId, $status);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        return (int) ($row['c'] ?? 0);
    }

    public function getByTechnicianAndStatuses(int $technicianId, array $statuses): array
    {
        if (empty($statuses)) {
            return [];
        }
        $placeholders = implode(',', array_fill(0, count($statuses), '?'));
        $types = str_repeat('s', count($statuses));
        $sql = "SELECT b.*, u.full_name AS customer_name, ac.nickname AS ac_name
                FROM bookings b
                INNER JOIN customers c ON c.id = b.customer_id
                INNER JOIN users u ON u.id = c.user_id
                LEFT JOIN air_conditioners ac ON ac.id = b.air_conditioner_id
                WHERE b.technician_id = ? AND b.status IN ($placeholders)
                ORDER BY b.created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i{$types}", $technicianId, ...$statuses);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function updateStatus(int $bookingId, string $status, ?string $reason = null): bool
    {
        $stmt = $this->conn->prepare("UPDATE bookings SET status = ?, rejection_reason = ? WHERE id = ?");
        $stmt->bind_param("ssi", $status, $reason, $bookingId);
        return $stmt->execute();
    }

    public function getServiceNames(int $bookingId): string
    {
        $stmt = $this->conn->prepare(
            "SELECT GROUP_CONCAT(sc.name ORDER BY sc.name SEPARATOR ', ') AS names
             FROM booking_services bs
             INNER JOIN service_categories sc ON sc.id = bs.service_category_id
             WHERE bs.booking_id = ?"
        );
        $stmt->bind_param("i", $bookingId);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        return $row['names'] ?? '-';
    }
}

