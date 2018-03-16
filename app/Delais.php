<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Delais extends Model
{

    protected $primaryKey='id_cmd';
    protected $fillable =['date_envoie','order','semaine_envoie','id_cmd','id_client'];



    public function scopeSearchDelaisIn($query , $listOfBls)
    {
        $bl = is_object($listOfBls) ? $listOfBls->toArray() : $listOfBls;

        return $query
            ->select('*')
            ->whereIn('id_cmd',$bl)
            ->orderBy('id_cmd','asc')
            ->get()
            ;
    }

    public function client()
    {
        return $this->belongsTo(Client::class,'id_client','id_client');
    }
}
