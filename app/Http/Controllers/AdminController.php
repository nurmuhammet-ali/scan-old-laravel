<?php

namespace App\Http\Controllers;

use App\{Hosting, Change};
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.admin.index')->with('hostings', Hosting::all());
    }

    /**
     * Display a listing of the resource.
     *
     * @return Illuminate\Support\Facades\View
     */
    public function changes() 
    {
        return view('pages.changes.all', [
            'changes' => Change::all()
        ]);
    }
}
