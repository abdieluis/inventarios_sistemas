<?php

namespace App\Models\Go;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Go\Employment;

class EmploymentTitle extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'go_employment_titles';

    protected $fillable = [
        'name',
    ];

    public function employments()
    {
        return $this->hasMany(Employment::class, 'employment_title_id');
    }
}
