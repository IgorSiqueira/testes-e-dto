<?php

namespace Tests\Feature\Core\UseCase\Product;

use App\Models\Category;
use App\Models\Product as Model;
use App\Repositories\Eloquent\ProductEloquentRepository;
use Core\UseCase\Product\CreateProductUseCase;
use Core\UseCase\DTO\Product\CreateProduct\ProductCreateInputDto;
use Tests\TestCase;

class CreateProductUseCaseTest extends TestCase
{
    public function test_create()
    {
        $category = Category::factory()->create();
        $repository = new ProductEloquentRepository(new Model());
        $useCase = new CreateProductUseCase($repository);
        $responseUseCase = $useCase->execute(
            new ProductCreateInputDto(
                name: 'Teste',
                category_id:$category->id
            )
        );
        $this->assertEquals('Teste', $responseUseCase->name);
        $this->assertNotEmpty($responseUseCase->id);
        $this->assertDatabaseHas('products', [
            'id' => $responseUseCase->id,
        ]);
    }
}
