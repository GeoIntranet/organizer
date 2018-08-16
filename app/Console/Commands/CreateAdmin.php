<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:admin {mail} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Administrator user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        parent::__construct();
    }

    /**
     * Création d'un administrateur
     * pour l'appeler
     * php artisan command:admin geoffrey@eurocomputer.fr motdepass
     * va renseigner : le mail / le pass / le nom ==> geoffrey / le role 10 == admin
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $mail = $this->argument('mail');

        $pass = bcrypt($this->argument('password'));
        $name = substr($this->argument('mail'),0,strpos($this->argument('mail'), '@'));

        $this->user->email = $mail;
        $this->user->password = $pass;
        $this->user->name = $name;
        $this->user->user_role = 10;

        $this->user->save();

        $this->info('Utilisateur : '.$mail.' crée avec succés' );
    }
}
