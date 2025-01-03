<?php

namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;
use App\Http\Resources\i_atencioncierreResource;
use App\Models\i_atencioncierre_consumosmed;
use App\Models\i_atencioncierreModels;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FraccionVentaController extends Controller{
    
    public function index(Request $request) {
        $periodo = $request->input('Periodo');
        $mes = $request->input('mes');
        $ejecutora = $request->input('ejecutora');
        $search = $request->input('search');

        if (is_null($periodo) || $periodo === '') {
            return response()->json(['error' => 'El campo Periodo es requerido.'], 400);
        }
        if (is_null($mes) || $mes === '') {
            return response()->json(['error' => 'El campo Mes es requerido.'], 400);
        }
        if (is_null($ejecutora) || $ejecutora === '') {
            return response()->json(['error' => 'El campo Ejecutora es requerido.'], 400);
        }

        $query = i_atencioncierreModels::query();
        $query->where('Periodo', $periodo)
            ->where('mes', $mes)
            ->where('ejecutora', $ejecutora);

        if (!is_null($search) && $search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('ate_appat', 'like', "%$search%")
                ->orWhere('ate_dnipersonalsalud', 'like', "%$search%")
                ->orWhere('ate_dni', 'like', "%$search%")
                ->orWhere('ate_apmat', 'like', "%$search%")
                ->orWhere('ate_pnom', 'like', "%$search%")
                ->orWhere('ate_snom', 'like', "%$search%")
                ->orWhere('Observado_SME', 'like', "%$search%")
                ->orWhere('CodigoEESS', 'like', "%$search%")
                ->orWhere('destino', 'like', "%$search%")
                ->orWhere('ValorNeto', 'like', "%$search%")
                ->orWhere('valorNetoServ', 'like', "%$search%")
                ->orWhere('ValorBruto', 'like', "%$search%");
            });
        }

        $fraccionventas = $query->paginate(100);

        return response()->json([
            'data' => i_atencioncierreResource::collection($fraccionventas->items()),
            'pagination' => [
                'current_page' => $fraccionventas->currentPage(),
                'last_page' => $fraccionventas->lastPage(),
                'per_page' => $fraccionventas->perPage(),
                'total' => $fraccionventas->total(),
            ],
        ]);
    }

    public function show($idnumregate){
        $registros = i_atencioncierre_consumosmed::where('IDNUMREGATE', $idnumregate)->get();
        return response()->json(['data' => $registros], 200);
    }


}
