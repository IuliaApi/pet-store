<?php

declare(strict_types=1);

namespace App\Domain\Models;

use App\Helpers\Core\PDOService;

class ProductsModel extends BaseModel
{
    public function __construct(PDOService $db_service)
    {
        parent::__construct($db_service);
    }

    public function getAll(string $sort = 'name', string $order = 'ASC'): array
    {
        $sortMap = [
            'name' => 'p.name',
            'price' => 'p.price',
            'stock' => 'p.stock_quantity',
        ];
        $sortColumn = $sortMap[$sort] ?? 'p.name';
        $sortDirection = strtoupper($order) === 'DESC' ? 'DESC' : 'ASC';

        return $this->selectAll("SELECT p.id, p.name, p.description, p.stock_quantity, p.category_id, p.brand, p.price, p.thumbnail, c.name AS category_name
        FROM products p
        LEFT JOIN categories c ON p.category_id = c.id
        ORDER BY {$sortColumn} {$sortDirection}, p.id DESC");
    }

    public function getById(int $id): array|false
    {
        return $this->selectOne('SELECT id, name, description, stock_quantity, category_id, brand, price, thumbnail FROM products WHERE id = :id', [
            'id' => $id,
        ]);
    }

    public function create(array $data): int
    {
        $sql = 'INSERT INTO products (name, description, stock_quantity, category_id, brand, price, thumbnail)
                VALUES (:name, :description, :stock_quantity, :category_id, :brand, :price, :thumbnail)';
        $this->execute($sql, [
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'stock_quantity' => $data['stock_quantity'],
            'category_id' => $data['category_id'],
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
                    description = :description,
                    stock_quantity = :stock_quantity,
                    category_id = :category_id,
                    brand = :brand,
                    price = :price,
                    thumbnail = :thumbnail
                WHERE id = :id';
        return $this->execute($sql, [
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'stock_quantity' => $data['stock_quantity'],
            'category_id' => $data['category_id'],
            'brand' => $data['brand'],
            'price' => $data['price'],
            'thumbnail' => $data['thumbnail'],
            'id' => $id,
        ]);
    }

    /**
     * Return categories list (id, name) for admin forms.
     *
     * @return array<int,array<string,mixed>>
     */
    public function getCategories(): array
    {
        return $this->selectAll('SELECT id, name FROM categories ORDER BY name ASC');
    }

    public function delete(int $id): int
    {
        $sql = 'DELETE FROM products WHERE id = :id';
        return $this->execute($sql, [
            'id' => $id,
        ]);
    }

    public function searchProducts(string $searchTerm = '', ?int $categoryId = null, string $sort = 'name', string $order = 'ASC'): array
    {
        $sql = "SELECT
            p.id,
            p.name,
            p.description,
            p.brand,
            p.price,
            p.thumbnail,
            p.stock_quantity,
            c.name AS category_name,
            c.id AS category_id,
            pi.file_path AS image_path
        FROM products p
        LEFT JOIN categories c ON p.category_id = c.id
        LEFT JOIN product_images pi ON p.id = pi.product_id AND pi.is_primary = 1
        WHERE 1=1";

        $params = [];
        // If searchTerm is not empty:
        if (!empty($searchTerm)) {
            $sql .= " AND (p.name LIKE :searchName OR p.description LIKE :searchDescription)";
            $params['searchName'] = "%$searchTerm%";
            $params['searchDescription'] = "%$searchTerm%";
        }

        // If categoryId is provided and > 0:
        if ($categoryId !== null && $categoryId > 0) {
            $sql .= " AND p.category_id = :category_id";
            $params['category_id'] = $categoryId;
        }

        $sortMap = [
            'name' => 'p.name',
            'price' => 'p.price',
            'stock' => 'p.stock_quantity',
        ];
        $sortColumn = $sortMap[$sort] ?? 'p.name';
        $sortDirection = strtoupper($order) === 'DESC' ? 'DESC' : 'ASC';

        $sql .= " GROUP BY p.id ORDER BY {$sortColumn} {$sortDirection}, p.id DESC";
        // Return results using $this->selectAll($sql, $params)
        return $this->selectAll($sql, $params);
    }
}
