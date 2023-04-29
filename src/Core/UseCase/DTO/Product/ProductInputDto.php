<?php

namespace Core\UseCase\DTO\Product;

class ProductInputDto
{
    public function __construct(
        public string $id,
    ) {
    }
}
