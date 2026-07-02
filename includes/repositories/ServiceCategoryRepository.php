<?php

class ServiceCategoryRepository
{
    private mysqli $conn;

    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }

    public function getActive(): array
    {
        $sql = "SELECT id, name, image, description, price, status
                FROM service_categories
                WHERE status = 'active'
                ORDER BY id DESC";
        $result = $this->conn->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function getAll(): array
    {
        $sql = "SELECT id, name, image, description, price, status, created_at
                FROM service_categories
                ORDER BY id DESC";
        $result = $this->conn->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function create(string $name, ?string $description, float $price, ?string $image): bool
    {
        $status = 'active';
        $stmt = $this->conn->prepare(
            "INSERT INTO service_categories (name, image, description, price, status) VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->bind_param("sssds", $name, $image, $description, $price, $status);
        return $stmt->execute();
    }
}

