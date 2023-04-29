<?php

namespace Core\UseCase\Product;

use Core\Domain\Entity\Product;
use Core\Domain\Repository\ProductRepositoryInterface;
use Core\UseCase\DTO\Product\CreateProduct\ProductCreateInputDto;
use Core\UseCase\DTO\Product\CreateProduct\ProductCreateOutputDto;

class CreateProductUseCase
{
    protected $repository;

    public function __construct(ProductRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(ProductCreateInputDto $input): ProductCreateOutputDto
    {
        $product = new Product(
            name: $input->name, 
            category_id:$input->category_id,
        );
      
        $newProduct = $this->repository->insert($product);

        return new ProductCreateOutputDto(
            id: $newProduct->id(),
            name: $newProduct->name,
            category_id: $newProduct->category_id
        );
    }
}
