<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Locacao extends Model
{
    protected $table = 'locacoes';

    protected $fillable = [
        'cliente_id',
        'funcionario_id',
        'data_inicio',
        'data_fim',
        'dias',
        'valor_diaria',
        'valor_total',
        'comissao_percent',
        'valor_comissao',
        'status',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function funcionario()
    {
        return $this->belongsTo(Funcionario::class);
    }

    public function comissao()
    {
        return $this->hasOne(Comissao::class);
    }

    public function calcularValorTotal(): float
    {
        return round($this->dias * $this->valor_diaria, 2);
    }

    public function calcularValorComissao(): float
    {
        return round($this->calcularValorTotal() * ($this->comissao_percent / 100), 2);
    }
}
