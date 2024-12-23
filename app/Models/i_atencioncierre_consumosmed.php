<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class i_atencioncierre_consumosmed extends Model
{
    use HasFactory;

    protected $table = 'i_atencioncierre_consumosmed';

    // Especifica la llave primaria
    protected $primaryKey = 'IDNUMREGATE';

    // Si no es auto-incremental
    public $incrementing = false;

    // Si no es un entero, define el tipo (por ejemplo, 'string' si es un texto)
    protected $keyType = 'string';

    protected $fillable = [
        'TIPOCONSUMO',
        'IDNUMREG',
        'IDNUMREGATE',
        'CODIGO',
        'CANTIDAD',
        'CANTIDADAPROBADA',
        'PRECIOAPLICADO',
        'PRECIO_NETO',
        'TIPOPRECIO',
        'PRECIOAPLICADO_REPOS',
        'NUMREGPRA_REPOS',
        'TIPOPRECIO_REPOS',
        'ESFISSAL',
        'TIPOPRECIO_ANT',
        'TIPO_PAGO',
        'ESTADO_OBSERVACION',
        'ATE_UE',
        'MESPROD_CONSUMO',
        'NRODIA',
        'PRECIO_BRUTO',
        'ESTADO_OBSERVACION_SME',
        'CANTIDADAPROBADA_SME',
        'PRECIO_NETO_SME',
    ];

    public function atencioncierre()
    {
        return $this->belongsTo(i_atencioncierreModels::class, 'IDNUMREG', 'ate_idnumreg');
    }
}
