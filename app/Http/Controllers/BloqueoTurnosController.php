<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TurnosBloqueado;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class BloqueoTurnosController extends Controller
{
    /**
     * Mostrar la vista principal del panel de bloqueo
     */
    public function index()
    {
        return view('pages.bloqueo_turnos');
    }

    /**
     * Guardar nuevos bloqueos de turnos
     */
    public function guardar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fecha' => 'required|date_format:d/m/Y',
            'turnos' => 'required|array|min:1',
            'turnos.*' => 'required|string'
        ], [
            'fecha.required' => 'La fecha es obligatoria',
            'fecha.date_format' => 'La fecha debe tener el formato DD/MM/AAAA',
            'turnos.required' => 'Debe seleccionar al menos un turno',
            'turnos.min' => 'Debe seleccionar al menos un turno'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        try {
            $fecha = Carbon::createFromFormat('d/m/Y', $request->fecha)->format('Y-m-d');
            $turnos = $request->turnos;

            if (Carbon::parse($fecha)->lt(Carbon::today())) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se pueden bloquear turnos en fechas pasadas'
                ], 422);
            }

            $bloqueadosCreados = 0;
            $bloqueadosExistentes = 0;

            foreach ($turnos as $turno) {
                $resultado = TurnosBloqueado::firstOrCreate([
                    'fecha' => $fecha,
                    'turno' => $turno
                ]);

                if ($resultado->wasRecentlyCreated) {
                    $bloqueadosCreados++;
                } else {
                    $bloqueadosExistentes++;
                }
            }

            $mensaje = '';
            if ($bloqueadosCreados > 0) {
                $mensaje .= "$bloqueadosCreados turno(s) bloqueado(s). ";
            }
            if ($bloqueadosExistentes > 0) {
                $mensaje .= "$bloqueadosExistentes turno(s) ya bloqueado(s).";
            }

            return response()->json([
                'success' => true,
                'message' => trim($mensaje)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Listar todos los bloqueos futuros
     */
    public function listar()
    {
        try {
            $bloqueos = TurnosBloqueado::futuros()->get();

            $bloqueosFormateados = $bloqueos->map(function ($bloqueo) {
                return [
                    'id' => $bloqueo->id,
                    'fecha' => Carbon::parse($bloqueo->fecha)->format('d/m/Y'),
                    'fecha_legible' => Carbon::parse($bloqueo->fecha)->locale('es')->isoFormat('dddd D [de] MMMM [de] YYYY'),
                    'turno' => $bloqueo->turno
                ];
            });

            return response()->json([
                'success' => true,
                'bloqueos' => $bloqueosFormateados
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar bloqueos: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar un bloqueo específico
     */
    public function eliminar($id)
    {
        try {
            $bloqueo = TurnosBloqueado::find($id);

            if (!$bloqueo) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bloqueo no encontrado'
                ], 404);
            }

            $bloqueo->delete();

            return response()->json([
                'success' => true,
                'message' => 'Turno desbloqueado correctamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener bloqueos de una fecha específica (para el checkout)
     */
    public function obtenerPorFecha(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fecha' => 'required|date_format:d/m/Y'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'bloqueados' => []
            ]);
        }

        try {
            $fecha = Carbon::createFromFormat('d/m/Y', $request->fecha)->format('Y-m-d');

            $bloqueados = TurnosBloqueado::porFecha($fecha)->pluck('turno')->toArray();

            return response()->json([
                'success' => true,
                'bloqueados' => $bloqueados
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'bloqueados' => []
            ]);
        }
    }
    
}