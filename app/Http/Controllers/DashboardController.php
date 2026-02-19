<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Fabricante;
use App\Models\Informe;
use App\Models\Intervencion;
use App\Models\Sistema;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'clientes' => Cliente::count(),
            'sistemas' => Sistema::count(),
            'intervenciones' => Intervencion::count(),
            'informes' => Informe::count(),
            'intervenciones_en_curso' => Intervencion::where('estado', 'en_curso')->count(),
            'informes_pendientes' => Informe::where('estado', 'borrador')->count(),
        ];

        $recientes = Intervencion::with(['cliente', 'sistemas'])
            ->latest()
            ->take(5)
            ->get()
            ->map(fn ($i) => [
                'id' => $i->id,
                'referencia' => $i->referencia,
                'titulo' => $i->titulo,
                'cliente' => $i->cliente->nombre,
                'tipo' => $i->tipo,
                'estado' => $i->estado,
                'fecha_inicio' => $i->fecha_inicio?->format('d/m/Y'),
                'sistemas_count' => $i->sistemas->count(),
            ]);

        $porEstado = [
            ['name' => 'Borrador', 'value' => Intervencion::where('estado', 'borrador')->count(), 'color' => '#94a3b8'],
            ['name' => 'En curso', 'value' => Intervencion::where('estado', 'en_curso')->count(), 'color' => '#3b82f6'],
            ['name' => 'Completada', 'value' => Intervencion::where('estado', 'completada')->count(), 'color' => '#22c55e'],
            ['name' => 'Facturada', 'value' => Intervencion::where('estado', 'facturada')->count(), 'color' => '#a855f7'],
        ];

        $fabricantes = Fabricante::withCount('sistemas')
            ->where('activo', true)
            ->orderByDesc('sistemas_count')
            ->take(5)
            ->get()
            ->map(fn ($f) => [
                'nombre' => $f->nombre,
                'sistemas' => $f->sistemas_count,
            ]);

        return Inertia::render('Dashboard', [
            'stats' => $stats,
            'recientes' => $recientes,
            'porEstado' => $porEstado,
            'fabricantes' => $fabricantes,
        ]);
    }
}
