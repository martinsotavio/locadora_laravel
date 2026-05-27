<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    public const CARGOS = ['gerente', 'locador'];

    protected $fillable = [
        'nome',
        'cpf',
        'telefone',
        'email',
        'cargo',
    ];

    public function locacoes()
    {
        return $this->hasMany(Locacao::class);
    }

    public function isGerente(): bool
    {
        return $this->cargo === 'gerente';
    }

    public function comissoes()
    {
        return $this->hasMany(Comissao::class);
    }

    public function totalComissao(): float
    {
        return round($this->comissoes()->sum('valor'), 2);
    }

    public static function existsByCpf(string $cpf): bool
    {
        return static::where('cpf', $cpf)->exists();
    }
}
