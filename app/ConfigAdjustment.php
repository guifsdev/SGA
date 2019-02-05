<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ConfigAdjustment extends Model
{
    //protected $fillable = ['nome','datas'];


    private  $m_dates;


    public function __construct() {
    	$config = \DB::table('config_adjustments')->where('nome', 'datas')->first();
    	$this->m_dates = json_decode($config->options, true);
    }


    public function dates()
    {
    	return $this->m_dates;
    }

    public static function store(Request $request)
    {
    	$datas['abertura'] = $request['abertura'];
    	$datas['fechamento'] = $request['fechamento'];
//dd(json_encode($datas));

    	$update = ConfigAdjustment::where('nome', 'datas')
    		->update([
    			'options' => json_encode($datas)
    		]);
		

    	return (bool) $update;
    }

    
}
