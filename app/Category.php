<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    public function product()
    {
        return $this->hasMany(Product::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
}
