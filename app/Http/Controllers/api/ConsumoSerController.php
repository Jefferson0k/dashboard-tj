<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\i_atencioncierre_consumosser;

class ConsumoSerController extends Controller{
    
    public function show($idnumregate){
        $registros = i_atencioncierre_consumosser::where('IDNUMREGATE', $idnumregate)->get();
        return response()->json(['data' => $registros], 200);
    }
}
