<?php

namespace Core\UseCase\Category;

use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\UseCase\DTO\Category\UpdateCategory\CategoryUpdateInputDto;
use Core\UseCase\DTO\Category\UpdateCategory\CategoryUpdateOutputDto;

class UpdateCategoryUseCase
{
    protected $repository;

    public function __construct(CategoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(CategoryUpdateInputDto $input): CategoryUpdateOutputDto
    {
        $category = $this->repository->findById($input->id);

        $category->update(
            name: $input->name,
        );

        $categoryUpdated = $this->repository->update($category);

        return new CategoryUpdateOutputDto(
            id: $categoryUpdated->id,
            name: $categoryUpdated->name
        );
    }
}
