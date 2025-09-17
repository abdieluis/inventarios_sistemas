<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EquipmentFeatureOption extends Model {
    use HasFactory;
    use SoftDeletes;

    protected $table = 'inventory_equipment_feature_options'; 

    public function feature() {
        return $this->belongsTo( EquipmentFeature::class, 'feature_id', 'id' );
    }

}
