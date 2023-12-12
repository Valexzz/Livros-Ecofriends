<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;


class CursoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cursos')->insert([
            'descricao' => 'Informática'
        ]);

        DB::table('cursos')->insert([
            'descricao' => 'Eventos'
        ]);

        DB::table('cursos')->insert([
            'descricao' => 'Administração'
        ]);

        DB::table('cursos')->insert([
            'descricao' => 'Controle Ambiental'
        ]);

        DB::table('cursos')->insert([
            'descricao' => 'Eletrotécnica'
        ]);

        DB::table('cursos')->insert([
            'descricao' => 'Agronegócio'
        ]);

        DB::table('cursos')->insert([
            'descricao' => 'Agrimensura'
        ]);

        DB::table('cursos')->insert([
            'descricao' => 'Mecatrônica'
        ]);
    }
}
