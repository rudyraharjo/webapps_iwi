<?php

namespace Modules\Configuration\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BussinesPartnerDesignation extends Model
{
    use HasFactory;


    protected $table = 'c_designation';
    protected $primaryKey = 'id';

    protected $fillable = [];

    // protected static function newFactory()
    // {
    //     return \Modules\Configuration\Database\factories\BussinesPartnerDesignationFactory::new();
    // }
}
