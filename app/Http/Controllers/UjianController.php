<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UjianController extends Controller
{
    /**
     * GET /api/ujian?jenis=JLPT
     * Return default nilai sesuai jenis ujian
     */
    public function default(Request $request)
    {
        $jenis = strtoupper($request->query('jenis', ''));

        $default = [
            'JLPT' => [
                'mojigoi' => 0,
                'dokkai' => 0,
                'choukai' => 0,
                'total' => 0,
                'hasil' => ''
            ],
            'NAT' => [
                'mojigoi' => 0,
                'dokkai' => 0,
                'choukai' => 0,
                'total' => 0,
                'hasil' => ''
            ],
            'JTEST' => [
                'mojigoi' => 0,
                'dokkai' => 0,
                'choukai' => 0,
                'total' => 0,
                'hasil' => ''
            ],
        ];

        if (!isset($default[$jenis])) {
            return response()->json(['error' => 'Jenis ujian tidak valid'], 400);
        }

        return response()->json([
            'jenis' => $jenis,
            'nilai' => $default[$jenis]
        ]);
    }

    /**
     * POST /api/ujian/hitung
     * Hitung total & hasil berdasarkan input
     */
    public function hitung(Request $request)
    {
        $request->validate([
            'nama'  => 'required|string',
            'jenis' => 'required|string|in:JLPT,NAT,JTEST',
            'mojigoi' => 'required|numeric',
            'dokkai' => 'required|numeric',
            'choukai' => 'required|numeric',
        ]);

        $nama = $request->nama;
        $jenis = strtoupper($request->jenis);
        $mojigoi = (int) $request->mojigoi;
        $dokkai = (int) $request->dokkai;
        $choukai = (int) $request->choukai;
        $total = $mojigoi + $dokkai + $choukai;
        $hasil = '';

        if (in_array($jenis, ['JLPT', 'NAT'])) {
            if ($total >= 90 && $mojigoi > 19 && $dokkai > 19 && $choukai > 19) {
                $hasil = 'LULUS';
            } else {
                $hasil = 'TIDAK LULUS';
            }
        } elseif ($jenis === 'JTEST') {
            if ($total < 350) {
                $hasil = 'TIDAK LULUS';
            } elseif ($total < 500) {
                $hasil = 'STANDAR';
            } else {
                $hasil = 'ADVANCED';
            }
        }

        return response()->json([
            'nama'  => $nama,
            'jenis' => $jenis,
            'nilai' => [
                'mojigoi' => $mojigoi,
                'dokkai' => $dokkai,
                'choukai' => $choukai,
                'total' => $total,
                'hasil' => $hasil
            ]
        ]);
    }
}
