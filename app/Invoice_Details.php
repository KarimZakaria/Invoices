<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice_Details extends Model
{
    protected $guarded = ['id'];

    public function invoice()
    {
        return $this->belongsTo('App\Invoice');
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
    }
}
