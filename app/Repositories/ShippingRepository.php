<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Shipping;

class ShippingRepository
{
    protected $entity;

    public function __construct(Shipping $entity)
    {
        $this->entity = $entity;
    }

    public function getAllShippings(int $paginate = 10)
    {
        return $this->entity->paginate($paginate);
    }

    public function create($data)
    {
        return $this->entity->create($data);
    }

    public function delete()
    {
        return $this->entity->whereNotNull('id')->delete();
    }
}
