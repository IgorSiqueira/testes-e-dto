<?php

namespace Core\UseCase\DTO\Category\UpdateCategory;

class CategoryUpdateInputDto
{
    public function __construct(
        public string $id,
        public string $name
    ) {
    }
}
