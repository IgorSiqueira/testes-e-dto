<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use Core\UseCase\DTO\Product\CreateProduct\ProductCreateInputDto;
use Core\UseCase\DTO\Product\ListProducts\ListProductsInputDto;
use Core\UseCase\DTO\Product\ProductInputDto;
use Core\UseCase\DTO\Product\UpdateProduct\ProductUpdateInputDto;
use Core\UseCase\Product\CreateProductUseCase;
use Core\UseCase\Product\DeleteProductUseCase;
use Core\UseCase\Product\ListProductsUseCase;
use Core\UseCase\Product\ListProductUseCase;
use Core\UseCase\Product\UpdateProductUseCase;
use Illuminate\Http\Response;

class ProductController extends Controller
{

    public function index(Request $request,ListProductsUseCase $useCase)
    {
      
        $response = $useCase->execute(
            input: new ListProductsInputDto(
                filter: $request->get('filter', ''),
                order: $request->get('order', 'DESC'),
                page: (int) $request->get('page', 1),
                totalPage: (int) $request->get('total_page', 15),
            )
        );
    
        return ProductResource::collection(collect($response->items))
        ->additional([
            'meta' => [
                'total' => $response->total,
                'current_page' => $response->current_page,
                'last_page' => $response->last_page,
                'first_page' => $response->first_page,
                'per_page' => $response->per_page,
                'to' => $response->to,
                'from' => $response->from,
            ],
        ]);
      
    }
    public function store(StoreProductRequest $request, CreateProductUseCase $useCase)
    {
      
        $response = $useCase->execute(
            input: new ProductCreateInputDto(
                name: $request->name,
                category_id:$request->category_id
            )
        );
        return (new ProductResource($response))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ListProductUseCase $useCase, $id)
    {
       
        $product = $useCase->execute(new ProductInputDto($id));
        return (new ProductResource($product))->response();
    }
    public function update(UpdateProductRequest $request, UpdateProductUseCase $useCase, $id)
    {
       
        $productUpdateInputDto =  new ProductUpdateInputDto(
            id: $id,
            name: $request->name,
            category_id:$request->category_id
        );
       
        $response = $useCase->execute(
            input:$productUpdateInputDto
        );
       
        return (new ProductResource($response))->response();

    }
    
    public function destroy(DeleteProductUseCase $useCase, $id)
    {
        $useCase->execute(new ProductInputDto($id));
        return response()->noContent();
    }
}