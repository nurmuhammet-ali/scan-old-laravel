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

        $test = $this->test($hosting->domain_name);

        $table = DB::table('results');
        $host = $table->where('hosting_id', $hosting->id);
        if ($host->first()) {
            $host = $host->first();
            $tableToBeUpdated = DB::table('results')->where('hosting_id', $hosting->id);
            $tableToBeUpdated->update([
                'hosting_id' => $hosting->id,
                'http_code' => $test['status_code'],
                'redirect_count' => $test['info']['redirect_count'],
                'total_time' => $test['info']['connect_time'],
                'primary_ip' => $test['info']['primary_ip'],
                'cms' => 'Undetected',
                'error' => $test['error'],
                'updated_at' => now()
            ]);
        } else {
            $table->insert([
                'hosting_id' => $hosting->id,
                'http_code' => $test['status_code'],
                'redirect_count' => $test['info']['redirect_count'],
                'total_time' => $test['info']['total_time'],
                'primary_ip' => $test['info']['primary_ip'],
                'cms' => 'Undetected',
                'error' => $test['error'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        
        
        // $okay = 0;
        // $okay = DB::table('tests_completed')->first()->count ?? 0;
        // $okay = $okay + 1;
        
        // DB::table('tests_completed')->limit(1)->update(['count' => $okay]);
        DB::table('has_been')->limit(1)->update(['count' => $hosting->id]);

        return view('pages.home', [
            'results' => Result::all()
        ]);
    }

    public function test($url = null) 
    {
        // Grab fucking url
        $url = $url ?: 'bayramalytextilex.gov.tm';

        \Unirest\Request::timeout(10);
        \Unirest\Request::verifyPeer(false); // Disables SSL cert validation
        \Unirest\Request::verifyHost(false); // Disables SSL cert validation
        \Unirest\Request::curlOpt(CURLOPT_HTTPHEADER, ['Request-By: TELECOMBOT']);

        $response = \Unirest\Request::get('http://'.$url);
        $info = \Unirest\Request::getInfo();
        
        $info = $this->encode_items($info);
        $headers = '';
        $body = $this->encode_items($response->raw_body);
        $error = '';
        $status_code = $response->code;

        if (Str::contains($body, 'Account disabled by server administrator')) {
            $status_code = 403;    
            $error = 'Account disabled by server administrator';  
        } elseif ((Str::contains($body, 'ISPsystem') || Str::contains($body, 'ISPmanager')) && Str::contains($body, 'Real content coming soon.')) {
            $status_code = 403;    
            $error = 'Acccount not used by user';
        } elseif (Str::contains($body, 'Apache2 Ubuntu Default Page')) {
            $status_code = 403;    
            $error = 'Acccount not used by user';
        }

        return [
            'status_code' => $status_code,
            'headers' => $headers,
            'body' => $body,
            'info' => $info,
            'error' => $error,
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

    public function encode_items($array)
    {
        if (is_string($array) || is_int($array)) {
            return mb_convert_encoding($array, 'UTF-8', 'UTF-8');
        }
        
        if (is_array($array)) {
            foreach($array as $key => $value) {
                if(is_array($value)) {
                    $array[$key] = $this->encode_items($value);
                } else {
                    $array[$key] = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
                }
            }   
        }

        return $array;
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
