<?php

namespace Tests\Feature\App\Repositories\Eloquent;

use App\Models\Category;
use App\Models\Product;
use App\Models\Product as Model;
use App\Repositories\Eloquent\ProductEloquentRepository;
use Core\Domain\Entity\Product as EntityProduct;
use Core\Domain\Exception\NotFoundException;
use Core\Domain\Repository\ProductRepositoryInterface;
use Core\Domain\Repository\PaginationInterface;
use Tests\TestCase;
use Throwable;

class ProductEloquentRepositoryTest extends TestCase
{
    protected $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = new ProductEloquentRepository(new Model());
    }

    public function testInsert()
    {
        $category = Category::factory()->create();
        $entity = new EntityProduct(
            name: 'Teste',
            category_id:$category->id
        );

        $response = $this->repository->insert($entity);

        $this->assertInstanceOf(ProductRepositoryInterface::class, $this->repository);
        $this->assertInstanceOf(EntityProduct::class, $response);
        $this->assertDatabaseHas('products', [
            'name' => $entity->name,
        ]);
    }

    public function testFindById()
    {
        $product = Model::factory()->create();
        $response = $this->repository->findById($product->id);

        $this->assertInstanceOf(EntityProduct::class, $response);
        $this->assertEquals($product->id, $response->id());
    }

    public function testFindByIdNotFound()
    {
        try {
            $this->repository->findById('fakeValue');

            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(NotFoundException::class, $th);
        }
    }

    public function testFindAll()
    {
        $categories = Model::factory()->count(50)->create();

        $response = $this->repository->findAll();

        $this->assertEquals(count($categories), count($response));
    }

    public function testPaginate()
    {
        Model::factory()->count(20)->create();

        $response = $this->repository->paginate();

        $this->assertInstanceOf(PaginationInterface::class, $response);
        $this->assertCount(15, $response->items());
    }

    public function testPaginateWithout()
    {
        $response = $this->repository->paginate();

        $this->assertInstanceOf(PaginationInterface::class, $response);
        $this->assertCount(0, $response->items());
    }

    public function testUpdateIdNotFound()
    {
        try {
            $product = new EntityProduct(name: 'test');
            $this->repository->update($product);

            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(NotFoundException::class, $th);
        }
    }

    public function testUpdate()
    {
        $productDb = Product::factory()->create();
        
        $product = new EntityProduct(
            id: $productDb->id,
            name: 'updated name',
            category_id:$productDb->category_id
        );
      
        $response = $this->repository->update($product);
        
        $this->assertInstanceOf(EntityProduct::class, $response);
        $this->assertNotEquals($response->name, $productDb->name);
        $this->assertEquals('updated name', $response->name);
    }

    public function testDeleteIdNotFound()
    {
        try {
            $this->repository->delete('fake_id');

            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(NotFoundException::class, $th);
        }
    }

    public function testDelete()
    {
        $productDb = Product::factory()->create();

        $response = $this->repository
                            ->delete($productDb->id);

        $this->assertTrue($response);
    }
}
