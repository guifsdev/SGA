<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct() {
        $this->middleware('auth_student');
    }
    public function index()
    {
        return view('estudante.index');
        //return array('success' => true, 'html' => $html);
    }
    public function home() {
        $html = view('estudante.home')->render();
        return array('success' => true, 'html' => $html);
    }

    public function dados() {
        $html = view('estudante.meus-dados')->render();
        return array('success' => true, 'html' => $html);
    }

    public function ajuste() {
        $html = view('estudante.ajuste.index')->render();
        return array('success' => true, 'html' => $html);
    }
}
