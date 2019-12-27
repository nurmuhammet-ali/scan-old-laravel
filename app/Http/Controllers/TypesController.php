<?php

namespace App\Http\Controllers;

use App\Type;
use Illuminate\Http\Request;

class TypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.types.index')->with('types', Type::all());
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
            'name' => 'required|unique:types,name'
        ]);
        $type = new Type();
        $type->name = $request->name;
        $type->save();

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
        Type::find($request->id)->update(['name' => $request->name]);

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
        Type::find($request->id)->delete();
        
        return ($request->ajax()) ? 'Üstünlikli ýerine ýetirildi' : back();
    }
}
