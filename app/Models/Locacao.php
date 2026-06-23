<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Representa o aluguel de um Carro por um Cliente, atendido por um
 * Funcionario. Guarda o período, os valores calculados e o status,
 * que reflete se o carro vinculado ainda está ocupado por ela.
 */
class Locacao extends Model
{
    protected $table = 'locacoes';

    // "ativa": locação em andamento, carro ocupado por ela.
    // "finalizada": locação encerrada, carro liberado para nova locação.
    public const STATUS_ATIVA = 'ativa';
    public const STATUS_FINALIZADA = 'finalizada';
    public const STATUSES = [self::STATUS_ATIVA, self::STATUS_FINALIZADA];

    protected $fillable = [
        'cliente_id',
        'funcionario_id',
        'carro_id',
        'data_inicio',
        'data_fim',
        'dias',
        'valor_diaria',
        'valor_total',
        'comissao_percent',
        'valor_comissao',
        'status',
    ];

    /** Cliente que está alugando o carro. */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    /** Funcionário que atendeu/cadastrou a locação (recebe a comissão). */
    public function funcionario()
    {
        return $this->belongsTo(Funcionario::class);
    }

    /** Carro alugado. A FK usa a placa, que é a chave primária de Carro. */
    public function carro()
    {
        return $this->belongsTo(Carro::class, 'carro_id', 'placa');
    }

    /** Registro de comissão gerado automaticamente ao salvar a locação. */
    public function comissao()
    {
        return $this->hasOne(Comissao::class);
    }

    /** dias × valor da diária. */
    public function calcularValorTotal(): float
    {
        return round($this->dias * $this->valor_diaria, 2);
    }

    /** Comissão do funcionário sobre o valor total da locação. */
    public function calcularValorComissao(): float
    {
        return round($this->calcularValorTotal() * ($this->comissao_percent / 100), 2);
    }
}
