<?php

namespace App\Repository;

class RealStateRepository extends AbstractRepository
{
    private $location;

    public function setLocation(array $data): self
    {
        $this->location = $data;
        return $this;
    }


    //irei sobrepor meu metodo getResult()
    //tenho que mudar o $model dentro de Abstract para protected
    public function getResult()
    {
$location = $this->location;

        return $this->model->whereHas('address', function ($q) use($location) {
            $q->where('state_id', $location['state'])
                ->where('city_id', $location['city']);
        });
    }
}
