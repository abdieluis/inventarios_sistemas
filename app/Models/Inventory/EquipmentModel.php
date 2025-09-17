<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EquipmentModel extends Model {
    use HasFactory;
    use SoftDeletes;

    protected $table = 'inventory_equipment_models';

    public function brand() {
        return $this->belongsTo( EquipmentBrand::class, 'brand_id', 'id' );
    }
    public function category() {
        return $this->belongsTo( EquipmentCategory::class, 'category_id', 'id' );
    }

}
