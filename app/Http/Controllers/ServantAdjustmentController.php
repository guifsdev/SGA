<?php

namespace App\Http\Controllers;

use App\Adjustment;
use Illuminate\Http\Request;

class ServantAdjustmentController extends Controller
{
    //
	public function __construct()
	{
    	$this->middleware('auth:servant');
    }

	public function index(Request $request) 
	{
		$filters = $request->filters;
		return (new Adjustment())->index($filters);

    }
	public function resolve(Request $request)
	{
		$adjustments = $request->adjustments;
		$decision = $request->decision;
		$reason = $request->reason;
		return (new Adjustment())->resolve($adjustments, $decision, $reason);
	}
}
