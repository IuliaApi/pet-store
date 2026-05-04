<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Domain\Models\ProductsModel;
use App\Helpers\FlashMessage;
use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Admin Products controller
 *
 * Handles listing and (later) CRUD operations for products.
 */
class AdminProductsController extends BaseController
{
    public function __construct(
        Container $container,
        private ProductsModel $productsModel
    ) {
        parent::__construct($container);
    }

    public function index(Request $request, Response $response, array $args): Response
    {
        $products = $this->productsModel->getAll();

        $data = [
            'title' => 'Admin · Products',
            'username' => $_SESSION['username'] ?? 'Admin',
            'products' => $products,
        ];

        return $this->render($response, 'admin/products/productIndexView.php', $data);
    }

    public function create(Request $request, Response $response, array $args): Response
    {
        $types = $this->productsModel->getAllowedTypes();

        $data = [
            'title' => 'Admin · Create Product',
            'username' => $_SESSION['username'] ?? 'Admin',
            'types' => $types,
        ];

        return $this->render($response, 'admin/products/productCreateView.php', $data);
    }

    public function store(Request $request, Response $response, array $args): Response
    {
        [$clean, $errors] = $this->validateProductInput($request->getParsedBody() ?? []);

        if ($errors !== []) {
            foreach ($errors as $error) {
                FlashMessage::error($error);
            }

            return $this->redirect($request, $response, 'admin.products.create');
        }

        $this->productsModel->create($clean);
        FlashMessage::success('Product created successfully.');

        return $this->redirect($request, $response, 'admin.products.index');
    }

    public function edit(Request $request, Response $response, array $args): Response
    {
        $id = (int) ($args['id'] ?? 0);
        $product = $this->productsModel->getById($id);

        if ($product === false) {
            FlashMessage::error('Product not found.');
            return $this->redirect($request, $response, 'admin.products.index');
        }

        $types = $this->productsModel->getAllowedTypes();

        $data = [
            'title' => 'Admin · Edit Product',
            'username' => $_SESSION['username'] ?? 'Admin',
            'product' => $product,
            'types' => $types,
        ];

        return $this->render($response, 'admin/products/productEditView.php', $data);
    }

    public function update(Request $request, Response $response, array $args): Response
    {
        $id = (int) ($args['id'] ?? 0);
        $existing = $this->productsModel->getById($id);
        if ($existing === false) {
            FlashMessage::error('Product not found.');
            return $this->redirect($request, $response, 'admin.products.index');
        }

        [$clean, $errors] = $this->validateProductInput($request->getParsedBody() ?? []);

        if ($errors !== []) {
            foreach ($errors as $error) {
                FlashMessage::error($error);
            }

            return $this->redirect($request, $response, 'admin.products.edit', ['id' => $id]);
        }

        $this->productsModel->update($id, $clean);
        FlashMessage::success('Product updated successfully.');

        return $this->redirect($request, $response, 'admin.products.index');
    }

    public function delete(Request $request, Response $response, array $args): Response
    {
        $id = (int) ($args['id'] ?? 0);
        $existing = $this->productsModel->getById($id);
        if ($existing === false) {
            FlashMessage::error('Product not found.');
            return $this->redirect($request, $response, 'admin.products.index');
        }

        $this->productsModel->delete($id);
        FlashMessage::success('Product deleted successfully.');

        return $this->redirect($request, $response, 'admin.products.index');
    }

    /**
     * Basic server-side validation for product input.
     *
     * @return array{0: array<string,mixed>, 1: string[]} [cleanData, errors]
     */
    private function validateProductInput(array $input): array
    {
        $errors = [];
        $data = [];

        $data['name'] = trim((string)($input['name'] ?? ''));
        if ($data['name'] === '') {
            $errors[] = 'Product name is required.';
        } elseif (mb_strlen($data['name']) > 50) {
            $errors[] = 'Product name must be at most 50 characters.';
        }

        $stockRaw = trim((string)($input['stock'] ?? ''));
        if ($stockRaw === '' || !ctype_digit($stockRaw)) {
            $errors[] = 'Stock must be a non-negative whole number.';
        } else {
            $data['stock'] = (int) $stockRaw;
        }

        $allowedTypes = $this->productsModel->getAllowedTypes();
        $data['category'] = (string)($input['category_id'] ?? '');
        if (!in_array($data['type'], $allowedTypes, true)) {
            $errors[] = 'Please choose a valid product category.';
        }

        $data['brand'] = trim((string)($input['brand'] ?? ''));
        if ($data['brand'] === '') {
            $errors[] = 'Brand is required.';
        } elseif (mb_strlen($data['brand']) > 50) {
            $errors[] = 'Brand must be at most 50 characters.';
        }

        $priceRaw = trim((string)($input['price'] ?? ''));
        if ($priceRaw === '' || !is_numeric($priceRaw)) {
            $errors[] = 'Price must be a valid number.';
        } elseif ((float) $priceRaw < 0) {
            $errors[] = 'Price cannot be negative.';
        } else {
            $data['price'] = $priceRaw;
        }

        $data['thumbnail'] = trim((string)($input['thumbnail'] ?? ''));
        if ($data['thumbnail'] !== '' && mb_strlen($data['thumbnail']) > 50) {
            $errors[] = 'Thumbnail filename must be at most 50 characters.';
        }

        return [$data, $errors];
    }
}
