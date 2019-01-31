<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Adjustment;


class AdminAdjustment extends Model
{
    public static function show()
    {
    	return Adjustment::all();

    }
}
