<?php

namespace Tests\Feature\App\Http\Controllers\Api;

use App\Http\Controllers\Api\ProductController;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Repositories\Eloquent\ProductEloquentRepository;
use Core\UseCase\Product\CreateProductUseCase;
use Core\UseCase\Product\DeleteProductUseCase;
use Core\UseCase\Product\ListProductsUseCase;
use Core\UseCase\Product\ListProductUseCase;
use Core\UseCase\Product\UpdateProductUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\ParameterBag;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    protected $repository;

    protected $controller;

    protected function setUp(): void
    {
        $this->repository = new ProductEloquentRepository(
            new Product()
        );
        $this->controller = new ProductController();

        parent::setUp();
    }

    public function test_index()
    {
        $useCase = new ListProductsUseCase($this->repository);

        $response = $this->controller->index(new Request(), $useCase);

        $this->assertInstanceOf(AnonymousResourceCollection::class, $response);
        $this->assertArrayHasKey('meta', $response->additional);
    }

    public function test_store()
    {
        $useCase = new CreateProductUseCase($this->repository);
        $category = Category::factory()->create();
        $request = new StoreProductRequest();
        $request->headers->set('content-type', 'application/json');
        $request->setJson(new ParameterBag([
            'name' => 'Teste',
            'category_id'=>$category->id
        ]));

        $response = $this->controller->store($request, $useCase);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_CREATED, $response->status());
    }

    public function test_show()
    {
        $product = Product::factory()->create();

        $response = $this->controller->show(
            useCase: new ListProductUseCase($this->repository),
            id: $product->id,
        );

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_OK, $response->status());
    }

    public function test_update()
    {
        $product = Product::factory()->create();
        $category = Category::factory()->create();

        $request = new UpdateProductRequest();
        $request->headers->set('content-type', 'application/json');
        $request->setJson(new ParameterBag([
            'name' => 'Updated',
            'category_id'=>$category->id
        ]));
        

        $response = $this->controller->update(
            request: $request,
            useCase: new UpdateProductUseCase($this->repository),
            id: $product->id
        );
        
       
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_OK, $response->status());
        $this->assertDatabaseHas('products', ['id'=>$product->id]);
    }

    public function test_delete()
    {
        $product = Product::factory()->create();

        $response = $this->controller->destroy(
            useCase: new DeleteProductUseCase($this->repository),
            id: $product->id
        );

        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->status());
    }
}
