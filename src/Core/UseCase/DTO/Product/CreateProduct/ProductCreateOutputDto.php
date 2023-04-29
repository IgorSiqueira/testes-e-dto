<?php

namespace Core\UseCase\DTO\Product\CreateProduct;

class ProductCreateOutputDto
{
    public function __construct(
        public string $id,
        public string $name,
        public string $category_id ,
    ) {
    }
}
