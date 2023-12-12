<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Query\Expression;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('emprestimos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('livro_id');
            $table->timestamps();
            $table->date('data_emprestimo')->nullable();
            $table->date('devolucao')->nullable();
            $table->enum('status', ['pendente', 'confirmado', 'recusado', 'atrasado', 'devolvido'])->default('pendente');
            //$table->timestamp('data_emprestimo', $precision=0)->default(new Expression('CURRENT_TIMESTAMP()'));
            //$table->timestamp('data_devolucao', $precision=0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emprestimos');
    }
};
