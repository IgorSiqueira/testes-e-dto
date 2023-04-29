<?php

namespace Tests\Feature\Core\UseCase\Product;

use App\Models\Product as Model;
use App\Repositories\Eloquent\ProductEloquentRepository;
use Core\UseCase\Product\ListCategoriesUseCase;
use Core\UseCase\DTO\Product\ListCategories\ListCategoriesInputDto;
use Core\UseCase\DTO\Product\ListProducts\ListProductsInputDto;
use Core\UseCase\Product\ListProductsUseCase;
use Tests\TestCase;

class ListProductsUseCaseTest extends TestCase
{
    public function test_list_empty()
    {
        $responseUseCase = $this->createUseCase();

        $this->assertCount(0, $responseUseCase->items);
    }

    public function test_list_all()
    {
        $productsDb = Model::factory()->count(20)->create();

        $responseUseCase = $this->createUseCase();

        $this->assertCount(15, $responseUseCase->items);
        $this->assertEquals(count($productsDb), $responseUseCase->total);
    }

    private function createUseCase()
    {
        $repository = new ProductEloquentRepository(new Model());
        $useCase = new ListProductsUseCase($repository);

        return $useCase->execute(new ListProductsInputDto());
    }
}
