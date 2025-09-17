<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponsiveEmployment extends Model {
    use HasFactory;

    protected $table = 'inventory_responsive_employments';

    public function data() {
        return $this->hasOne( \App\Models\Go\Employment::class, 'id', 'employment_id' );
    }

    public function responsive() {
        return $this->belongsTo( Responsive::class, 'responsive_id', 'id' );
    }

}
