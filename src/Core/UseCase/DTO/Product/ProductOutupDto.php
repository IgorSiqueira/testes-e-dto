<?php

namespace Core\UseCase\DTO\Product;

class ProductOutupDto
{
    public function __construct(
        public string $id,
        public string $name,
        public string $category_id
    ) {
    }
}
