<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;

class Responsive extends Model {
    
    use HasFactory;
    use SoftDeletes;

    protected $table = 'inventory_responsives'; 

    protected $casts = [
        'accessories' => AsArrayObject::class,
    ];

    public function employment() {
        return $this->belongsTo( \App\Models\Go\Employment::class, 'employment_id', 'id' );
    }

    public function equipments() {
        return $this->hasMany( ResponsiveEquipment::class, 'responsive_id', 'id' );
        //return $this->hasManyThrough( Equipment::class, ResponsiveEquipment::class, 'responsive_id', 'equipment_id', 'id', 'id' );|
    }

    public function employments() {
        return $this->hasMany( ResponsiveEmployment::class, 'responsive_id', 'id' );
        //return $this->hasManyThrough( Equipment::class, ResponsiveEquipment::class, 'responsive_id', 'equipment_id', 'id', 'id' );|
    }

    public function ending() {
        return $this->hasOne( ResponsiveEnding::class, 'id', 'ending_id' );
    }

}
