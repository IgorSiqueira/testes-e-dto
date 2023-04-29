<?php

namespace Tests\Unit\Domain\Entity;

use Core\Domain\Entity\Category;
use Core\Domain\Exception\EntityValidationException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Throwable;

class CategoryUnitTest extends TestCase
{
    public function testAttributes()
    {
        $category = new Category(
            name: 'New Cat'
        );
        $this->assertEquals('New Cat', $category->name);
    }

   

   

    public function testUpdate()
    {
       

        $category = new Category(
            name: 'New Cat',
           
        );

        $category->update(
            name: 'new_name',
        );

     
        $this->assertEquals('new_name', $category->name);
    
    }

    public function testExceptionName()
    {
        try {
            new Category(
                name: 'Na',
            );

            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
        }
    }

   
}
