<?php
/**
 * Created by PhpStorm.
 * User: viktor
 * Date: 24.11.2020
 * Time: 19:12
 */

namespace App\Http\Controllers;


class JSController extends Controller
{
    public function index()
    {

        return view('js');
    }

    public function index2()
    {

        return view('js2');
    }
}