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
}
