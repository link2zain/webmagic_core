<?php

namespace Tests\Unit\Entity;

use Webmagic\Core\Entity\EntityRepo as BaseEntityRepo;

class EntityRepo extends BaseEntityRepo
{
    public function setEntity($entity_name)
    {
        $this->entity = $entity_name;
    }
}