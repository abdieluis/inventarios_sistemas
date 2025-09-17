<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;

class PhoneLineModality extends Model {
    use HasFactory;
    use SoftDeletes;

    protected $table = 'inventory_phoneline_modalities';

}
