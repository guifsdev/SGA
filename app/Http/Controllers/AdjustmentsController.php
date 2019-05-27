<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Adjustment;
use App\Subject;
use Carbon\Carbon;
use Validator;
use App\Mail\AdjustmentSent;


class AdjustmentsController extends Controller
{

	public function __construct() {
        $this->middleware('auth_student');
    }
    public function status() {
        $open = Adjustment::isOpen();
        return response(['open' => $open], 200);
    }
    
    public function store(Request $request) {
        $student = $request->student;
        $adjustments = $request->adjustments;

        Validator::make($request->adjustments, [
            'period' => 'required|min:1|max:8',
            'subject_id' => 'required|integer',
            'action' => 'boolean',
        ]);

        $result = Adjustment::store($student, $adjustments);

        if($result['success']) {
            $mail = \Mail::to($student['email'])
                ->send(new AdjustmentSent($student, $result['adjustments']));
            return 
                response([
                    'success' => true,
                    'message' => 'Requerimento enviado com sucesso para análise pelo SGA. Recomenda-se que o aluno imprima/salve este comprovante e acompanhe o resultado pelo idUFF.',
                    'stamp' => $result['stamp']]);
        }
    }





}
