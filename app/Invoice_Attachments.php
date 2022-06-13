<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice_Attachments extends Model
{

    protected $guarded = ['id'];

    public function invoice()
    {
        return $this->belongsTo('App\Invoice');
    }
}
