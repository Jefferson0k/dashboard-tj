<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class i_atencioncierre_consumosser extends Model{

    use HasFactory;
    protected $table = 'i_atencioncierre_consumosser';
    protected $primaryKey = 'IDNUMREG';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'IDNUMREG',
        'IDNUMREGATE',
        'ASER_IDSERVICIO',
        'PRECIOUNIT_SERV',
        'ASER_TIPO_PAGO',
        'ASER_FISSAL',
        'ASER_FINALIDAD',
        'ASER_CAPITA',
        'ASER_IDFINANCIAMIENTO',
        'ASER_IDTARIFA',
        'ASER_IDSERVICIO_P',
        'ASER_FISSAL_P',
        'ASER_CAPITA_P',
        'ASER_VALAORSERV_P',
        'ASER_FISSALVALORSERV_P',
        'ASER_TIPO_PAGO_P',
        'ASER_IDTARIFA_P',
        'ASER_IDFINANCIAMIENTO_P',
        'VALOR_NETO',
        'MESPROD_CONSUMO',
    ];

    public function atencioncierre()
    {
        return $this->belongsTo(i_atencioncierreModels::class, 'IDNUMREGATE', 'ate_idnumreg');
    }
}
