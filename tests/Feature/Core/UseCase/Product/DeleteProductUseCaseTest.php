<?php

namespace Tests\Feature\Core\UseCase\Product;

use App\Models\Product as Model;
use App\Repositories\Eloquent\ProductEloquentRepository;
use Core\UseCase\Product\DeleteProductUseCase;
use Core\UseCase\DTO\Product\ProductInputDto;
use Tests\TestCase;

class DeleteProductUseCaseTest extends TestCase
{
    public function test_delete()
    {
        $productDb = Model::factory()->create();
        $productId = $productDb->id;
        $repository = new ProductEloquentRepository(new Model());
        $useCase = new DeleteProductUseCase($repository);
        $useCase->execute(
            new ProductInputDto(
                id: $productDb->id
            )
        );

        $this->assertEmpty($productDb->firstWhere('id',$productDb->id));
    }
}
