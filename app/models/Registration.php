<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';

class Registration
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function create(
        string $full_name,
        string $contact_number,
        string $email,
        string $password,
        int $is_admin,
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
            $is_admin,
            $address
        ]);
    }

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }
}