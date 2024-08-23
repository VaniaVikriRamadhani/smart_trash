<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrganikLevel;
use App\Models\AnorganikLevel;

class DashboardController extends Controller
{
    /**
     * Get data for Organik diagram.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOrganikData()
    {
        // Ambil data dari tabel organik_levels
        $data = OrganikLevel::all();

        // Format data untuk Chart.js
        $chartData = [
            'labels' => $data->pluck('created_at')->map(function ($date) {
                return $date->format('d M Y'); // Label berdasarkan tanggal
            })->toArray(),
            'datasets' => [
                [
                    'label' => 'Kepenuhan Organik',
                    'data' => $data->pluck('distance1')->toArray(),
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                    'borderColor' => 'rgba(75, 192, 192, 1)',
                    'borderWidth' => 1,
                ],
            ],
        ];

        return response()->json($chartData);
    }

    /**
     * Get data for Anorganik diagram.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAnorganikData()
    {
        // Ambil data dari tabel anorganik_levels
        $data = AnorganikLevel::all();

        // Format data untuk Chart.js
        $chartData = [
            'labels' => $data->pluck('created_at')->map(function ($date) {
                return $date->format('d M Y'); // Label berdasarkan tanggal
            })->toArray(),
            'datasets' => [
                [
                    'label' => 'Kepenuhan Anorganik',
                    'data' => $data->pluck('distance2')->toArray(),
                    'backgroundColor' => 'rgba(153, 102, 255, 0.2)',
                    'borderColor' => 'rgba(153, 102, 255, 1)',
                    'borderWidth' => 1,
                ],
            ],
        ];

        return response()->json($chartData);
    }

    /**
     * Store data for OrganikLevel.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeOrganikData(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'distance1' => 'required|numeric',
        ]);

        // Simpan data ke dalam tabel organik_levels
        $organikLevel = new OrganikLevel();
        $organikLevel->distance1 = $validatedData['distance1'];
        $organikLevel->save();

        // Kembalikan respons
        return response()->json([
            'message' => 'Data organik berhasil disimpan.',
            'data' => $organikLevel
        ], 201);
    }

    /**
     * Store data for AnorganikLevel.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeAnorganikData(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'distance2' => 'required|numeric',
        ]);

        // Simpan data ke dalam tabel anorganik_levels
        $anorganikLevel = new AnorganikLevel();
        $anorganikLevel->distance2 = $validatedData['distance2'];
        $anorganikLevel->save();

        // Kembalikan respons
        return response()->json([
            'message' => 'Data anorganik berhasil disimpan.',
            'data' => $anorganikLevel
        ], 201);
    }
}
