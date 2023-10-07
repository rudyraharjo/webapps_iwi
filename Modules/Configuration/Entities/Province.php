<?php

namespace Modules\Configuration\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Province extends Model
{
    use HasFactory;

    protected $table = 'c_provinces';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id', 'name'
    ];
    
    // protected static function newFactory()
    // {
    //     return \Modules\Configuration\Database\factories\ProvinceFactory::new();
    // }
}
