<?php

namespace App\Http\Controllers;

use App\{Plan, Type, Hosting};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HostingsController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.hostings.create', [
            'plans' => Plan::all(),
            'types' => Type::all()
        ]);
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
            'company_name' => 'required', 'company_address' => 'required',
            'vps_number' => 'required|numeric', 'phone_number' => 'required',
            'letter_number' => 'required', 'letter_at' => 'required',
            'employer_name' => 'required', 'responsible_employee_name' => 'required',
            'responsible_employee_phone_number' => 'required',
            'responsible_employee_email' => 'required|email',
            'responsible_employee_home_number' => 'required',
            'responsible_employee_job_number' => 'required',
            'contract_at' => 'required', 'associated_at' => 'required',
            'number_noted' => 'required', 'more' => 'required',
            'domain_name' => 'unique:hostings,domain_name'
        ]);

        if ($request->domain_name) {
            $this->validate($request, ['domain_name' => 'required']);
        }

        if ($request->ip_address) {
            $this->validate($request, ['ip_address' => 'required']);
        }

        Hosting::create([
            'company_name' => $request->company_name,
            'company_address' => $request->company_address,
            'vps_number' => $request->vps_number,
            'phone_number' => $request->phone_number,
            'letter_number' => $request->letter_number,
            'letter_at' => $request->letter_at,
            'employer_name' => $request->employer_name,
            'responsible_employee_name' => $request->responsible_employee_name,
            'responsible_employee_phone_number' => $request->responsible_employee_phone_number,
            'responsible_employee_email' => $request->responsible_employee_email,
            'responsible_employee_home_number' => $request->responsible_employee_home_number,
            'responsible_employee_job_number' => $request->responsible_employee_job_number,
            'contract_at' => $request->contract_at,
            'domain_name' => $request->domain_name,
            'plan' => $request->plan ?? 'tarifsiz',
            'ip_address' => $request->ip_address,
            'associated_at' => $request->associated_at,
            'type' => $request->type ?: 'görnüşi ýok',
            'number_noted' => $request->number_noted,
            'more' => $request->more
        ]);

        return back()->with('success', 'Üstünlikli ýerine ýetirildi');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Hosting $hosting)
    {
        return view('pages.hostings.show', [
            'hosting' => $hosting,
            'plans' => Plan::all(),
            'types' => Type::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Hosting $hosting)
    {
        $request = request();
        
        $this->validate($request, [
            'company_name' => 'required', 'company_address' => 'required',
            'vps_number' => 'required', 'phone_number' => 'required',
            'letter_number' => 'required', 'letter_at' => 'required',
            'employer_name' => 'required', 'responsible_employee_name' => 'required',
            'responsible_employee_phone_number' => 'required',
            'responsible_employee_email' => 'required',
            'responsible_employee_home_number' => 'required',
            'responsible_employee_job_number' => 'required',
            'contract_at' => 'required', 'associated_at' => 'required',
            'number_noted' => 'required', 'more' => 'required'
        ]);

        if ($request->domain_name) {
            $this->validate($request, [
                'domain_name' => 'required'
            ]);
        }

        if ($request->ip_address) {
            $this->validate($request, [
                'ip_address' => 'required'
            ]);
        }

        $hosting->update([
            'company_name' => $request->company_name,
            'company_address' => $request->company_address,
            'vps_number' => $request->vps_number,
            'phone_number' => $request->phone_number,
            'letter_number' => $request->letter_number,
            'letter_at' => $request->letter_at,
            'employer_name' => $request->employer_name,
            'responsible_employee_name' => $request->responsible_employee_name,
            'responsible_employee_phone_number' => $request->responsible_employee_phone_number,
            'responsible_employee_email' => $request->responsible_employee_email,
            'responsible_employee_home_number' => $request->responsible_employee_home_number,
            'responsible_employee_job_number' => $request->responsible_employee_job_number,
            'contract_at' => $request->contract_at,
            'domain_name' => $request->domain_name,
            'plan' => $request->plan ?? 'tarifsiz',
            'ip_address' => $request->ip_address,
            'associated_at' => $request->associated_at,
            'type' => $request->type ?: 'görnüşi ýok',
            'number_noted' => $request->number_noted,
            'more' => $request->more
        ]);

        return back()->with('success', 'Üstünlikli ýerine ýetirildi');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hosting $hosting)
    {
        $hosting->delete();
        
        return back()->with('success', 'Üstünlikli ýerine ýetirildi');
    }
}
