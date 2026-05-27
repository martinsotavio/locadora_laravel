<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comissao extends Model
{
    protected $table = 'comissoes';

    protected $fillable = [
        'locacao_id',
        'funcionario_id',
        'valor',
    ];

    public function locacao()
    {
        return $this->belongsTo(Locacao::class);
    }

    public function funcionario()
    {
        return $this->belongsTo(Funcionario::class);
    }
}
