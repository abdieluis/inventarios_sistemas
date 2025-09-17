<?php

namespace App\Models\Go;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Employment extends Model {
    use HasFactory;
    use SoftDeletes;

    protected $table = 'go_employments';

    public function employee() {
        return $this->belongsTo( Employee::class, 'employee_id', 'id' );
    }

    public function branch() {
        return $this->belongsTo( Branch::class, 'branch_id', 'id' )->select(['id', 'name']);
    }

    public function area() {
        return $this->belongsTo( EmploymentArea::class, 'area_id', 'id' )->select(['id', 'name']);
    }

    public function title() {
        return $this->belongsTo( EmploymentTitle::class, 'title_id', 'id' )->select(['id', 'name']);
    }

    public function responsives() {
        return $this->hasMany( \App\Models\Inventory\Responsive::class, 'employment_id', 'id' );
    }

}
