<?php

namespace Core\Domain\Entity;

use Core\Domain\Entity\Traits\MethodsMagicsTrait;
use Core\Domain\Validation\DomainValidation;
use Core\Domain\ValueObject\Uuid;
use DateTime;

class Product
{
    use MethodsMagicsTrait;

    public function __construct(
        protected string $id = '',
        protected string $name = '',
        protected string|null $category_id = null,
    ) {
       
        $this->validate();
    }

    public function update(string $name, string|null $category_id = null)
    {
        $this->name = $name;
        if($category_id){
            $this->category_id = $category_id;
        }
        $this->validate();
    }

    protected function validate()
    {
        DomainValidation::strMaxLength($this->name);
        DomainValidation::strMinLength($this->name);
    }
}
