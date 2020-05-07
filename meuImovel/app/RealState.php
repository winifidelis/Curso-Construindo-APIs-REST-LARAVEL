<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RealState extends Model
{
    //a linha abaixo modifica a propriedade do table
    //aqui no caso eu saio da convenção do laravel
    //eu posso passar um nome no singular da minha tabela
    protected $table = 'real_state';

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        //para eu definir a tabela pivot eu adiciono o nome dela no segundo parametro
        //pois aqui no caso o laravel organiza os model em ordem alfabetica
        //e neste exemplo eu não coloquei as tabelas em ordem alfabetica
        return $this->belongsToMany(Category::class, 'real_state_categories');
    }

    public function photos()
    {
        return $this->hasMany(RealStatePhoto::class);
    }

    public function adress()
    {
        return $this->belongsTo(Address::class);
    }
}
