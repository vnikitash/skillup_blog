<?php
/**
 * Created by PhpStorm.
 * User: viktor
 * Date: 17.11.2020
 * Time: 20:14
 */

namespace App\Http\Controllers\Webhooks;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ViberController extends Controller
{
    public function webhook(Request $request)
    {
        die(__CLASS__ . '::' . __METHOD__);
    }
}