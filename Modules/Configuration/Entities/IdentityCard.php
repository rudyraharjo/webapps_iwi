<?php

namespace Modules\Configuration\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IdentityCard extends Model
{
    use HasFactory;

    protected $table = 'c_identity_cards';
    protected $primaryKey = 'id';
    protected $fillable = [];

    // protected static function newFactory()
    // {
    //     return \Modules\Configuration\Database\factories\IdentityCardFactory::new();
    // }
}
