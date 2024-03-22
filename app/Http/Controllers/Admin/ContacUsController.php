<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\contacUs;
use Illuminate\Http\Request;

class ContacUsController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->setPageTitle('Contacrt Us List');
        $data = contacUs::all();
        return view('admin.contact-us.list', compact('data'));
    }

   
}
