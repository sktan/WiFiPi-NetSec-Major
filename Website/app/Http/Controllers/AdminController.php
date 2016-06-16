<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('admin');
    }
    
    public function getListUsers() {
        // return a list of users
    }

    public function getEditUser(Request $request, $id) {

    }

    public function postEditUser(Request $request, $id) {
        
    }

    public function getListNetworks(Request $request) {
        $fp = fsockopen("10.10.10.20", 27015, $errno, $errstr, 30);
        if (!stream_set_timeout($fp, 30)) die("Could not set timeout");

        if (!$fp) {
            die("$errstr ($errno)<br />\n");
        } else {
            fputs($fp, "list");
            $networks = fgets($fp); 
            
            fclose($fp);
        }

        return View('admin.list', ['networks' => explode('|', $networks)]);
    }

    public function getConnectNetwork(Request $request, $network) {
        return View('admin.connect', ['network' => base64_decode($network)]);
    }
    
    public function postConnectNetwork(Request $request, $network) {
        $fp = fsockopen("10.10.10.20", 27015, $errno, $errstr, 30);
        if (!stream_set_timeout($fp, 30)) die("Could not set timeout");

        if (!$fp) {
            die("$errstr ($errno)<br />\n");
        } else {
            fputs($fp, "wifi " . $network . " " . base64_encode($request->password));
            
            fclose($fp);
        }
        return View('admin.connect', [
            'network' => base64_decode($network),
            'success' => true,
        ]);
    }
}
