<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AdminAdjustment;
use App\Adjustment;
use App\Subject;

use Carbon\Carbon;

class AdminAdjustmentsController extends Controller
{
    public function __construct() {
    	$this->middleware('auth');
    }

    public function index() {
    	$adjustments = Adjustment::all();
        $subjects = Subject::all();
    	return view('admin.ajuste.index', compact('adjustments', 'subjects'));
    }

    public function filter(Request $request) {
        $filter = $request->filter_params;

        $adjustments = (new Adjustment)->filter($filter);

        $adjustments = collect(json_decode(json_encode($adjustments), true));

        $html = view('admin.ajuste.filtered', compact('adjustments'))->render();

        return array('success' => true, 'html' => $html);
    }
    public function update(Request $request) {
        $adjustBag = $request->adjust_bag;
        $update = $request->update;
        $result = null;


        if($update == 'defer') $result = Adjustment::defer($adjustBag);
        else $result = Adjustment::deny($adjustBag);

        if($result) return response($result, 200);
        else return response(array(
                        'success' => false, 
                        'reason' => 'Erro no processamento do ajuste.'), 500);
    }
}
