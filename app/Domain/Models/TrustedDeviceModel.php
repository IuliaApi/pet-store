<?php

declare(strict_types=1);

namespace App\Domain\Models;

class TrustedDeviceModel extends BaseModel
{
    public function create(int $userId, string $deviceToken, array $deviceInfo): int
    {
        // Insert a new record into the trusted_devices table with the
        //       user ID, device token, and device info (name, user agent, IP address, expiration date).

        $sql = 'INSERT INTO trusted_devices (user_id, device_token, device_name, user_agent, ip_address, expires_at) VALUES (:user_id, :device_token, :device_name, :user_agent, :ip_address, :expires_at)';

        $variables = [
            'user_id' => $userId,
            'device_token' => $deviceToken,
            'device_name' => $deviceInfo['device_name'],
            'user_agent' => $deviceInfo['user_agent'],
            'ip_address' => $deviceInfo['ip_address'],
            'expires_at' => $deviceInfo['expires_at'],
        ];

        $this->execute($sql, $variables);
        return intval($this->lastInsertId());
    }

    public function isValid(string $deviceToken, int $userId): bool
    {
        // Check whether the token exists, belongs to the user and has not expired.

        $query = 'SELECT device_token FROM trusted_devices WHERE user_id = :user_id AND device_token = :device_token AND expires_at > CURRENT_TIMESTAMP';

        $variables = ['user_id' => $userId, 'device_token' => $deviceToken];

        $sql = $this->selectOne($query, $variables);
        return !is_bool($sql);
    }

    public function updateLastUsed(string $deviceToken): bool
    {
        // Update the last_used_at timestamp for the device.

        $sql = "UPDATE trusted_devices SET last_used_at = CURRENT_TIMESTAMP WHERE device_token = :device_token";

        $variables = ['device_token' => $deviceToken];

        return ($this->execute($sql, $variables) > 0);
    }

    public function getAllByUserId(int $userId): array
    {
        // Return all non-expired trusted devices for the user.

        $query = 'SELECT * FROM trusted_devices WHERE user_id = :user_id AND expires_at > CURRENT_TIMESTAMP';

        $variables = ['user_id' => $userId];
        return $this->selectAll($query, $variables);
    }

    public function revoke(int $deviceId, int $userId): bool
    {
        // Delete the device record. Include user_id in the WHERE clause to prevent unauthorized deletion.

        $sql = 'DELETE FROM trusted_devices WHERE id = :id AND user_id = :user_id';

        $variables = [
            'id' => $deviceId,
            'user_id' => $userId
        ];

        return ($this->execute($sql, $variables) > 0);
    }

    public function revokeAll(int $userId): bool
    {
        // Delete all trusted devices for the user.

        $sql = 'DELETE FROM trusted_devices WHERE user_id = :user_id';

        $variables = ['user_id' => $userId];

        return ($this->execute($sql, $variables) > 0);
    }
}
