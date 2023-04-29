<?php

namespace Tests\Unit\Domain\Entity;

use App\Models\Category;
use Core\Domain\Entity\Product;
use Core\Domain\Exception\EntityValidationException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Throwable;

class ProductUnitTest extends TestCase
{
    public function testAttributes()
    {
        $product = new Product(
            name: 'New Cat'
        );
        $this->assertEquals('New Cat', $product->name);
    
    }

   

   

    public function testUpdate()
    {
       

        $product = new Product(
            name: 'New Cat',
           
        );

        $product->update(
            name: 'new_name',
        );

     
        $this->assertEquals('new_name', $product->name);
    
    }

    public function testExceptionName()
    {
        try {
            new Product(
                name: 'Na',
            );

            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
        }
    }

   
}
