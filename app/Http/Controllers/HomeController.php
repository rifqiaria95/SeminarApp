<?php

namespace App\Http\Controllers;

use App\Models\DataSeminar;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $seminar = DataSeminar::with('pembicara')->latest()->take(5)->get();

        return view('dashboard', compact('seminar'));
    }
}
