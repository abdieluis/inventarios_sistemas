<?php

namespace App\Models\Go;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;

class Employee extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'go_employees';

    protected $casts = [
        'files' => AsArrayObject::class,
    ];

    public function employments()
    {
        return $this->hasMany(Employment::class, 'employee_id', 'id');
    }

    public function current_employment()
    {
        return $this->hasOne(Employment::class, 'employee_id', 'id')->latest();
    }

    // public function current_employment() {

    //     return $this->hasOne( Employment::class, 'employee_id', 'id' )->ofMany([
    //         'id' => 'min'
    //     ], function ($query) {
    //         $query->whereNull('end_at');
    //     });

    // }

}
