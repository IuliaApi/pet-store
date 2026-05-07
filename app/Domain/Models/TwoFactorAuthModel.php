<?php

declare(strict_types=1);

namespace App\Domain\Models;

class TwoFactorAuthModel extends BaseModel
{
    public function findByUserId(int $userId): ?array
    {
        // TODO: Query the two_factor_auth table to find the record
        //       for the given user.
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
        $sql = "UPDATE two_factor_auth SET enable = :enable WHERE user_id = :user_id";
        $variables = ['enable' => true, 'user_id' => $userId];

        return ($this->execute($sql, $variables) > 0);
    }

    public function disable(int $userId): bool
    {
        // TODO: Update the record to mark 2FA as disabled.
    }

    public function isEnabled(int $userId): bool
    {
        // TODO: Check whether the user has 2FA enabled.
    }

    public function getSecret(int $userId): ?string
    {
        // TODO: Return the TOTP secret for the given user.
    }
}
