<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TagihanController extends Controller
{
    private function wsUrl(?string $path = null): string
    {
        $url = rtrim(config('services.tagihan_ws.url'), '?&');

        if ($path) {
            $url .= (str_contains($url, '?') ? '&' : '?').'path='.$path;
        }

        return $url;
    }

    public function cek(Request $request)
    {
        $request->validate([
            'no_cust' => 'required|string',
            'academic_year' => 'required|string'
        ]);

        $response = Http::timeout(30)
            ->withoutVerifying()
            ->post($this->wsUrl('cek-tagihan'), [
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

        $response = Http::timeout(30)
            ->withoutVerifying()
            ->post($this->wsUrl('cek-tagihan-pw'), [
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

        return view('index3', compact('result'))
            ->with([
                'va' => $request->no_cust,
                'academic_year' => $request->academic_year
            ]);
    }

    public function tagihanView()
    {
        return view('tagihan');
    }

    public function listTahunAkademik()
    {
        try {
            $response = Http::timeout(30)
                ->withoutVerifying()
                ->get(config('services.tagihan_ws.url'), [
                    'path' => 'list-tahun-aka'
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
            ]);

            return response()->json([
                'status' => false,
                'message' => 'Gagal mengambil data tahun akademik',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
