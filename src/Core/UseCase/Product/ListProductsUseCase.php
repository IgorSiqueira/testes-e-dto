<?php

namespace Core\UseCase\Product;

use Core\Domain\Repository\ProductRepositoryInterface;
use Core\UseCase\DTO\Product\ListProducts\ListProductsInputDto;
use Core\UseCase\DTO\Product\ListProducts\ListProductsOutputDto;

class ListProductsUseCase
{
    protected $repository;

    public function __construct(ProductRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(ListProductsInputDto $input): ListProductsOutputDto
    {
        $products = $this->repository->paginate(
            filter: $input->filter,
            order: $input->order,
            page: $input->page,
            totalPage: $input->totalPage,
        );

        return new ListProductsOutputDto(
            items: $products->items(),
            total: $products->total(),
            current_page: $products->currentPage(),
            last_page: $products->lastPage(),
            first_page: $products->firstPage(),
            per_page: $products->perPage(),
            to: $products->to(),
            from: $products->from(),
        );

       
    }
}
