<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;

class EquipmentFeature extends Model {
    use HasFactory;
    use SoftDeletes;

    protected $table = 'inventory_equipment_features'; 

    protected $casts = [
        'categories' => AsArrayObject::class,
    ];

    public function options() {
        return $this->hasMany( EquipmentFeatureOption::class, 'feature_id', 'id' );

    }


}
