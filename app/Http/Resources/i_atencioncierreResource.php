<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class i_atencioncierreResource extends JsonResource {

    public function toArray(Request $request): array {
        $data = parent::toArray($request);
        
        // Concatenar apellidos
        $data['nombre_completo'] = trim("{$this->ate_appat} {$this->ate_apmat}");
        
        // Concatenar nombres
        $data['nombres'] = trim("{$this->ate_pnom} {$this->ate_snom}");

        // Si algún campo es nulo o vacío, evitar dejar espacios innecesarios
        $data['nombre_completo'] = empty($data['nombre_completo']) ? 'Desconocido' : $data['nombre_completo'];
        $data['nombres'] = empty($data['nombres']) ? 'Desconocido' : $data['nombres'];

        return $data;
    }
}
