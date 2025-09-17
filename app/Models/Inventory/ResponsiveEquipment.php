<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;

class ResponsiveEquipment extends Model {
    use HasFactory;

    protected $table = 'inventory_responsive_equipments';

    public function data() {
        return $this->hasOne( Equipment::class, 'id', 'equipment_id' );
    }

    public function phoneline() {
        return $this->hasOne( PhoneLine::class, 'id', 'phoneline_id' );
    }    

    public function responsive() {
        return $this->belongsTo( Responsive::class, 'responsive_id', 'id' );
    }

}
