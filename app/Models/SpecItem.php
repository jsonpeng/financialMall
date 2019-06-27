<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpecItem extends Model
{

    public $table = 'spec_items';
    
    protected $connection = 'mysql-shop';
    public $fillable = [
        'name',
        'spec_id'
    ];

}
