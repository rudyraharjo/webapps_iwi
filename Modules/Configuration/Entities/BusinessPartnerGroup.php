<?php

namespace Modules\Configuration\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BusinessPartnerGroup extends Model
{
    use HasFactory;
    protected $table = 'c_business_partner_groups';
    protected $primaryKey = 'id';
    protected $fillable = [];
    
    // protected static function newFactory()
    // {
    //     return \Modules\Configuration\Database\factories\BusinessPartnerGroupFactory::new();
    // }
}
