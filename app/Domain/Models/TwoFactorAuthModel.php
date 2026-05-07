<?php

declare(strict_types=1);

namespace App\Domain\Models;

class TwoFactorAuthModel extends BaseModel
{
    public function findByUserId(int $userId): ?array
    {
        // TODO: Query the two_factor_auth table to find the record
        //       for the given user.
        $result = $this->selectOne('SELECT * FROM two_factor_auth WHERE user_id = :userId', ['userId' => $userId]);
        if ($result === false)
            return null;
        else return $result;
    }

    public function create(int $userId, string $secret): int
    {
        // TODO: Insert a new 2FA record with the user ID and secret.
        //       Return the ID of the created record.
    }

    public function enable(int $userId): bool
    {
        // TODO: Update the record to mark 2FA as enabled and set
        //       the enabled timestamp.
        $sql = "UPDATE two_factor_auth SET enabled = :enabled WHERE user_id = :user_id";
        $variables[] = ['enabled' => true, 'user_id' => $userId];

        return ($this->execute($sql, $variables) > 0);
    }

    public function disable(int $userId): bool
    {
        // TODO: Update the record to mark 2FA as disabled.
        return ($this->execute('UPDATE two_factor_auth SET enabled = 0 WHERE user_id = :userId', ['userId' => $userId]) === 1);
    }

    public function isEnabled(int $userId): bool
    {
        // TODO: Check whether the user has 2FA enabled.
    }

    public function getSecret(int $userId): ?string
    {
        // TODO: Return the TOTP secret for the given user.
        $sql = "SELECT secret FROM two_factor_auth WHERE username user_id = :user_id";
        $variables[] = ['user_id' => $userId];

        return $this->selectOne($sql, $variables)[0];
    }
}
