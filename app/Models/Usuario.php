<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use \Illuminate\Database\Eloquent\Relations\BelongsTo;
use \Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Usuario extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;
    
    protected $fillable = ['matricula', 'nome', 'senha', 'curso_id', 'ano', 'telefone'];
    public function curso(): BelongsTo
    {
        return $this->belongsTo(Curso::class);
    }

    /*public function livro(): BelongsToMany
    {
        return $this->belongsToMany(Livro::class, 'emprestimos');
    }*/

}
