<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use App\Models\Product;

use Illuminate\Http\Response;
use Tests\TestCase;
use Tests\Traits\WithoutMiddlewareTrait;

class ProductApiTest extends TestCase
{
    use WithoutMiddlewareTrait;

    protected $endpoint = '/api/products';

    public function test_list_empty_products()
    {
        $response = $this->getJson($this->endpoint);
       
        $response->assertStatus(200);
        $response->assertJsonCount(0, 'data');
    }

    public function test_list_all_products()
    {
      
        Product::factory()->count(30)->create();
        
        $response = $this->getJson($this->endpoint);
       
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'meta' => [
                'total',
                'current_page',
                'last_page',
                'first_page',
                'per_page',
                'to',
                'from',
            ],
        ]);
        $response->assertJsonCount(15, 'data');
    }

    public function test_list_paginate_products()
    {
        Product::factory()->count(25)->create();

        $response = $this->getJson("$this->endpoint?page=2");

        $response->assertStatus(200);
        $this->assertEquals(2, $response['meta']['current_page']);
        $this->assertEquals(25, $response['meta']['total']);
        $response->assertJsonCount(10, 'data');
    }

    public function test_list_product_notfound()
    {
        $response = $this->getJson("$this->endpoint/fake_value");

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_list_product()
    {
        $product = Product::factory()->create();

        $response = $this->getJson("$this->endpoint/{$product->id}");

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'data' => [ 
                'name',
                'category_id'
            ],
        ]);
        $this->assertEquals($product->id, $response['data']['id']);
    }

    public function test_validations_store()
    {
        $data = [];

        $response = $this->postJson($this->endpoint, $data);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'name',
            ],
        ]);
    }

    public function test_store()
    {
        $category = Category::factory()->create();
        $data = [
            'name' => 'New Product',
            'category_id'=>$category->id
        ];

        $response = $this->postJson($this->endpoint, $data);

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJsonStructure([
            'data' => [
                'name',
                'category_id'
            ],
        ]);

        $response = $this->postJson($this->endpoint, [
            'name' => 'New Cat',
            'category_id'=>$category->id
        ]);
        $response->assertStatus(Response::HTTP_CREATED);
        $this->assertEquals('New Cat', $response['data']['name']);
        $this->assertEquals($category->id, $response['data']['category_id']);
        $this->assertDatabaseHas('products', [
            'id' => $response['data']['id']
        ]);
    }

    public function test_not_found_update()
    {
        $category = Category::factory()->create();
        $data = [
            'name' => 'New name',
            'category_id'=>$category->id
        ];

        $response = $this->putJson("{$this->endpoint}/fake_id", $data);

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_validations_update()
    {
        $product = Product::factory()->create();

        $response = $this->putJson("{$this->endpoint}/{$product->id}", []);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'name',
            ],
        ]);
    }

    public function test_update()
    {
        $product = Product::factory()->create();
        $category = Category::factory()->create();
        $data = [
            'name' => 'Name Updated',
            'category_id'=>$category->id
        ];

        $response = $this->putJson("{$this->endpoint}/{$product->id}", $data);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'data' => [
                'name',
                'category_id'
            ],
        ]);
        $this->assertDatabaseHas('products', [
            'id'=> $product->id,
            'name' => 'Name Updated'
        ]);
    }

    public function test_not_found_delete()
    {
        $response = $this->deleteJson("{$this->endpoint}/fake_id");

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_delete()
    {
        $product = Product::factory()->create();
        $id = $product->id;
        $response = $this->deleteJson("{$this->endpoint}/$id}");
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }
}
