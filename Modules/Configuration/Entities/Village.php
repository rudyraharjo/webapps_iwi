<?php

namespace Modules\Configuration\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Village extends Model
{
    use HasFactory;

    protected $table = 'c_villages';
    protected $primaryKey = 'id';
    protected $fillable = [];

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    // protected static function newFactory()
    // {
    //     return \Modules\Configuration\Database\factories\VillageFactory::new();
    // }
}
