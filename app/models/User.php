<?php

declare(strict_types=1);

class User
{
    private PDO $db;

    public function __construct()
    {

    require_once __DIR__ . '/../config/database.php';
        $this->db = Database::getConnection();
    }

    public function all(): array
    {
        $stmt = $this->db->query("SELECT * FROM users ORDER BY client_id ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?? [];
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE client_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function create(
        string $full_name,
        string $contact_number,
        string $email,
        string $password,
        bool $is_admin,
        string $address
    ): bool {
        $stmt = $this->db->prepare("
            INSERT INTO users 
            (full_name, contact_number, email, password, is_admin, address)
            VALUES (?, ?, ?, ?, ?, ?)
        ");

        return $stmt->execute([
            $full_name,
            $contact_number,
            $email,
            $password,
            $is_admin ? 1 : 0,
            $address
        ]);
    }

    public function update(
        int $id,
        string $full_name,
        string $contact_number,
        string $email,
        bool $is_admin,
        string $address
    ): bool {
        $stmt = $this->db->prepare("
            UPDATE users 
            SET full_name = ?, contact_number = ?, email = ?, is_admin = ?, address = ?
            WHERE client_id = ?
        ");

        return $stmt->execute([
            $full_name,
            $contact_number,
            $email,
            $is_admin ? 1 : 0,
            $address,
            $id
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM users WHERE client_id = ?");
        return $stmt->execute([$id]);
    }

    public function updateProfile(int $id, string $name, string $email, string $phone, string $address = ''): bool
    {
        $stmt = $this->db->prepare("
            UPDATE users 
            SET full_name = ?, email = ?, contact_number = ?, address = ?
            WHERE client_id = ?
        ");

        return $stmt->execute([$name, $email, $phone, $address, $id]);
    }

    public function updatePassword(int $id, string $hashedPassword): bool
    {
        $stmt = $this->db->prepare("
            UPDATE users 
            SET password = ?
            WHERE client_id = ?
        ");

        return $stmt->execute([$hashedPassword, $id]);
    }
}