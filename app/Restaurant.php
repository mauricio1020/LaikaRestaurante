<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    protected $fillable = [
        "name",
        "description",
        "address",
        "city",
        "photo_url",
    ];

    public function reservation()
    {
        return $this->hasMany(Reserve::class);
    }

    public function scopeSearch($query, $request)
    {
        return $query->when($request->has("search"), function ($query) use ($request) {
            $search = $request->search;

            return $query->where("name", "like", "%$search%")->orWhere("city", "like", "%$search%");
        });
    }

}
