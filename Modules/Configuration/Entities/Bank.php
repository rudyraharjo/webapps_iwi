<?php

namespace Modules\Configuration\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bank extends Model
{
    use HasFactory;

    protected $table = 'c_banks';
    protected $primaryKey = 'id';
    protected $fillable = [];
    
    // protected static function newFactory()
    // {
    //     return \Modules\Configuration\Database\factories\BankFactory::new();
    // }
}
