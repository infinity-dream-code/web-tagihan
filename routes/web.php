<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagihanController;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('index3');
});

Route::get('/app.webmanifest', function () {
    $prefix = rtrim(request()->getBasePath(), '/');
    $start = ($prefix === '' ? '' : $prefix).'/';

    $icon = function (string $file, string $size, string $purpose = 'any') use ($prefix) {
        return [
            'src' => $prefix.'/icons/'.$file,
            'sizes' => $size,
            'type' => 'image/png',
            'purpose' => $purpose,
        ];
    };

    $manifest = [
        'id' => $start,
        'name' => 'Cek Tagihan Sulaiman Al Fauzan',
        'short_name' => 'Tagihan SAF',
        'description' => 'Sistem Informasi Cek Tagihan Santri / Siswa Sulaiman Al Fauzan',
        'start_url' => $start,
        'scope' => $start,
        'display' => 'standalone',
        'orientation' => 'portrait-primary',
        'background_color' => '#0c1610',
        'theme_color' => '#15803d',
        'lang' => 'id',
        'dir' => 'ltr',
        'prefer_related_applications' => false,
        'categories' => ['finance', 'education'],
        'icons' => [
            $icon('icon-72x72.png', '72x72'),
            $icon('icon-96x96.png', '96x96'),
            $icon('icon-128x128.png', '128x128'),
            $icon('icon-144x144.png', '144x144'),
            $icon('icon-152x152.png', '152x152'),
            $icon('icon-192x192.png', '192x192'),
            $icon('icon-384x384.png', '384x384'),
            $icon('icon-512x512.png', '512x512'),
            $icon('icon-maskable-192x192.png', '192x192', 'maskable'),
            $icon('icon-maskable-512x512.png', '512x512', 'maskable'),
        ],
        'shortcuts' => [
            [
                'name' => 'Cek Tagihan',
                'short_name' => 'Cek Tagihan',
                'description' => 'Cek tagihan santri / siswa dengan nomor VA',
                'url' => $start,
                'icons' => [
                    [
                        'src' => $prefix.'/icons/icon-96x96.png',
                        'sizes' => '96x96',
                        'type' => 'image/png',
                    ],
                ],
            ],
        ],
    ];

    return response()->json($manifest, 200, [
        'Cache-Control' => 'no-cache',
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
        ->header('Content-Type', 'application/manifest+json');
});

Route::get('/dua', function () {
    return view('index');
});


Route::get('/list-tahun-akademik', [TagihanController::class, 'listTahunAkademik']);

Route::post('/cek-tagihan', function (Request $request) {
    try {
        $baseUrl = config('services.tagihan_ws.url') ?: 'http://103.23.103.43/WEB_TAGIHAN_PROJECT/WS_TAGIHAN_AL_FAUZAN/index.php';
        $response = Http::timeout(30)
            ->withoutVerifying()
            ->withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ])
            ->post($baseUrl.'?path=cek-tagihan', [
                'va' => TagihanController::normalizeVa($request->input('va')),
                'tahun_akademik' => $request->input('tahun_akademik')
            ]);

        \Log::info('WS cek-tagihan response', [
            'status' => $response->status(),
            'body' => $response->body()
        ]);

        if ($response->successful()) {
            return response()->json($response->json());
        }

        return response()->json([
            'status' => false,
            'message' => 'Gagal mengecek tagihan'
        ], 500);
    } catch (\Exception $e) {
        \Log::error('Error cek-tagihan', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);

        return response()->json([
            'status' => false,
            'message' => 'Terjadi kesalahan',
            'error' => $e->getMessage()
        ], 500);
    }
})->name('cek-tagihan');

Route::post('/generate-va', function (Request $request) {
    try {
        $baseUrl = config('services.tagihan_ws.url') ?: 'http://103.23.103.43/WEB_TAGIHAN_PROJECT/WS_TAGIHAN_AL_FAUZAN/index.php';
        $response = Http::timeout(30)
            ->withoutVerifying()
            ->withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ])
            ->post(
                $baseUrl.'?path=generate-va',
                $request->all()
            );

        \Log::info('WS generate-va response', [
            'status' => $response->status(),
            'body' => $response->body()
        ]);

        if ($response->successful()) {
            return response()->json($response->json());
        }

        return response()->json([
            'status' => false,
            'message' => 'Gagal generate VA'
        ], 500);
    } catch (\Exception $e) {
        \Log::error('Error generate-va', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);

        return response()->json([
            'status' => false,
            'message' => 'Terjadi kesalahan',
            'error' => $e->getMessage()
        ], 500);
    }
})->name('generate-va');

Route::post('/dua', [TagihanController::class, 'cek'])->name('tagihan.cek');

Route::post('/', [TagihanController::class, 'cek2'])->name('tagihan.cek2');

Route::get('/tagihan/view', [TagihanController::class, 'tagihanView'])->name('tagihan.view');

Route::post('/pembayaran/buat-va', [TagihanController::class, 'buatVA'])->name('pembayaran.buatva');
