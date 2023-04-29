<?php

namespace Core\UseCase\DTO\Product\UpdateProduct;

class ProductUpdateInputDto
{
    public function __construct(
        public string $id,
        public string $name,
        public string|null $category_id = null,
    ) {
    }
}
