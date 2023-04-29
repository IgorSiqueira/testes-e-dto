<?php

namespace Core\Domain\Entity;

use Core\Domain\Entity\Traits\MethodsMagicsTrait;
use Core\Domain\Validation\DomainValidation;
use Core\Domain\ValueObject\Uuid;
use DateTime;

class Category
{
    use MethodsMagicsTrait;

    public function __construct(
        protected string $id = '',
        protected string $name = '',
    ) {
       
        $this->validate();
    }

    public function update(string $name, string $description = '')
    {
        $this->name = $name;
        $this->validate();
    }

    protected function validate()
    {
        DomainValidation::strMaxLength($this->name);
        DomainValidation::strMinLength($this->name);
    }
}
