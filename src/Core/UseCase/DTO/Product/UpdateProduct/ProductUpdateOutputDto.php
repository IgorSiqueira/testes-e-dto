<?php

namespace Core\UseCase\DTO\Product\UpdateProduct;

class ProductUpdateOutputDto
{
    public function __construct(
        public string $id,
        public string $name,
        public string $category_id
    ) {
    }
}
