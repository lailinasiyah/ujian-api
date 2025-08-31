<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PesertaController extends Controller
{
    // Dummy data peserta (sementara tanpa DB)
    private $pesertas = [
        1 => ['id' => 1, 'nama' => 'Andi'],
        2 => ['id' => 2, 'nama' => 'Budi'],
    ];

    // GET /api/peserta
    public function index()
    {
        return response()->json(array_values($this->pesertas));
    }

    // POST /api/peserta
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string'
        ]);

        $id = count($this->pesertas) + 1;
        $peserta = ['id' => $id, 'nama' => $request->nama];

        // kalau pakai DB -> Peserta::create()
        return response()->json($peserta, 201);
    }

    // GET /api/peserta/{id}
    public function show($id)
    {
        if (!isset($this->pesertas[$id])) {
            return response()->json(['error' => 'Peserta not found'], 404);
        }
        return response()->json($this->pesertas[$id]);
    }

    // PUT /api/peserta/{id}
    public function update(Request $request, $id)
    {
        if (!isset($this->pesertas[$id])) {
            return response()->json(['error' => 'Peserta not found'], 404);
        }
        $request->validate(['nama' => 'required|string']);
        $peserta = ['id' => (int)$id, 'nama' => $request->nama];
        return response()->json($peserta);
    }

    // DELETE /api/peserta/{id}
    public function destroy($id)
    {
        if (!isset($this->pesertas[$id])) {
            return response()->json(['error' => 'Peserta not found'], 404);
        }
        return response()->json(['message' => "Peserta $id deleted"]);
    }
}
