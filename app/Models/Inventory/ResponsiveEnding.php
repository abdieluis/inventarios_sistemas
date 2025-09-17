<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResponsiveEnding extends Model {
    use HasFactory;
    use SoftDeletes;

    protected $table = 'inventory_responsive_endings';

}
