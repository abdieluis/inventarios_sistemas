<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EquipmentCategory extends Model {
    use HasFactory;
    use SoftDeletes;

    protected $table = 'inventory_equipment_categories';

    public function models() {
        return $this->hasMany( EquipmentModel::class, 'category_id', 'id' );
    }

}
