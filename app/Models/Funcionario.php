<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    use HasFactory;
    public const CARGOS = ['gerente', 'locador'];

    /** Percentual de bonificação para o funcionário com mais comissões. */
    public const BONUS_PERCENT_TOP_COMISSAO = 5;

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

    /** Bonificação aplicada sobre o total de comissões do funcionário líder. */
    public static function calcularBonus(float $totalComissao): float
    {
        return round($totalComissao * (self::BONUS_PERCENT_TOP_COMISSAO / 100), 2);
    }
}
