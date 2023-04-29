<?php

namespace Core\UseCase\DTO\Product\CreateProduct;

class ProductCreateInputDto
{
    public function __construct(
        public string $name,
        public string $category_id
    
    ) {
    }
}
