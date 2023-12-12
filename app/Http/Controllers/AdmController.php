<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdmController extends Controller
{
    public function __invoke(){
        return view ('adm.index');
    }
}
