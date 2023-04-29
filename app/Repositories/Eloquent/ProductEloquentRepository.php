<?php

namespace App\Repositories\Eloquent;

use App\Models\Product as Model;
use App\Repositories\Presenters\PaginationPresenter;
use Core\Domain\Entity\Product;
use Core\Domain\Exception\NotFoundException;
use Core\Domain\Repository\ProductRepositoryInterface;
use Core\Domain\Repository\PaginationInterface;

class ProductEloquentRepository implements ProductRepositoryInterface
{
    protected $model;

    public function __construct(Model $product)
    {
        $this->model = $product;
    }

    public function insert(Product $product): Product
    {
        $product = $this->model->create([
            'name' => $product->name,
            'category_id'=> $product->category_id
        ]);
        
        return $this->toProduct($product);
    }

    public function findById(string $productId): Product
    {
        if (! $product = $this->model->find($productId)) {
            throw new NotFoundException('Product Not Found');
        }

        return $this->toProduct($product);
    }

    public function getIdsListIds(array $categoriesId = []): array
    {
        return $this->model
                    ->whereIn('id', $categoriesId)
                    ->pluck('id')
                    ->toArray();
    }

    public function findAll(string $filter = '', $order = 'DESC'): array
    {
        $categories = $this->model
                            ->where(function ($query) use ($filter) {
                                if ($filter) {
                                    $query->where('name', 'LIKE', "%{$filter}%");
                                }
                            })
                            ->orderBy('id', $order)
                            ->get();

        return $categories->toArray();
    }

    public function paginate(string $filter = '', $order = 'DESC', int $page = 1, int $totalPage = 15): PaginationInterface
    {
        $query = $this->model;
        if ($filter) {
            $query = $query->where('name', 'LIKE', "%{$filter}%");
        }
        $query = $query->orderBy('id', $order);
        $paginator = $query->paginate();

        return new PaginationPresenter($paginator);
    }

    public function update(Product $product): Product
    {
        if (! $productDb = $this->model->find($product->id())) {
            throw new NotFoundException('Product Not Found');
        }
      
       $dataToUpdate = ['name' => $product->name,'category_id'=>$productDb->category_id];
        if($product->category_id){
            $dataToUpdate['category_id'] = $product->category_id;
        }
        
        $productDb->update($dataToUpdate);

        $productDb->refresh();

        return $this->toProduct($productDb);
    }

    public function delete(string $productId): bool
    {
        if (! $productDb = $this->model->find($productId)) {
            throw new NotFoundException('Product Not Found');
        }

        return $productDb->delete();
    }

    private function toProduct(object $object): Product
    {
        $entity = new Product(
            id: $object->id,
            name: $object->name,
            category_id:$object->category_id
        );
     
        return $entity;
    }
}
