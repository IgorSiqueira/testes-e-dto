<?php

namespace Tests\Unit\App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductUnitTest extends ModelTestCase
{
    protected function model(): Model
    {
        return new Product();
    }

    protected function traits(): array
    {
        return [
            HasFactory::class
        ];
    }

    protected function fillables(): array
    {
        return [
            'name',
            'category_id'
        ];
    }

    protected function casts(): array
    {
        return [
            'id' => 'int'
        ];
    }
}
