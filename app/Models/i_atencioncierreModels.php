<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class i_atencioncierreModels extends Model{

    use HasFactory;
    protected $table = 'i_atencioncierre';
    protected $primaryKey = 'ate_idnumreg';  // Aquí defines el nombre de la clave primaria

    protected $fillable = [
        'Periodo',
        'Mes',
        'Observado_PSA',
        'Observado_SME',
        'Disa',
        'CodigoEESS',
        'Ejecutora',
        'Categoria',
        'Servicio',
        'ServicioDesc',
        'ate_codate',
        'ate_coddestino',
        'destino',
        'ValorNeto',
        'valorNetoServ',
        'valorNetoMedi',
        'valorNetoProc',
        'valorNetoInsu',
        'ValorBruto',
        'valorBrutoServ',
        'valorbrutoMedi',
        'valorbrutopro',
        'valorbrutoins',
        'ate_idlugar',
        'Capita',
        'Componente',
        'Finalidad',
        'RM',
        'ParaEstadistica',
        'TipoPago',
        'ModalidadAtencion',
        'FUA',
        'Contrato',
        'ate_idnumreg',
        'ate_tipdig',
        'ate_odsis',
        'ate_idppdd',
        'ate_odsisrecep',
        'ate_pdigrecep',
        'ate_estado',
        'ate_aus',
        'ate_disa',
        'ate_lote',
        'ate_numregate',
        'ate_autogenerado',
        'ate_edad',
        'ate_fecatencion',
        'ate_appat',
        'ate_apmat',
        'ate_pnom',
        'ate_snom',
        'ate_fecnac',
        'ate_idsexo',
        'FechaCreacion',
        'ate_esgestante',
        'ate_fecparto',
        'ate_ideessrefirio',
        'ate_nrohojareferencia',
        'ate_ideesscontrarefiere',
        'ate_numhojacontrarefiere',
        'ate_idorigenpersonal',
        'ate_tipodocpersonalsalud',
        'ate_dnipersonalsalud',
        'pes_colegiatura',
        'ate_especialidad',
        'ate_tipo_personal_salud',
        'SubPrograma_Funcional',
        'Programa_PPTAL',
        'Producto_Proyecto',
        'Activ_Obra_Accinv',
        'Nivel',
        'ate_coddiag1',
        'ate_dni',
        'region',
        'ComponenteGestion',
        'ComponenteReposicion',
        'ComponenteReposicionBruto',
        'ate_Fissal',
        'ate_FissalDiag',
        'ate_FissalValorBruto',
        'ate_fissalvalorbrutoserv',
        'ate_fissalvalorbrutomed',
        'ate_fissalvalorbrutoins',
        'ate_fissalvalorbrutoapo',
        'ate_FissalValorNeto',
        'ate_FissalValorServ',
        'ate_FissalValorNetoMed',
        'ate_FissalValorNetoIns',
        'ate_FissalValorNetoApo',
        'ate_FissalValorConsumo',
        'ate_esESSALUD',
        'ate_esESSALUD_Documento',
        'ate_esESSALUD_FecAct',
        'ate_FinalidadAjuste',
        'ate_AfiIdTablaGO',
        'ate_AfiIdNumRegGO',
        'ate_fissalConvenio',
        'ate_Finalidad2012',
        'ate_Finalidad2012_Ant',
        'SubPrograma_Funcional_Ant',
        'Programa_PPTAL_Ant',
        'Producto_Proyecto_Ant',
        'Activ_Obra_Accinv_Ant',
        'Nivel_Ant',
        'ate_estado_observacion_psa',
        'ate_ue',
        'ate_capita2013',
        'ate_capita_grep',
        'ate_idgrupo',
        'ate_idfinanciamiento',
        'ate_grupopoblacional',
        'FechaReporte_ate',
        'ate_fecinghosp',
        'ate_fecaltahosp',
        'ate_historiaclinica',
        'afiins_tabla',
        'afiins_tabla_id',
        'ASEG_C_RENIECVALIDA',
        'ASEG_D_RENIECFECACT',
        'ASEG_V_UBIGEORESID',
        'ASEG_V_IDEESSADSCRIP',
        'ASEG_V_ESGRUPOFOCSISFOH',
        'ASEG_V_NROCONTRATO',
        'ASEG_C_ESTADO',
        'ASEG_V_TIPODOCUMENTO',
        'ASEG_V_NRODOCUMENTO',
        'Complementario_TieneProcServ',
        'Complementario_CantProcServ',
        'Complementario_ValorBrutoFinal',
        'Complementario_ValorBrutoRRHH',
        'Complementario_ValorNetoFinal',
        'Complementario_ValorNetoRRHH',
        'ate_plan_sonreir',
        'ate_codinstitucion',
        'Ate_esMuestraPriorizada',
        'ATE_IDTIPCONVENIO',
        'Convenio',
        'ValorBruto_SIS',
        'ValorBrutoSer_SIS',
        'ValorBrutoMed_SIS',
        'ValorBrutoIns_SIS',
        'ValorBrutoApo_SIS',
        'ValorNeto_SIS',
        'ValorNetoSer_SIS',
        'ValorNetoMed_SIS',
        'ValorNetoIns_SIS',
        'ValorNetoApo_SIS',
        'ATE_VALORNETO_SME',
        'ATE_VALORNETOSER_SME',
        'ATE_VALORNETOINS_SME',
        'ATE_VALORNETOMED_SME',
        'ATE_VALORNETOPRO_SME',
        'ATE_FISSALVALORNETO_SME',
        'ATE_FISSALVALORNETOAPO_SME',
        'ATE_FISSALVALORNETOINS_SME',
        'ATE_FISSALVALORNETOMED_SME',
        'ATE_FISSALVALORSERV_SME',
        'ATE_SIS_NETO_SME',
        'ATE_SISPRO_NETO_SME',
        'ATE_SISSER_NETO_SME',
        'ATE_SISINS_NETO_SME',
        'ATE_SISMED_NETO_SME',
        'ATE_PLAN',
        'ATE_V_TIPOSEGURO',
        'ATE_ESNUEVOFORMATO',
        'ATE_RENIPRESS',
        'Fuente_Financiamiento',
        'ATE_IDMECANISMOPAGO',
        'Mecanismo_Pago',
        'ATE_NIVEL_VALORIZACION',
    ];

    public function consumosmed()
    {
        return $this->hasMany(i_atencioncierre_consumosmed::class, 'IDNUMREG', 'ate_idnumreg');
    }
}