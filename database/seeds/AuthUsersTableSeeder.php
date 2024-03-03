<?php

use Illuminate\Database\Seeder;

class AuthUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('authUsers')->insert([
				['email'=>'eduperez@alumnos.uai.cl', 'tipoMalla'=>'1'],
				['email'=>'pmoreau@alumnos.uai.cl', 'tipoMalla'=>'1'],
				['email'=>'izenteno@alumnos.uai.cl', 'tipoMalla'=>'1'],
				['email'=>'rmatos@alumnos.uai.cl', 'tipoMalla'=>'1'],
				['email'=>'rafael.cereceda2004@alumnos.uai.cl', 'tipoMalla'=>'1'],
        ['email'=>'jomiquel@alumnos.uai.cl', 'tipoMalla'=>'1']
			]);
    }
}
