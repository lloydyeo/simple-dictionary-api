<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dictionary;

class DictionaryController extends Controller
{
    public function upsert(Request $request) {
        if ($request->isJson()) {
            //Check if JSON is well-formed

        } else {

        }
    }
}
