<?php

namespace App\Http\Controllers;

use App\Adjustment;
use Illuminate\Http\Request;
use App\Lib\Settings;

class ServantAdjustmentController extends Controller
{
    //
	public function __construct()
	{
    	$this->middleware('auth:servant');
    }

	public function index(Request $request, Settings $settings) 
	{
		$filters = $request->filters;
		return (new Adjustment())->index($filters, $settings);


    }
	public function resolve(Request $request)
	{
		$adjustments = $request->adjustments;
		$decision = $request->decision;
		$reason = $request->reason;
		return (new Adjustment())->resolve($adjustments, $decision, $reason);
	}
}
