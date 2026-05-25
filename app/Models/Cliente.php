<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    // Esta linha avisa o Laravel que é seguro salvar esses campos no banco
    protected $fillable = ['nome', 'cpf', 'telefone'];
}