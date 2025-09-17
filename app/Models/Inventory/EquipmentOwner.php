<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EquipmentOwner extends Model {
    use HasFactory;
    use SoftDeletes;

    protected $table = 'inventory_equipment_owners'; 

}
