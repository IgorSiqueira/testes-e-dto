<?php

namespace Tests\Feature\Core\UseCase\Product;

use App\Models\Product as Model;
use App\Repositories\Eloquent\ProductEloquentRepository;
use Core\UseCase\Product\UpdateProductUseCase;
use Core\UseCase\DTO\Product\UpdateProduct\ProductUpdateInputDto;
use Tests\TestCase;

class UpdateProductUseCaseTest extends TestCase
{
    public function test_update()
    {
        $productDb = Model::factory()->create();

        $repository = new ProductEloquentRepository(new Model());
        $useCase = new UpdateProductUseCase($repository);
        $responseUseCase = $useCase->execute(
            new ProductUpdateInputDto(
                id: $productDb->id,
                name: 'name updated',
            )
        );
        
     
        $this->assertEquals('name updated', $responseUseCase->name);
        $this->assertEquals($productDb->category_id, $responseUseCase->category_id);
        $this->assertDatabaseHas('products', [
            'name' => $responseUseCase->name,
        ]);
    }
}
