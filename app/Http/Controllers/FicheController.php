<?php

namespace App\Http\Controllers;

use App\Commande;
use App\Delais;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class FicheController extends Controller
{
    public function all()
    {
        $fiches = Cache::remember('component_all_fiche', 10, function () {
            return   $fiches  = Commande::encours()
                ->with('delais','ligne','clientDelivered','clientFacture','achat','itCmd')
                ->get();
        });

        if(request()->wantsJson() || request()->ajax()){
            return $fiches->chunk(intval(count($fiches))/2);
            //return $fiches->chunk(intval(count($fiches))/2);
        }

        return ['error'];
    }



}
