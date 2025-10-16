<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TagihanController extends Controller
{
    
   public function cek(Request $request)
{
    $request->validate([
        'no_cust' => 'required|string',
        'academic_year' => 'required|string'
    ]);

    $response = Http::post('http://103.23.103.43/WEB_TAGIHAN_PROJECT/WS_DEMO_MULTIPLE/index.php?path=cek-tagihan', [
        'va' => $request->no_cust,
        'tahun_akademik' => $request->academic_year
    ]);

    $result = $response->json();

    return view('index', compact('result'))
           ->with([
               'va' => $request->no_cust,
               'academic_year' => $request->academic_year
           ]);
}

public function cek2(Request $request)
{
    $request->validate([
        'no_cust' => 'required|string',
        'password' => 'required|string',
        'academic_year' => 'required|string'
    ]);

    $response = Http::post('http://103.23.103.43/WEB_TAGIHAN_PROJECT/WS_DEMO_MULTIPLE/index.php?path=cek-tagihan-pw', [
        'va' => $request->no_cust,
        'password' => $request->password,
        'tahun_akademik' => $request->academic_year
    ]);

    $result = $response->json();

    if (!$result['status']) {
        return back()->with([
            'error' => $result['message'],
            'va' => $request->no_cust,
            'academic_year' => $request->academic_year
        ]);
    }

    return view('index2', compact('result'))
        ->with([
            'va' => $request->no_cust,
            'academic_year' => $request->academic_year
        ]);
}

    public function tagihanView()
    {
        return view('tagihan');
    }

}