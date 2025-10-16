<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagihanController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('index2');
});

Route::get('/dua', function () {
    return view('index');
});

Route::get('/list-tahun-akademik', function() {
    $response = Http::post('http://103.23.103.43/WEB_TAGIHAN_PROJECT/WS_DEMO_MULTIPLE/index.php?path=list-tahun-aka');
    return response()->json($response->json());
});

Route::post('/api/cek-tagihan', function (Request $request) {
    $response = Http::post('http://103.23.103.43/WEB_TAGIHAN_PROJECT/WS_DEMO_MULTIPLE/index.php?path=cek-tagihan', $request->all());
    return response()->json($response->json());
});

Route::post('/api/generate-va', function (Request $request) {
    $response = Http::post('http://103.23.103.43/WEB_TAGIHAN_PROJECT/WS_DEMO_MULTIPLE/index.php?path=generate-va', $request->all());
    return response()->json($response->json());
});


Route::post('/dua', [TagihanController::class, 'cek'])->name('tagihan.cek');

Route::post('/', [TagihanController::class, 'cek2'])->name('tagihan.cek2');
Route::get('/tagihan/view', [TagihanController::class, 'tagihanView'])->name('tagihan.view');
Route::post('/pembayaran/buat-va', [TagihanController::class, 'buatVA'])->name('pembayaran.buatva');