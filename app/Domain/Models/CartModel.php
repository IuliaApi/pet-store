<?php

declare(strict_types=1);

namespace App\Domain\Models;

use App\Helpers\Core\PDOService;
use Override;
use function is_array;

class CartModel extends BaseModel
{
    public function __construct(PDOService $db_service)
    {
        return parent::__construct($db_service);
    }

    public function getCartByUser(int $id): array
    {
        $sql = 'SELECT
            `cart_listings`.`product_id`,
            `cart_listings`.`product_amount`,
            `products`.`id`,
            `products`.`name`,
            `products`.`description`,
            `products`.`brand`,
            `products`.`price`,
            `products`.`thumbnail`
            FROM `cart_listings`
            LEFT JOIN `products` ON `cart_listings`.`product_id` = `products`.`id`
            WHERE `cart_listings`.`customer_id` = :id';
        return $this->selectAll($sql, ['id' => $id]);
    }
    /**
     * Summary of addItem
     * @param int $userId
     * @param int $productId
     * @param int $qty
     * @return int returns amount of rows affected by sql, NOT id of item added. In other words 1 if success, 0 if failed
     */
    public function addItem(int $userId, int $productId, int $qty = 1): int
    {
        $sql = "
        INSERT INTO cart_listings (user_id, product_id, product_amount)
        VALUES (:userId, :productId, :qty)
        ON DUPLICATE KEY UPDATE
        product_amount = GREATEST(1, product_amount + :qty)
    ";

        $params = [
            'userId' => $userId,
            'productId' => $productId,
            'qty' => $qty
        ];

        return $this->execute($sql, $params);
    }

    public function updateQuantity(int $userId, int $productId, int $updatedQuantity)
    {

        if ($updatedQuantity <= 0) {
            return $this->removeItem($userId, $productId);
        }
        $sql = 'UPDATE cart_listings
                SET product_amount = :qty
                WHERE user_id = :userId AND product_id = :productId';
        $params = [
            'qty' => $updatedQuantity,
            'userId' => $userId,
            'productId' => $productId
        ];
        return $this->execute($sql, $params);
    }

    public function removeItem(int $userId, int $productId): int
    {
        $sql = 'DELETE FROM cart_listings WHERE user_id = :userId AND product_id = :productId';

        return $this->execute($sql, [
            'userId' => $userId,
            'productId' => $productId
        ]);
    }

    public function clearCart(int $userId): int
    {
        $sql = 'DELETE FROM cart_listings WHERE user_id = :userId';

        return $this->execute($sql, ['userId' => $userId]);
    }
}
