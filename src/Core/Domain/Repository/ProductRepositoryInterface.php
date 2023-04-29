<?php

namespace Core\Domain\Repository;

use Core\Domain\Entity\Product;

interface ProductRepositoryInterface
{
    public function insert(Product $category): Product;

    public function findById(string $categoryId): Product;

    public function getIdsListIds(array $categoriesId = []): array;

    public function findAll(string $filter = '', $order = 'DESC'): array;

    public function paginate(string $filter = '', $order = 'DESC', int $page = 1, int $totalPage = 15): PaginationInterface;

    public function update(Product $category): Product;

    public function delete(string $categoryId): bool;
}
