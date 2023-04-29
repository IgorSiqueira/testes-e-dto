<?php

namespace Core\UseCase\DTO\Category;

class CategoryOutupDto
{
    public function __construct(
        public string $id,
        public string $name
    ) {
    }
}
