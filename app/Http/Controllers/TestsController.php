<?php

namespace App\Http\Controllers;

use App\Jobs\HostingsTester;
use App\{Hosting, Change};
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Queue\Redis;
use Illuminate\Support\{Facades\DB, Arr, Str};

class TestsController extends Controller implements ShouldQueue
{
    // protected $dontMakeIt = true;

     /**
     * Start a test job queue
     *
     * @return \Illuminate\Http\Response
     */    
    public function job() 
    {
        HostingsTester::dispatch();
    }

     /**
     * Run test
     *
     * @return \Illuminate\Http\Response
     */
    public function command() 
    {
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
        $theRealHosting = $hosting;
        $tests = [];

        $url = $hosting->domain_name ?: $hosting->ip_address;
        $test = $this->test($url);

        $lines = preg_split('/\n|\r\n?/', $test['header']);
        $server = '';
        $date = '';
        $x_powered_by = '';
        $expires = '';

        foreach ($lines as $line) {
            if (Str::contains($line, 'Server')) {
                $server = substr($line, 8);         
            }

            if (Str::contains($line, 'X-Powered-By')) {
                $x_powered_by = substr($line, 14);
            }
        }

        $matches = [];
        $title = '';

        if (preg_match('/<title>(.*?)<\/title>/', $test['body'], $matches)) {
            $title = $matches[1];
        }
        
        $certMIXED = '';
        foreach ($test['info']['certinfo'] as $cert) {
            foreach ($cert as $value) {
                $certMIXED .= $value.'|';
            }
        }
        $table = DB::table('hostings_checked');
        $host = $table->where('host_id', $hosting->id);
        if ($host->first()) {
            $host = $host->first();
            $changeCreated = Change::where('host_id', $host->id);
            $changeCreatedFound = false;

            if ($changeCreated->first()) {
                $changeCreatedFound = true;
            }

            if ($host->title != $title) {
                if ($changeCreatedFound) {
                    $changeCreated->update([
                        'title_old' => $host->title,
                        'title_new' => $title
                    ]);
                } else {
                    $changeCreatedFound = true;
                    Change::create([
                        'host_id' => $theRealHosting->id,
                        'title_old' => $host->title,
                        'title_new' => $title
                    ]);
                }
            }
            if ($host->cms != $test['cms']) {
                if ($changeCreatedFound) {
                    $changeCreated->update([
                        'cms_old' => $host->cms,
                        'cms_new' => $test['cms']
                    ]);
                } else {
                    $changeCreatedFound = true;
                    Change::create([
                        'host_id' => $theRealHosting->id, 
                        'cms_old' => $host->cms,
                        'cms_new' => $test['cms']
                    ]);
                }
            }

            if ($host->http_code != $test['info']['http_code']) {
                if ($changeCreatedFound) {
                    $changeCreated->update([
                        'http_code_old' => $host->http_code,
                        'http_code_new' => $test['info']['http_code']
                    ]);
                } else {
                    $changeCreatedFound = true;
                    Change::create([
                        'host_id' => $theRealHosting->id,
                        'http_code_old' => $host->http_code,
                        'http_code_new' => $test['info']['http_code']
                    ]);
                }
            }

            if ($host->server != $server) {
                if ($changeCreatedFound) {
                    $changeCreated->update([
                        'server_old' => $host->server,
                        'server_new' => $server
                    ]);
                } else {
                    $changeCreatedFound = true;
                    Change::create([
                        'host_id' => $theRealHosting->id,
                        'server_old' => $host->server,
                        'server_new' => $server
                    ]);
                }
            }

            if ($host->x_powered_by != $x_powered_by) {
                if ($changeCreatedFound) {
                    $changeCreated->update([
                        'x_powered_by_old' => $host->x_powered_by,
                        'x_powered_by_new' => $x_powered_by
                    ]);
                } else {
                    $changeCreatedFound = true;
                    Change::create([
                        'host_id' => $theRealHosting->id,
                        'x_powered_by_old' => $host->x_powered_by,
                        'x_powered_by_new' => $x_powered_by
                    ]);
                }
            }

            $tableToBeUpdated = DB::table('hostings_checked')->where('host_id', $hosting->id);
            $tableToBeUpdated->update([
                'title' => $title ?? 'false',
                'host_id' => $hosting->id,
                'cms' => $test['cms'],
                'url' => $test['info']['url'],
                'http_code' => $test['info']['http_code'],
                'total_time' => $test['info']['total_time'],
                'namelookup_time' => $test['info']['namelookup_time'],
                'connect_time' => $test['info']['connect_time'],
                'pretransfer_time' => $test['info']['pretransfer_time'],
                'size_download' => $test['info']['size_download'],
                'speed_download' => $test['info']['speed_download'],
                'starttransfer_time' => $test['info']['starttransfer_time'],
                'primary_ip' => $test['info']['primary_ip'],
                'certinfo' => $certMIXED,
                'primary_port' => $test['info']['primary_port'],
                'local_ip' => $test['info']['local_ip'],
                'local_port' => $test['info']['local_port'],
                'server' => $server,
                'date' => $date,
                'x_powered_by' => $x_powered_by,
                'expires' => $expires,
                'updated_at' => now()
            ]);
        } else {
            $table->insert([
                'title' => $title ?? 'false',
                'host_id' => $hosting->id,
                'cms' => $test['cms'],
                'url' => $test['info']['url'],
                'http_code' => $test['info']['http_code'],
                'total_time' => $test['info']['total_time'],
                'namelookup_time' => $test['info']['namelookup_time'],
                'connect_time' => $test['info']['connect_time'],
                'pretransfer_time' => $test['info']['pretransfer_time'],
                'size_download' => $test['info']['size_download'],
                'speed_download' => $test['info']['speed_download'],
                'starttransfer_time' => $test['info']['starttransfer_time'],
                'primary_ip' => $test['info']['primary_ip'],
                'certinfo' => $certMIXED,
                'primary_port' => $test['info']['primary_port'],
                'local_ip' => $test['info']['local_ip'],
                'local_port' => $test['info']['local_port'],
                'server' => $server,
                'date' => $date,
                'x_powered_by' => $x_powered_by,
                'expires' => $expires,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        
        $okay = 0;
        $okay = DB::table('tests_completed')->first()->count ?? 0;
        $okay = $okay + 1;
        
        DB::table('tests_completed')->limit(1)->update(['count' => $okay]);
        DB::table('has_been')->limit(1)->update(['count' => $hosting->id]);
        return ['true' => true];
    }

    /**
     * Return main test data
     *
     * @return \Illuminate\Http\Response
     */
    public function test($url = null, $wasRedirect = false) 
    {
        $domain = $url ?: "bayramalytextilex.gov.tm";
        $ch = curl_init($domain);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_CERTINFO, true);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_FILETIME, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_COOKIESESSION, true);
        curl_setopt($ch, CURLOPT_MAXCONNECTS, true);
        curl_setopt($ch, CURLOPT_COOKIE, true);
        $theRET = curl_exec($ch);
        $info = curl_getinfo($ch);
        
        curl_close($ch);

        $redirect_http_codes = [300, 301, 302, 303, 304, 305, 306, 307, 308];
        foreach ($redirect_http_codes as $redirect_http_code) {
            if ($info['http_code'] == $redirect_http_code) {
                return $this->test($info['redirect_url'], true);
            }
        }

        $header = substr($theRET, 0, $info['header_size']);
        $body = substr($theRET, $info['header_size']);

        // CMS Detector
        $cms = new \DetectCMS\DetectCMS($domain);

        $cmsName = mb_convert_encoding($cms->getResult(), 'UTF-8', 'UTF-8');
        $info = mb_convert_encoding($info, 'UTF-8', 'UTF-8');
        $header = mb_convert_encoding($header, 'UTF-8', 'UTF-8');
        $body = mb_convert_encoding($body, 'UTF-8', 'UTF-8');
        
        return [
            'cms' => $cmsName, 
            'info' => $info,
            'header' => $header,
            'body' => $body,
            'wasRedirected' => $wasRedirect
        ];
    }
}
