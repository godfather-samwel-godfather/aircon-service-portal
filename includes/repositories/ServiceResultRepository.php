<?php

class ServiceResultRepository
{
    private mysqli $conn;

    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }

    public function create(int $bookingId, int $technicianId, int $customerId, ?string $beforeImage, ?string $afterImage, string $workReport, string $partsUsed, ?string $signatureImage): int
    {
        // Ensure table exists before inserting to avoid fatal errors
        if (!$this->tableExists('service_results')) {
            // Attempt to create the table (safe: CREATE TABLE IF NOT EXISTS)
            $createSql = "CREATE TABLE IF NOT EXISTS service_results (
                id INT AUTO_INCREMENT PRIMARY KEY,
                booking_id INT NOT NULL,
                technician_id INT NOT NULL,
                customer_id INT NOT NULL,
                before_image VARCHAR(255),
                after_image VARCHAR(255),
                work_report TEXT,
                parts_used TEXT,
                signature_image VARCHAR(255),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (booking_id) REFERENCES bookings(id) ON DELETE CASCADE,
                FOREIGN KEY (technician_id) REFERENCES technicians(id),
                FOREIGN KEY (customer_id) REFERENCES customers(id)
            )";
            $this->conn->query($createSql);
            // If creation failed, return 0 to indicate failure
            if (!$this->tableExists('service_results')) {
                return 0;
            }
        }

        $stmt = $this->conn->prepare(
            "INSERT INTO service_results
            (booking_id, technician_id, customer_id, before_image, after_image, work_report, parts_used, signature_image)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "iiisssss",
            $bookingId,
            $technicianId,
            $customerId,
            $beforeImage,
            $afterImage,
            $workReport,
            $partsUsed,
            $signatureImage
        );

        $stmt->execute();
        return (int) $this->conn->insert_id;
    }

    /**
     * Check whether a table exists in the current database
     */
    private function tableExists(string $table): bool
    {
        $stmt = $this->conn->prepare("SELECT 1 FROM information_schema.tables WHERE table_schema = DATABASE() AND table_name = ? LIMIT 1");
        $stmt->bind_param('s', $table);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res ? $res->fetch_assoc() : null;
        return (bool) $row;
    }

    public function getByBookingId(int $bookingId): ?array
    {
        if (!$this->tableExists('service_results')) {
            return null;
        }

        $stmt = $this->conn->prepare(
            "SELECT sr.*, u.full_name AS technician_name, ac.nickname AS ac_name
             FROM service_results sr
             INNER JOIN technicians t ON t.id = sr.technician_id
             INNER JOIN users u ON u.id = t.user_id
             INNER JOIN bookings b ON b.id = sr.booking_id
             INNER JOIN air_conditioners ac ON ac.id = b.air_conditioner_id
             WHERE sr.booking_id = ? LIMIT 1"
        );
        $stmt->bind_param("i", $bookingId);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        return $row ?: null;
    }

    public function getByCustomer(int $customerId): array
    {
        if (!$this->tableExists('service_results')) {
            return [];
        }

        $sql = "SELECT sr.*, b.preferred_date, b.preferred_time, b.status AS booking_status,
                       ac.nickname AS ac_name, ac.brand, ac.model,
                       u.full_name AS technician_name
                FROM service_results sr
                INNER JOIN bookings b ON b.id = sr.booking_id
                INNER JOIN air_conditioners ac ON ac.id = b.air_conditioner_id
                INNER JOIN technicians t ON t.id = sr.technician_id
                INNER JOIN users u ON u.id = t.user_id
                WHERE sr.customer_id = ?
                ORDER BY sr.created_at DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $customerId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function existsForBooking(int $bookingId): bool
    {
        if (!$this->tableExists('service_results')) {
            return false;
        }

        $stmt = $this->conn->prepare("SELECT id FROM service_results WHERE booking_id = ? LIMIT 1");
        $stmt->bind_param("i", $bookingId);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        return (bool) $row;
    }
}
