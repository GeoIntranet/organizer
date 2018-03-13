<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Lib\Team\TeamOrganiser;
use App\Http\Requests;
use Carbon\Carbon;
use App\Commande;
use App\Delais;


class TeamController extends Controller
{
    /**
     * test prototype en cours
     * @param \App\Http\Controllers\Lib\Team\TeamOrganiser $teamOrganiser
     * @return $this
     */
    public function index(TeamOrganiser $teamOrganiser)
    {
        $team = [ 48, 51, 56 ];

        $work = $teamOrganiser->setTeam($team) ;

        $incidents = $work->getIncidents();

        $achats = $work->getAchats();

        //var_dump($achats);

        /**
         * Trier les incidents en 2 catégorie,
         * Ceux que tu peux gerer :
         *      - Appel dossier
         *      - A rappeler
         *      - Retour matos neuf
         *      - Expedition machine
         *      - Attente audit
         *
         * Ceux que tu ne peut pas gerer:
         *      - Attente info / materiel client
         *      - Attente fournisseur
         */
        // INCIDENT + state + client + date + titre
        // DA en cours  + state + date
        // COMMANDE  -> trie préalables pistolet
        // DELAIS

        return view('team.index')
            ->with('achats',$achats)
            ->with('incidents',$incidents)
            ;

    }

    /**
     * @param $semaine
     * @return mixed
     */
    public function searchWork($semaine)
    {
        $team = 1;
        $keyCache = 'works_'.$team.'_'.$semaine;


        $date = Carbon::now();
        $date->setISODate($date->copy()->format('Y'),$semaine);
        $start =  $date->startOfWeek();
        $week = [];

        $dt = new carbon($start);

        for( $i=0 ; $i <5 ; $i++ ){
            $week[] = $i > 0 ? $dt->addDay(1)->copy() : $dt->copy() ;
        }


        $delais = Delais::where('semaine_envoie',$semaine)
            ->with('client')
            ->orderBy('order','ASC')
            ->get()->groupBy('date_envoie');

        $data = [];
        foreach ($week as $index => $day) {
            $data[$index] = isset($delais[$day->format('Y-m-d')]) ? $delais[$day->format('Y-m-d')] : [] ;
        }


        return $data;
    }

    /**
     * reorder/semaine/id-dragg/order/day
     * addorder/semaine/id-dragg/order/day
     */
    public function updateColumn( $semaine , $id , $order , $numberOfDay)
    {
        $date = Carbon::now();
        $date->setISODate($date->copy()->format('Y'),$semaine);
        $start =  $date->startOfWeek();
        $week = [];
        $dt = new carbon($start);

        for( $i=0 ; $i <5 ; $i++ ){
            $week[] = $i > 0 ? $dt->addDay(1)->copy() : $dt->copy() ;
        }

        $date = (new Carbon($week[$numberOfDay]))->format('Y-m-d');


        // UPDATE ORDER PARTI superieur a order donné
        $delais = Delais::where('order',">=",$order)->where('date_envoie',$date)->get();
       // var_dump($delais);
        foreach ($delais as $index => $delai) {
            $state = $delai->update(['order'=>$delai->order+1]);
        }

        $item = Delais::where('id',$id)->first();

        $state = $item->update([
           'date_envoie' => $date,
           'order' => $order,
           'semaine_envoie' => $semaine,
           ]);
       
        //return ['update OK'];
    }

    public function updateDate($id,$dt)
    {
            $semaine = (new Carbon($dt))->weekOfYear;

            Delais::where('id',$id)->update(['date_envoie'=>$dt,'semaine_envoie'=>$semaine]);

            return ['ok'];
    }

    /**
     * @param null $date
     * @return mixed
     */
    public function works($date=null)
    {
        //$users =[48 => 'gv' , 51 => 'cc', 52 => 'flm' , 78 => 'jfl'];
        //$calendar = new WeekGestion();
        //
        //if($date <> null) $calendar->setStarterDate($date);
        //
        //$calendar = $calendar->generateWeek();
        //
        //$week = $calendar->getWeek();
        //
        //$delaisItem = New Delais();
        //
        //$delaisItem = $delaisItem
        //    ->whereBetween('date_envoie',[$calendar->firstDay(),$calendar->lastDay()])
        //    ->get()
        //    ->groupBy('date_envoie')
        //;

        $cmd = Commande::enCours()->with('clientDelivered')->limit(0)->take(16)->get();

        return view('team.work')
            ->with('commandes',$cmd)
            //->with('delais',$delaisItem)
            //->with('users',$users)
            ;

    }

    public function dayAdd($bl)
    {
        $delais = Delais::find($bl) ;
        $date = new carbon($delais->date_envoie);
        $date = $date->dayOfWeek == 5 ? $date->addDays(3) : $date->addDay(1);
        $delais->update(['date_envoie' => $date]);
        return back();
    }

    public function daySub($bl)
    {
        $delais = Delais::find($bl) ;
        $date = new carbon($delais->date_envoie);
        $date = $date->dayOfWeek == 1 ? $date->subDays(3) : $date->subDay(1);
        $delais->update(['date_envoie' => $date]);
        return back();

    }
}
