<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Control extends Model
{
//запрет на поля created_at и update_at
    public $timestamps = false;

    public function checkObjects()
    {
        return $this->belongsToMany(CheckObject::class);
    }
}
