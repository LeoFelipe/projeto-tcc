<?php

namespace App\Models;

use Doctrine\ORM\EntityManager;

abstract class Model
{    
    protected $em, $entity;
    
    public function __construct(EntityManager $em, $currentEntity)
    {
        $this->em = $em;
        $this->entity = $currentEntity;
    }
    
    public function getRepository($otherEntity = null)
    {
        return ($otherEntity) ? $this->em->getRepository($otherEntity) : $this->em->getRepository($this->entity);
    }
}