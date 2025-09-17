<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;

class Equipment extends Model {
    use HasFactory;
    use SoftDeletes;

    protected $table = 'inventory_equipments'; 

    protected $casts = [
        'features' => AsArrayObject::class,
    ];

    public function category() {
        return $this->hasOne( EquipmentCategory::class, 'id', 'category_id' )->select(['id', 'name']);
    }
    public function brand() {
        return $this->hasOne( EquipmentBrand::class, 'id', 'brand_id' )->select(['id', 'name']);
    }
    public function model() {
        return $this->hasOne( EquipmentModel::class, 'id', 'model_id' )->select(['id', 'name']);
    }
    public function owner() {
        return $this->hasOne( EquipmentOwner::class, 'id', 'owner_id' )->select(['id', 'name']);
    }

    public function category_name() {
        return $this->hasOne( EquipmentCategory::class, 'id', 'category_id' )->select('name');
    }
    public function brand_name() {
        return $this->hasOne( EquipmentBrand::class, 'id', 'brand_id' )->select('name');
    }
    public function owner_name() {
        return $this->hasOne( EquipmentOwner::class, 'id', 'owner_id' )->select('name');
    }

    
    public function responsives() {
        return $this->hasManyThrough(
            Responsive::class,
            ResponsiveEquipment::class,
            'responsive_id', // Foreign key on the deployments table...
            'id', // Local key on the projects table...
            'id', // Local key on the environments table...
            'equipment_id', // Foreign key on the environments table...
        );
    }


    public function responsive_equipments() {
        return $this->hasMany(
            ResponsiveEquipment::class,
            'equipment_id', // Foreign key on the environments table...
            'id', // Local key on the environments table...
        );
    }
    

    // current_responsive

    /*
    public function current_equipment_responsive() {

        return $this->hasOne( \App\Models\Inventory\ResponsiveEquipment::class, 'equipment_id', 'id' )->ofMany([
            'id' => 'min'
        ], function ($query) {
            $query->whereNull('end_at');
        });

    }
    */
    
}
