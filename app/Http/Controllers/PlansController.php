<?php

namespace App\Http\Controllers;

use App\Plan;
use Illuminate\Http\Request;

class PlansController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.plans.index')->with('plans', Plan::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:plans,name'
        ]);
        $plan = new Plan();
        $plan->name = $request->name;
        $plan->save();

        return back()->with('success', 'Üstünlikli ýerine ýetirildi');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, ['id' => 'required', 'name' => 'required']);
        Plan::find($request->id)->update(['name' => $request->name]);

        return ($request->ajax()) ? 'Üstünlikli ýerine ýetirildi' : back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->validate($request, ['id' => 'required']);
        Plan::find($request->id)->delete();
        
        return ($request->ajax()) ? 'Üstünlikli ýerine ýetirildi' : back();
    }
}
