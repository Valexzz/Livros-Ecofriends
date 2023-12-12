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
        Schema::create('users', function (Blueprint $table) {

            $table->id();
            $table->string('matricula', 20)->unique();
            $table->string('name', 100);
            $table->string('password');
            $table->unsignedBigInteger('curso_id');
            $table->string('email', 100)->unique();
            $table->enum('ano', ['1', '2', '3']);
            $table->string('telefone', 20);
            $table->enum('adm', ['0','1'])->default('0');
            $table->timestamp('email_verified_at')->nullable($value=true);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
