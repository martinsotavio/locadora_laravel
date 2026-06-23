<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Carro extends Model
{
    use HasFactory;

    protected $table = 'carros';

    protected $primaryKey = 'placa';
    public $incrementing = false;
    protected $keyType = 'string';

    public const STATUS_DISPONIVEL = 'disponivel';
    public const STATUS_LOCADO = 'locado';
    public const STATUSES = [self::STATUS_DISPONIVEL, self::STATUS_LOCADO];

    protected $fillable = [
        'placa',
        'modelo',
        'marca',
        'ano',
        'cor',
        'valor_diaria',
        'status',
        'imagem',
    ];

    public function locacoes()
    {
        return $this->hasMany(Locacao::class, 'carro_id', 'placa');
    }

    public function imagemUrl(): ?string
    {
        return $this->imagem ? Storage::url($this->imagem) : null;
    }

    public function estaDisponivel(): bool
    {
        return $this->status === self::STATUS_DISPONIVEL;
    }

    public function marcarComoLocado(): void
    {
        $this->update(['status' => self::STATUS_LOCADO]);
    }

    public function marcarComoDisponivel(): void
    {
        $this->update(['status' => self::STATUS_DISPONIVEL]);
    }
}
