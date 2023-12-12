<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;


class AreaConhecimentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('areas_conhecimento')->insert([
            'descricao' => 'Matemática'
        ]);

        DB::table('areas_conhecimento')->insert([
            'descricao' => 'Português'
        ]);

        DB::table('areas_conhecimento')->insert([
            'descricao' => 'Física'
        ]);

        DB::table('areas_conhecimento')->insert([
            'descricao' => 'Química'
        ]);

        DB::table('areas_conhecimento')->insert([
            'descricao' => 'Biologia'
        ]);

        DB::table('areas_conhecimento')->insert([
            'descricao' => 'História'
        ]);

        DB::table('areas_conhecimento')->insert([
            'descricao' => 'Geografia'
        ]);

        DB::table('areas_conhecimento')->insert([
            'descricao' => 'Filosofia'
        ]);

        DB::table('areas_conhecimento')->insert([
            'descricao' => 'Sociologia'
        ]);

        DB::table('areas_conhecimento')->insert([
            'descricao' => 'Outra'
        ]);
    }
}
