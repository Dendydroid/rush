<?php

namespace App\Component\Database;

use PDO;

class User extends BaseRepository
{
    public function findUserByEmail(string $email): ?array
    {
        $query = $this->db->prepare("SELECT * FROM users where email = :email LIMIT 1");
        $query->bindParam('email', $email);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return !empty($result) ? $result : null;
    }
}