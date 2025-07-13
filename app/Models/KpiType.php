<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\KpiItem;
class KpiType extends Model
{
    protected $table = 'kpi_types';
    protected $fillable = [
        'name',
        'code',
    ];

    public function kpis()
    {
        return $this->hasMany(KpiItem::class, 'kpi_type_id');
    }
}
