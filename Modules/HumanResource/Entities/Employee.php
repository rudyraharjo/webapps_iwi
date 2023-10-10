<?php

namespace Modules\HumanResource\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'hr_employees';
    protected $primaryKey = 'id';
    protected $fillable = [];

    // protected static function newFactory()
    // {
    //     return \Modules\HumanResource\Database\factories\EmployeeFactory::new();
    // }
}
