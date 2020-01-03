<?php

namespace App\Http\Controllers;

use App\Hosting;
use App\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EjenSikeyinController extends Controller
{
    public function index() 
    {
        if (count(Hosting::all()) < 1) {
            dd('No hosting');
        }
        $hasBeenTable = DB::table('has_been')->first();
        
        if (! $hasBeenTable) {
            DB::table('has_been')->insert(['count' => Hosting::first()->id]);
            $hasBeenTable = DB::table('has_been')->first();
        }
        
        $hosting = optional(
            Hosting::find($hasBeenTable->count)
        )->next();
        if (!$hosting ) {
            $hosting = Hosting::first();
        }

        // Grab fucking url
        $url = $hosting->domain_name;

        // Initialize fucking Curl
        $ch = curl_init();

        // Set fucking options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        // curl_setopt($ch, CURLOPT_COOKIE, true);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, ['Request-By: TELECOMBOT']);

        $html = curl_exec($ch);
        $data = curl_getinfo($ch);
        
        $error = curl_error($ch);
        
        curl_close($ch);

        $header = substr($html, 0, $data['header_size']);
        $body = substr($html, $data['header_size']);

        $header = mb_convert_encoding($header, 'UTF-8', 'UTF-8');
        $body = mb_convert_encoding($body, 'UTF-8', 'UTF-8'); 
        
        $table = DB::table('results');
        $host = $table->where('hosting_id', $hosting->id);
        if ($host->first()) {
            $host = $host->first();
            $tableToBeUpdated = DB::table('results')->where('hosting_id', $hosting->id);
            $tableToBeUpdated->update([
                'hosting_id' => $hosting->id,
                'http_code' => $data['http_code'],
                'redirect_count' => $data['redirect_count'],
                'total_time' => $data['total_time'],
                'primary_ip' => $data['primary_ip'],
                'cms' => 'Undetected',
                'error' => $error,
                'updated_at' => now()
            ]);
        } else {
            $table->insert([
                'hosting_id' => $hosting->id,
                'http_code' => $data['http_code'],
                'redirect_count' => $data['redirect_count'],
                'total_time' => $data['total_time'],
                'primary_ip' => $data['primary_ip'],
                'cms' => 'Undetected',
                'error' => $error,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        
        
        // $okay = 0;
        // $okay = DB::table('tests_completed')->first()->count ?? 0;
        // $okay = $okay + 1;
        
        // DB::table('tests_completed')->limit(1)->update(['count' => $okay]);
        DB::table('has_been')->limit(1)->update(['count' => $hosting->id]);

        $makeTheSound = false;
        if ($data['http_code'] != 200) {
            $makeTheSound = true;
        }
        return view('pages.home', [
            'results' => Result::all(),
            'makeTheSound' => $makeTheSound
        ]);
    }

    public function test($url = null) 
    {
        // Grab fucking url
        $url = $url ?: 'gujurlynesil.edu.tm';

        // Initialize fucking Curl
        $ch = curl_init();

        // Set fucking options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_COOKIE, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Request-By: TELECOMBOT']);

        $html = curl_exec($ch);
        $data = curl_getinfo($ch);
        
        $error = curl_error($ch);
        $header = substr($html, 0, $data['header_size']);
        $body = substr($html, $data['header_size']);

        curl_close($ch);

        $header = mb_convert_encoding($header, 'UTF-8', 'UTF-8');
        $body = mb_convert_encoding($body, 'UTF-8', 'UTF-8');
        
        return [
            'data' => $data,
            'header' => $header,
            'body' => $body,
            'error' => (Str::contains($body, 'Account disabled by server administrator')) ? 'Account disabled by server administrator' : $error,
            'cms' => 'Undetected'
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Hosting $hosting) 
    {
        return view('pages.hostings.show-tested', [
            'hosting' => $hosting,
            'test' => Result::where('hosting_id', $hosting->id)->first()
        ]);
    }

    /**
     * No need for register
     *
     * @return \Illuminate\Http\Response
     */
    public function register() 
    {
        return abort(404);
    }
}
