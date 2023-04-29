<?php

namespace Core\UseCase\Product;

use Core\Domain\Repository\ProductRepositoryInterface;
use Core\UseCase\DTO\Product\ProductInputDto;
use Core\UseCase\DTO\Product\ProductOutupDto;

class ListProductUseCase
{
    protected $repository;

    public function __construct(ProductRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(ProductInputDto $input): ProductOutupDto
    {
        $product = $this->repository->findById($input->id);

        return new ProductOutupDto(
            id: $product->id(),
            name: $product->name,
            category_id:$product->category_id
        );
    }
}
