<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carro extends Model
{
    use HasFactory;

    protected $table = 'carros';

    protected $primaryKey = 'placa';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'placa',
        'modelo',
        'marca',
        'ano',
        'cor',
        'valor_diaria',
        'disponivel',
    ];
}
