<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    //fiz uma coisa errada aqui
    //eu coloquei a classe com um nome e na banco está outro nome
    //então ire definir aqui o apontamento para o banco da forma correta
    protected $table = 'adresses';

    public function state(){
        return $this->belongsTo(State::class);
    }
    public function city(){
        return $this->belongsTo(City::class);
    }
    public function real_state(){
        return $this->hasOne(RealState::class);
    }
}
