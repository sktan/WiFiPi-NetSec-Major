<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

class MainController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Redirect to the correct page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return redirect('/auth_success');
    }
    
    /**
     * Show the authentication success page.
     *
     * @return \Illuminate\Http\Response
     */
    public function success() {
        $fp = fsockopen("127.0.0.1", 27015, $errno, $errstr, 30);
        if (!$fp) {
            die("$errstr ($errno)<br />\n");
        } else {
            fputs($fp, "firewall " . $_SERVER['REMOTE_ADDR']);
            fclose($fp);
        }

        return view('auth.completed');
    }
}
