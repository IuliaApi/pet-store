<?php

declare(strict_types=1);

namespace App\Domain\Models;

use App\Domain\Enums\ProductCategory;
use App\Helpers\Core\PDOService;
use function intval;

class UserModel extends BaseModel
{
    public function __construct(PDOService $db_service)
    {
        parent::__construct($db_service);
    }
    public function createUser(array $data): int
    {
        $this->execute(
            'INSERT INTO users (first_name, last_name, username, email, password_hash)
         VALUES (:first_name, :last_name, :username, :email, :password_hash)',
            [
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'username' => $data['username'],
                'email' => $data['email'],
                'password_hash' => password_hash($data['password'], PASSWORD_DEFAULT),
            ]
        );

        return intval($this->lastInsertId());
    }

    public function findByEmail(string $email): ?array
    {
        // TODO: Look up a single user by their email address
        //     Return the user data or null if not found
        $sql = 'SELECT * FROM users WHERE email = :email';
        $result = $this->selectOne($sql, [':email' => $email]);

        if (is_bool($result)) {
            return null;
        } else {
            return $result;
        }
    }
    public function emailExists(string $email): bool
    {
        return !is_bool($this->selectOne("SELECT 'id' FROM users WHERE email = ?", [$email]));
    }

    public function usernameExists(string $username): bool
    {
        return !is_bool($this->selectOne("SELECT 'id' FROM users WHERE username = ?", [$username]));
    }

    public function findByUsername(string $username): ?array
    {
        $sql = 'SELECT * FROM users WHERE username = :username';
        $result = $this->selectOne($sql, [':username' => $username]);

        if (is_bool($result)) {
            return null;
        } else {
            return $result;
        }
    }

    /**
     * Verify user credentials by email/username and password.
     *
     * @param string $identifier Email or username
     * @param string $password Plain-text password to verify
     * @return array|null User data if credentials are valid, null otherwise
     */
    public function verifyCredentials(string $identifier, string $password): ?array
    {
        // TODO: Look up the user by their identifier (try email first, then username).
        //       If found, verify the password against the stored hash.
        //       Return the user data on success or null on failure.
        $user_data = $this->findByEmail($identifier);
        if (is_null($user_data)) {
            $user_data = $this->findByUsername($identifier);
            if (is_null($user_data))
                return $user_data;
        }
        if (password_verify($password, $user_data['password_hash']))
            return $user_data;
        else return null;
    }
}
