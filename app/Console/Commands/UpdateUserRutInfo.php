<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;

class UpdateUserRutInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ln:update-user-rut-info';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update user rut info (rut_formatted and dv)';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = User::whereNull('rut_formatted')->orWhere('rut_formatted', '')->orWhereNull('dv')->orWhere('dv', '')->get();

        foreach ($users as $user) {
            if($user->withOutRut()){
                continue;
            }
            $rutWithoutDv = $user->getRutWithoutDvAttribute();
            $dv = $user->getDvAttribute();

            $user->rut_formatted = $rutWithoutDv;
            $user->dv = $dv;

            $user->save();
            $this->info('User ' . $user->idUsuario . ' updated');
        }

        
    }
}
