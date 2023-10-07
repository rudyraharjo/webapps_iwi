<?php

namespace Modules\Configuration\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BusinessPartnerCategory extends Model
{
    use HasFactory;
    protected $table = 'c_business_partner_categories';
    protected $primaryKey = 'id';
    protected $fillable = [];

    // protected static function newFactory()
    // {
    //     return \Modules\Configuration\Database\factories\BusinessPartnerCategoryFactory::new();
    // }
}
