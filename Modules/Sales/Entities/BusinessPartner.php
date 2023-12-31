<?php

namespace Modules\Sales\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BusinessPartner extends Model
{
    use HasFactory;

    protected $table = 's_business_partners';
    protected $primaryKey = 'id';
    protected $fillable = [];

    // protected static function newFactory()
    // {
    //     return \Modules\Sales\Database\factories\BusinessPartnerFactory::new();
    // }
}
