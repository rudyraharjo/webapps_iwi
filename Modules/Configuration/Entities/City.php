<?php

namespace Modules\Configuration\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class City extends Model
{
    use HasFactory;
    
    protected $table = 'c_cities';
    protected $primaryKey = 'id';
    protected $fillable = [];

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    // protected static function newFactory()
    // {
    //     return \Modules\Configuration\Database\factories\CityFactory::new();
    // }
}
