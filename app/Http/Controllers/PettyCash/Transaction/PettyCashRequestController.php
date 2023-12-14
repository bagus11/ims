<?php

namespace App\Http\Controllers\PettyCash\Transaction;

use App\Http\Controllers\Controller;
use App\Models\PettyCash\Transaction\PettyCashRequest;
use Illuminate\Http\Request;

class PettyCashRequestController extends Controller
{
    function index() {
        return view('pettycash.transaction.pettycash_request.pettycash_request-index');
    }
    function getPettyCashRequest() {
        $data = PettyCashRequest::with([
            'picRelation',
            'locationRelation',
            'categoryRelation',
        ])->get();
        return response()->json([
            'data'=>$data,
        ]); 
    }

}
