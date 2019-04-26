<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        
        DB::table('rols')->insert([
            'nombre'=>'Administradores',
            'estado' =>1
        ]);


        DB::table('personas')->insert([
            'nombre'=>'admin',
            'idRol' => 1,
            'estado' =>1
        ]);


        DB::table('usuarios')->insert([
            'nombre'=>'admin',
            'password' => 'admin',
            'idPersona' => 1,
            'estado' => 1
        ]);



        DB::table('rols')->insert([
            'nombre'=>'Bodeguero',
            'estado' =>1
        ]);


        DB::table('rols')->insert([
            'nombre'=>'Empleados',
            'estado' =>1
        ]);

    }
}
