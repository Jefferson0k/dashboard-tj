<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class i_atencioncierre_consumosapo extends Model
{
    use HasFactory;
    protected $table = 'i_atencioncierre_consumosins';
    protected $primaryKey = 'IDNUMREG';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'TIPOCONSUMO',
        'IDNUMREG',
        'IDNUMREGATE',
        'CODIGO_CPT',
        'CODIGO_CPMS',
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
        'COMPLEMENTARIO_ESPROCSERV',
        'COMPLEMENTARIO_TARIFARRHH',
        'NRODIA',
        'PRECIO_BRUTO',
        'ESTADO_OBSERVACION_SME',
        'CANTIDADAPROBADA_SME',
        'PRECIO_NETO_SME',
    ];

    public function atencioncierre()
    {
        return $this->belongsTo(i_atencioncierreModels::class, 'IDNUMREGATE', 'ate_idnumreg');
    }

}
