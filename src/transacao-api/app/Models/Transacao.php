<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transacao extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'transacoes';

    protected $fillable = [
        'user_id',
        'valor',
        'cpf',
        'documento_path',
        'status',
    ];

    protected $casts = [
        'valor' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
