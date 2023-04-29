<?php

namespace Tests\Feature\Core\UseCase\Product;

use App\Models\Product as Model;
use App\Repositories\Eloquent\ProductEloquentRepository;
use Core\UseCase\Product\ListProductUseCase;
use Core\UseCase\DTO\Product\ProductInputDto;
use Tests\TestCase;

class ListProductUseCaseTest extends TestCase
{
    public function test_list()
    {
        $productDb = Model::factory()->create();

        $repository = new ProductEloquentRepository(new Model());
        $useCase = new ListProductUseCase($repository);
        $responseUseCase = $useCase->execute(
            new ProductInputDto(id: $productDb->id)
        );

        $this->assertEquals($productDb->id, $responseUseCase->id);
        $this->assertEquals($productDb->name, $responseUseCase->name);
    }
}
