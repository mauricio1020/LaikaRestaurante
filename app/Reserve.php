<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reserve extends Model
{
    protected $fillable = [
        "number_table",
        "restaurant_id",
        "date",
    ];

    protected $casts = [
        "date" => "date",
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
