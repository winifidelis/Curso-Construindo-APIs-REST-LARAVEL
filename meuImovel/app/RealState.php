<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RealState extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'content',
        'price',
        'bathrooms',
        'bedrooms',
        'property_area',
        'total_property_area',
        'slug',
    ];


    //a linha abaixo modifica a propriedade do table
    //aqui no caso eu saio da convenção do laravel
    //eu posso passar um nome no singular da minha tabela
    protected $table = 'real_state';


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
