<?php

namespace Core\UseCase\DTO\Product\DeleteProduct;

class ProductDeleteOutputDto
{
    public function __construct(
        public bool $success
    ) {
    }
}
