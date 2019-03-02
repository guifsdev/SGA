<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ConfigAdjustment extends Model
{
    protected $fillable = ['nome','options'];
    private $m_config;

    public function __construct() {
    	$config = \DB::table('config_adjustments')->first()->options;
        $config = json_decode($config, true);
        $this->m_config = $config;
        //$this->m_dates = ['abertura' => $config['abertura'], 'fechamento' => $config['fechamento']];
        //$this->m_maxAdj = $config['max_ajustes'];
    }

    public function getConfig()
    {
        $config = $this->m_config;
        //dd($config);
        $config['abertura'] = (new Carbon($config['abertura']))->format('Y-m-d\TH:i:s');
        $config['fechamento'] = (new Carbon($config['fechamento']))->format('Y-m-d\TH:i:s');

    	return $config;
    }

    public static function store(Request $request)
    {
        //dd($request->abertura);
        $config = [
            'abertura' => (new Carbon($request->abertura))->format('Y-m-d\TH:i:s'),
            'fechamento' => (new Carbon($request->fechamento))->format('Y-m-d\TH:i:s'),
            'max_ajustes' => $request->max_ajustes,
        ];

    	$update = ConfigAdjustment::where('nome', 'config')
    		->update([
    			'options' => json_encode($config, true),
    		]);
		

    	return (bool) $update;
    }

    
}
