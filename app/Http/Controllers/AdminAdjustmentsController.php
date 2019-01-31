<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AdminAdjustment;
use App\Adjustment;

use Carbon\Carbon;

class AdminAdjustmentsController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    }

    public function show()
    {

    	$adjustments = AdminAdjustment::show();


    	return view('admin.ajuste.show', compact('adjustments'));
    }

    public function configure()
    {
    	return 'AdminAdjustmentsController@configure';
    }

    public function filter() 
    {
        //dd(request());


        $from = request()->has('data-requerimento-de') ? 
            Carbon::parse(request('data-requerimento-de'))->startOfDay() : false;
        $to = request()->has('data-requerimento-ate') ? 
            Carbon::parse(request('data-requerimento-ate'))->endOfDay() : false;

        $input = request()->except(['_token', 'data-requerimento-de', 'data-requerimento-ate']);
        $adjustments = Adjustment::where($input)->get();
        if($from && $to) {
            $adjustments = $adjustments->where('created_at', '>=', $from)
                                       ->where('created_at', '<=', $to);
        }

        dd($adjustments);




    }
}
