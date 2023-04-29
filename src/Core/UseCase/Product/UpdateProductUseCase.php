<?php

namespace Core\UseCase\Product;

use Core\Domain\Repository\ProductRepositoryInterface;
use Core\UseCase\DTO\Product\UpdateProduct\ProductUpdateInputDto;
use Core\UseCase\DTO\Product\UpdateProduct\ProductUpdateOutputDto;

class UpdateProductUseCase
{
    protected $repository;

    public function __construct(ProductRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(ProductUpdateInputDto $input): ProductUpdateOutputDto
    {
        $product = $this->repository->findById($input->id);
        $categoryId = $product->category_id;
        if($input->category_id){
            $categoryId = $input->category_id;  
        };
       
        $product->update(
            name: $input->name,
            category_id:$categoryId
        );
       
        $productUpdated = $this->repository->update($product);
       
        return new ProductUpdateOutputDto(
            id: $productUpdated->id,
            name: $productUpdated->name,
            category_id:$productUpdated->category_id
        );
    }
}
