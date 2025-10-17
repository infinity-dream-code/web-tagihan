<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagihanController;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('index2');
});

Route::get('/dua', function () {
    return view('index');
});


Route::get('/list-tahun-akademik', function() {
    try {
        $response = Http::timeout(30)
            ->withoutVerifying()
            ->get('http://10.99.23.111/WEB_TAGIHAN_PROJECT/WS_DEMO_MULTIPLE/index.php', [
                'path' => 'list-tahun-aka'
            ]);

        \Log::info('WS Response', [
            'status' => $response->status(),
            'body' => $response->body()
        ]);

        if ($response->successful()) {
            return response()->json($response->json());
        }
        
        return response()->json([
            'status' => false,
            'message' => 'API tidak memberikan response yang valid'
        ], 500);
        
    } catch (\Exception $e) {
        \Log::error('Error fetching tahun akademik', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        
        return response()->json([
            'status' => false,
            'message' => 'Gagal mengambil data tahun akademik',
            'error' => $e->getMessage()
        ], 500);
    }
});

Route::post('/api/cek-tagihan', function (Request $request) {
    try {
        \Log::info('Cek Tagihan Request', $request->all());
        
        $response = Http::timeout(30)
            ->withoutVerifying()
            ->withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ])
            ->post('http://103.23.103.43/WEB_TAGIHAN_PROJECT/WS_DEMO_MULTIPLE/index.php?path=cek-tagihan', [
                'va' => $request->input('va'),
                'tahun_akademik' => $request->input('tahun_akademik')
            ]);
        
        \Log::info('Cek Tagihan Response', [
            'status' => $response->status(),
            'body' => $response->body()
        ]);

        if ($response->successful()) {
            return response()->json($response->json());
        }
        
        return response()->json([
            'status' => false,
            'message' => 'Gagal cek tagihan',
            'response' => $response->body()
        ], $response->status());
        
    } catch (\Exception $e) {
        \Log::error('Cek Tagihan Error', [
            'message' => $e->getMessage(),
            'line' => $e->getLine(),
            'file' => $e->getFile()
        ]);
        
        return response()->json([
            'status' => false,
            'message' => 'Terjadi kesalahan',
            'error' => $e->getMessage()
        ], 500);
    }
});

Route::post('/api/cek-tagihan-pw', function (Request $request) {
    try {
        \Log::info('Cek Tagihan PW Request', $request->all());
        
        $response = Http::timeout(30)
            ->withoutVerifying()
            ->withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ])
            ->post('http://103.23.103.43/WEB_TAGIHAN_PROJECT/WS_DEMO_MULTIPLE/index.php?path=cek-tagihan-pw', [
                'va' => $request->input('va'),
                'password' => $request->input('password'),
                'tahun_akademik' => $request->input('tahun_akademik')
            ]);
        
        \Log::info('Cek Tagihan PW Response', [
            'status' => $response->status(),
            'body' => $response->body()
        ]);

        if ($response->successful()) {
            return response()->json($response->json());
        }
        
        return response()->json([
            'status' => false,
            'message' => 'Gagal cek tagihan',
            'response' => $response->body()
        ], $response->status());
        
    } catch (\Exception $e) {
        \Log::error('Cek Tagihan PW Error', [
            'message' => $e->getMessage()
        ]);
        
        return response()->json([
            'status' => false,
            'message' => 'Terjadi kesalahan',
            'error' => $e->getMessage()
        ], 500);
    }
});

Route::post('/api/generate-va', function (Request $request) {
    try {
        \Log::info('Generate VA Request', $request->all());
        
        $response = Http::timeout(30)
            ->withoutVerifying()
            ->withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ])
            ->post('http://103.23.103.43/WEB_TAGIHAN_PROJECT/WS_DEMO_MULTIPLE/index.php?path=generate-va', [
                'custid' => $request->input('custid'),
                'nocust' => $request->input('nocust'),
                'namacust' => $request->input('namacust'),
                'array_tagihan' => $request->input('array_tagihan'),
                'total' => $request->input('total')
            ]);
        
        \Log::info('Generate VA Response', [
            'status' => $response->status(),
            'body' => $response->body()
        ]);

        if ($response->successful()) {
            return response()->json($response->json());
        }
        
        return response()->json([
            'status' => false,
            'message' => 'Gagal generate VA',
            'response' => $response->body()
        ], $response->status());
        
    } catch (\Exception $e) {
        \Log::error('Generate VA Error', [
            'message' => $e->getMessage()
        ]);
        
        return response()->json([
            'status' => false,
            'message' => 'Terjadi kesalahan',
            'error' => $e->getMessage()
        ], 500);
    }
});

Route::post('/dua', [TagihanController::class, 'cek'])->name('tagihan.cek');

Route::post('/', [TagihanController::class, 'cek2'])->name('tagihan.cek2');

Route::get('/tagihan/view', [TagihanController::class, 'tagihanView'])->name('tagihan.view');

Route::post('/pembayaran/buat-va', [TagihanController::class, 'buatVA'])->name('pembayaran.buatva');