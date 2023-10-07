<?php

namespace Modules\Configuration\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class District extends Model
{
    use HasFactory;

    protected $table = 'c_districts';
    protected $primaryKey = 'id';
    protected $fillable = [];

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    // protected static function newFactory()
    // {
    //     return \Modules\Configuration\Database\factories\DistrictFactory::new();
    // }
}
