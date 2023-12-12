<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Database\Eloquent\Model;

use \Illuminate\Database\Eloquent\Relations\BelongsTo;
use \Illuminate\Database\Eloquent\Relations\BelongsToMany;
use \Illuminate\Database\Eloquent\Relations\HasMany;

use App\Notifications\VerificarEmailNotification;
use App\Notifications\ResetarSenhaNotification;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    
    protected $fillable = ['matricula', 'name', 'email', 'password', 'ano', 'curso_id', 'adm', 'telefone'];
    public function curso(): BelongsTo
    {
        return $this->belongsTo(Curso::class);
    }

    public function emprestimos()
    {
        return $this->hasMany(Emprestimo::class);
    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function sendEmailVerificationNotification(){
        $this->notify(new VerificarEmailNotification);
    }

    public function sendPasswordResetNotification($token){
        $this->notify(new ResetarSenhaNotification($token));
    }
}
