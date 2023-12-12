<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emprestimo extends Model
{
    use HasFactory;

    protected $casts = [
        'data_emprestimo' => 'date',
        'devolucao' => 'date',
    ];

    protected $fillable = ['user_id', 'livro_id', 'devolucao', 'data_emprestimo', 'status'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function livro()
    {
        return $this->belongsTo(Livro::class);
    }
    
}
