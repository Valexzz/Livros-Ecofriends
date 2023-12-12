<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        /*Schema::table('users', function (Blueprint $table) {
            $table->foreign('curso_id')->references('id')->on('cursos');
        });*/

        Schema::table('livros', function (Blueprint $table) {
            $table->foreign('area_conhecimento_id')->references('id')->on('areas_conhecimento');
        });

        Schema::table('emprestimos', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('livro_id')->references('id')->on('livros');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_curso_id_foreign');
        });

        Schema::table('livros', function (Blueprint $table) {
            $table->dropForeign('livros_area_conhecimento_id_foreign');
        });

        Schema::table('emprestimos', function (Blueprint $table) {
            $table->dropForeign('emprestimos_livro_id_foreign');
            $table->dropForeign('emprestimos_user_id_foreign');
        });
    }
};
