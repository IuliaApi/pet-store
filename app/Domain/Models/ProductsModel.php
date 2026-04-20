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

    public function searchProducts(string $searchTerm = '', ?int $categoryId = null): array
    {
        // TODO: Create base SQL query with LEFT JOINs
        // - LEFT JOIN categories (c) ON p.category_id = c.id
        // - LEFT JOIN product_images (pi) ON p.id = pi.product_id AND pi.is_primary = 1
        //   (the is_primary condition must be in the ON clause, not WHERE, to keep products without images)
        // - Select: p.id, p.name, p.description, p.price, p.stock_quantity,
        //          c.name AS category_name, c.id AS category_id, pi.file_path AS image_path
        // - Start with WHERE 1=1 to make adding conditions easier

        $sql = "SELECT p.id, p.name, p.description, p.price, p.stock_quantity,
              c.name AS category_name, c.id AS category_id, pi.file_path AS image_path FROM products p

     LEFT JOIN categories c ON p.category_id = c.id
     LEFT JOIN product_images pi ON p.id = pi.product_id AND pi.is_primary = 1
     WHERE 1=1";



        // TODO: Initialize empty params array
        // - Add condition: (p.name LIKE CONCAT('%', :search, '%') OR p.description LIKE CONCAT('%', :search, '%'))
        // - Add to params: 'search' => $searchTerm

        $params = [];
        // TODO: If searchTerm is not empty:
        if (!empty($searchTerm)) {
            $sql .= " AND (p.name LIKE CONCAT('%', :search, '%') OR p.description LIKE CONCAT('%', :search, '%'))";
            $params = ['search' => $searchTerm];
        }

        // TODO: If categoryId is provided and > 0:
        if ($categoryId !== null && $categoryId > 0) {
            $sql .= " AND .category_id = :category_id";
            $params = ['category_id' => $categoryId];
        }
        // - Add condition: p.category_id = :category_id
        // - Add to params: 'category_id' => $categoryId

        // TODO: Add GROUP BY p.id and ORDER BY p.name ASC
        $sql .= " GROUP BY p.id ORDER BY p.name ASC";
        // TODO: Return results using $this->selectAll($sql, $params)
        return $this->selectAll($sql, $params);
    }
}
