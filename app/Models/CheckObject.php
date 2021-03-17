<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class CheckObject extends Model
{
    //запрет на поля created_at и update_at
    public $timestamps = false;

    public function controls()
    {
        return $this->belongsToMany(Control::class);
    }

}
