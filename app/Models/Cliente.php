<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    // Esta linha avisa o Laravel que é seguro salvar esses campos no banco
    protected $fillable = ['nome', 'cpf', 'telefone'];

    public function locacoes()
    {
        return $this->hasMany(Locacao::class);
    }
}
