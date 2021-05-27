<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuditController extends Controller
{
    /**
     * Display listing of the resource
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('audits.create');
    }
}
