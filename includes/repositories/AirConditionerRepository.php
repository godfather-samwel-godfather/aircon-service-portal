<?php

class AirConditionerRepository
{
    private mysqli $conn;

    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }

    public function create(int $customerId, array $data): int
    {
        $stmt = $this->conn->prepare(
            "INSERT INTO air_conditioners
            (customer_id, nickname, brand, model, serial_number, ac_type, cooling_capacity, installation_date, installation_address, notes)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "isssssssss",
            $customerId,
            $data['nickname'],
            $data['brand'],
            $data['model'],
            $data['serial_number'],
            $data['ac_type'],
            $data['cooling_capacity'],
            $data['installation_date'],
            $data['installation_address'],
            $data['notes']
        );

        $stmt->execute();
        return (int) $this->conn->insert_id;
    }
}

