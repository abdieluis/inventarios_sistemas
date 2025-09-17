<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;

class EquipmentResponsive extends Model {
    use HasFactory;
    use SoftDeletes;

    protected $table = 'inventory_equipment_responsives'; 

    protected $casts = [
        'accessories' => AsArrayObject::class,
    ];

    public function employment() {
        return $this->belongsTo( \App\Models\Go\Employment::class, 'employment_id', 'id' );
    }

    /*
    public function employee() {
        return $this->hasOne( Employee::class, 'title_id', 'id' );
    }
    */

    public function equipment() {
        return $this->hasOne( Equipment::class, 'id', 'equipment_id' );
    }

    /*

    public function accesorios() {
        return $this->hasMany( Equipment::class, 'equipment_id', 'id' );
    }
    */

}
