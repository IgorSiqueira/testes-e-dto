<?php

namespace Core\UseCase\Product;

use Core\Domain\Repository\ProductRepositoryInterface;
use Core\UseCase\DTO\Product\ProductInputDto;
use Core\UseCase\DTO\Product\DeleteProduct\ProductDeleteOutputDto;

class DeleteProductUseCase
{
    protected $repository;

    public function __construct(ProductRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(ProductInputDto $input): ProductDeleteOutputDto
    {
        $responseDelete = $this->repository->delete($input->id);

        return new ProductDeleteOutputDto(
            success: $responseDelete
        );
    }
}
