<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RealState extends Model
{
    //isso aqui abaixo retorna na serialização
    //alem de retornar as informações do imovel
    //ele irá adicionar os atributos do getLinksAttributes
    protected $appends = ['links','thumb'];

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

    //método acessor
    //$realState->links ele retorna isso aqui abaixo
    //dessa forma quem programar o frontend não precisa montar o link, ele já vem propnto
    public function getLinksAttribute()
    {
        //return 'OK';
        //dd($this->id);
        //return route('real_states.real-states.show', $this->id);
        
        return [
            'href' => route('real_states.real-states.show', $this->id),
            'rel' => 'Imóveis',
            'id' => $this->id
        ];
        
    }

    public function getThumbAttribute(){
        $thumb = $this->photos()->where('is_thumb', true);
        if(!$thumb->count()) return null;

        return $thumb->first()->photo;
    }

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

    public function address()
    {
        return $this->belongsTo(Address::class);
    }
}
