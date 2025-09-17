<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;

class PhoneLine extends Model {
    use HasFactory;
    use SoftDeletes;

    protected $table = 'inventory_phonelines'; 

    protected $casts = [
        'features' => AsArrayObject::class,
    ];

    public function modality() {
        return $this->hasOne( PhoneLineModality::class, 'id', 'modality_id' )->select(['id', 'name']);
    }
    
    public function current_responsive() {
        
        return $this->hasOne( \App\Models\Inventory\Responsive::class, 'phoneline_id', 'id' )->ofMany([
            'id' => 'min'
        ], function ($query) {
            $query->whereNull('end_at');
        });

    }


    
    public function responsives() {
        return $this->hasManyThrough(
            Responsive::class,
            ResponsiveEquipment::class,
            'responsive_id', // Foreign key on the deployments table...
            'id', // Local key on the projects table...
            'id', // Local key on the environments table...
            'phoneline_id', // Foreign key on the environments table...
        );
    }
    
    public function responsive_equipments() {
        return $this->hasMany(
            ResponsiveEquipment::class,
            'phoneline_id', // Foreign key on the environments table...
            'id', // Local key on the environments table...
        );
    }    
}
