<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\KpiType;
class KpiItem extends Model
{
    protected $table = 'kpi_items';
    protected $fillable = [
        'titulo',
        'valor',
        'variacao_percentual',
        'kpi_type_id',
    ];

    protected $casts = [
        'valor' => 'decimal:2',
        'variacao_percentual' => 'decimal:2',
    ];

    public function type()
    {
        return $this->belongsTo(KpiType::class, 'kpi_type_id','id');
    }

}
