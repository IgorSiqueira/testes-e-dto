<?php

namespace Tests\Unit\App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryUnitTest extends ModelTestCase
{
    protected function model(): Model
    {
        return new Category();
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
        ];
    }

    protected function casts(): array
    {
        return [
            'id' => 'int'
        ];
    }
}
