<?php

declare(strict_types=1);

namespace App\Domain\Models;

use App\Domain\Enums\ProductCategory;
use App\Helpers\Core\PDOService;

class UserModel extends BaseModel
{
    public function __construct(PDOService $db_service)
    {
        parent::__construct($db_service);
    }
    public function createUser(array $data): int
    {
        // TODO: Hash the password before storing it
        // TODO: Insert the user into the database
        // TODO: Return the new user's ID
        $this->execute(
            'INSERT INTO users (first_name, last_name, username, email, password_hash)
         VALUES (:first_name, :last_name, :username, :email, :password_hash)',
            [
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'username' => $data['username'],
                'email' => $data['email'],
                'password_hash' => password_hash($data['password_hash'], PASSWORD_DEFAULT),
            ]
        );

        return intval($this->lastInsertId());
    }

    public function emailExists(string $email): bool
    {
        return !is_bool($this->selectOne('SELECT `id` FROM users WHERE email = ?', [$email]));
    }
}
