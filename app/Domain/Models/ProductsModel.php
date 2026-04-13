<?php

declare(strict_types=1);

namespace App\Domain\Models;

use App\Domain\Enums\ProductCategory;
use App\Helpers\Core\PDOService;

class ProductsModel extends BaseModel
{
    public function __construct(PDOService $db_service)
    {
        parent::__construct($db_service);
    }

    public function getAll(): array
    {
        return $this->selectAll('SELECT * FROM products ORDER BY id DESC');
    }

    public function getById(int $id): array|false
    {
        return $this->selectOne('SELECT * FROM products WHERE id = :id', [
            'id' => $id,
        ]);
    }

    public function create(array $data): int
    {
        $sql = 'INSERT INTO products (name, stock, type, brand, price, thumbnail)
                VALUES (:name, :stock, :type, :brand, :price, :thumbnail)';
        $this->execute($sql, [
            'name' => $data['name'],
            'stock' => $data['stock'],
            'type' => $data['type'],
            'brand' => $data['brand'],
            'price' => $data['price'],
            'thumbnail' => $data['thumbnail'],
        ]);

        return (int) $this->lastInsertId();
    }

    public function update(int $id, array $data): int
    {
        $sql = 'UPDATE products
                SET name = :name,
                    stock = :stock,
                    type = :type,
                    brand = :brand,
                    price = :price,
                    thumbnail = :thumbnail
                WHERE id = :id';
        return $this->execute($sql, [
            'name' => $data['name'],
            'stock' => $data['stock'],
            'type' => $data['type'],
            'brand' => $data['brand'],
            'price' => $data['price'],
            'thumbnail' => $data['thumbnail'],
            'id' => $id,
        ]);
    }

    public function delete(int $id): int
    {
        $sql = 'DELETE FROM products WHERE id = :id';
        return $this->execute($sql, [
            'id' => $id,
        ]);
    }

    /**
     * Get all allowed product category values from the enum.
     *
     * @return string[]
     */
    public function getAllowedTypes(): array
    {
        return ProductCategory::values();
    }

}
