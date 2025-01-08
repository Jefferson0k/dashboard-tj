<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\i_atencioncierreResource;
use App\Models\i_atencioncierre_consumosapo;
use App\Models\i_atencioncierre_consumosins;
use App\Models\i_atencioncierre_consumosmed;
use App\Models\i_atencioncierre_consumosser;
use App\Models\i_atencioncierreModels;
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
                ->orWhere('ate_idnumreg', 'like', "%$search%")
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
        $data = [
            'consumosMed' => [
                'columns' => [
                    'TIPOCONSUMO', 'IDNUMREG', 'IDNUMREGATE', 'CODIGO', 'CANTIDAD', 
                    'CANTIDADAPROBADA', 'PRECIOAPLICADO', 'PRECIO_NETO', 'TIPOPRECIO', 
                    'PRECIOAPLICADO_REPOS', 'NUMREGPRA_REPOS', 'TIPOPRECIO_REPOS', 
                    'ESFISSAL', 'TIPOPRECIO_ANT', 'TIPO_PAGO', 'ESTADO_OBSERVACION',
                    'ATE_UE', 'MESPROD_CONSUMO', 'NRODIA', 'PRECIO_BRUTO', 
                    'ESTADO_OBSERVACION_SME', 'CANTIDADAPROBADA_SME', 'PRECIO_NETO_SME',
                ],
                'data' => i_atencioncierre_consumosmed::where('IDNUMREGATE', $idnumregate)->get(),
            ],
            'consumosIns' => [
                'columns' => [
                    'TIPOCONSUMO', 'IDNUMREG', 'IDNUMREGATE', 'CODIGO', 'CANTIDAD', 
                    'CANTIDADAPROBADA', 'PRECIOAPLICADO', 'PRECIO_NETO', 'TIPOPRECIO', 
                    'PRECIOAPLICADO_REPOS', 'NUMREGPRA_REPOS', 'TIPOPRECIO_REPOS', 
                    'ESFISSAL', 'TIPOPRECIO_ANT', 'TIPO_PAGO', 'ESTADO_OBSERVACION', 
                    'ATE_UE', 'MESPROD_CONSUMO', 'NRODIA', 'PRECIO_BRUTO', 
                    'ESTADO_OBSERVACION_SME', 'CANTIDADAPROBADA_SME', 'PRECIO_NETO_SME',
                ],
                'data' => i_atencioncierre_consumosins::where('IDNUMREGATE', $idnumregate)->get(),
            ],
            'consumosApo' => [
                'columns' => [
                    'TIPOCONSUMO', 'IDNUMREG', 'IDNUMREGATE', 'CODIGO_CPT', 'CODIGO_CPMS', 
                    'CANTIDAD', 'CANTIDADAPROBADA', 'PRECIOAPLICADO', 'PRECIO_NETO',
                    'TIPOPRECIO', 'PRECIOAPLICADO_REPOS', 'NUMREGPRA_REPOS', 'TIPOPRECIO_REPOS',
                    'ESFISSAL', 'TIPOPRECIO_ANT', 'TIPO_PAGO', 'ESTADO_OBSERVACION', 
                    'ATE_UE', 'MESPROD_CONSUMO', 'COMPLEMENTARIO_ESPROCSERV',
                    'COMPLEMENTARIO_TARIFARRHH', 'NRODIA', 'PRECIO_BRUTO', 
                    'ESTADO_OBSERVACION_SME', 'CANTIDADAPROBADA_SME', 'PRECIO_NETO_SME',
                ],
                'data' => i_atencioncierre_consumosapo::where('IDNUMREGATE', $idnumregate)->get(),
            ],
            'consumosSer' => [
                'columns' => [
                    'IDNUMREG', 'IDNUMREGATE', 'ASER_IDSERVICIO', 'PRECIOUNIT_SERV', 
                    'ASER_TIPO_PAGO', 'ASER_FISSAL', 'ASER_FINALIDAD', 'ASER_CAPITA', 
                    'ASER_IDFINANCIAMIENTO', 'ASER_IDTARIFA', 'ASER_IDSERVICIO_P', 
                    'ASER_FISSAL_P', 'ASER_CAPITA_P', 'ASER_VALAORSERV_P', 
                    'ASER_FISSALVALORSERV_P', 'ASER_TIPO_PAGO_P', 'ASER_IDTARIFA_P', 
                    'ASER_IDFINANCIAMIENTO_P', 'VALOR_NETO', 'MESPROD_CONSUMO',
                ],
                'data' => i_atencioncierre_consumosser::where('IDNUMREGATE', $idnumregate)->get(),
            ],
        ];

        return response()->json(['data' => $data], 200);
    }

}
