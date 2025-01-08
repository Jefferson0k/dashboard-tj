<template>
    <AuthenticatedLayout>
        <div>
            <br />
            <Card class="mr-2">
                <template #content>
                    <Toolbar>
                        <template #start>
                            <Select id="periodo" v-model="periodo" :options="years" placeholder="Selecciona un año"
                                class="w-96" />
                        </template>
                        <template #center>
                            <Select id="ejecutora" v-model="ejecutora" :options="ejecutoras"
                                placeholder="Selecciona una ejecutora" class="w-96" />
                        </template>
                        <template #end>
                            <Select id="mes" v-model="mes" :options="months" optionLabel="name" optionValue="value"
                                placeholder="Selecciona un mes" class="w-96" />
                        </template>
                    </Toolbar>
                </template>
            </Card>
            <br />
            <Card class="w-full max-w-full bg-white shadow-md rounded-md">
                <template #content>
                    <!-- Mostrar el ProgressBar mientras se cargan los datos -->
                    <ProgressBar v-if="loading" mode="indeterminate" style="height: 6px;" />
                    <DataTable 
                        ref="dt" 
                        :value="fraccionventas" 
                        dataKey="id" 
                        :paginator="true" 
                        :rows="perPage"
                        :totalRecords="totalRecords" 
                        :lazy="true" 
                        @page="onPage"
                        paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                        :rowsPerPageOptions="[100, 50, 25]"
                        currentPageReportTemplate="Mostrando {first} a {last} de {totalRecords} registros"
                        class="p-datatable-striped" 
                        :scrollable="true" 
                        scrollHeight="400px" 
                        :filters="filters"
                        filterDisplay="menu"
                        :globalFilterFields="['Observado_SME', 'CodigoEESS', 'destino', 'ValorNeto', 'valorNetoServ', 'ValorBruto', 'NuevoOjo', 'Periodo', 'Mes', 'Observado_PSA', 'Observado_SME', 'Disa', 'CodigoEESS', 'Ejecutora', 'Categoria', 'Servicio', 'ServicioDesc', 'ate_codate', 'ate_coddestino', 'destino', 'ValorNeto', 'valorNetoServ', 'valorNetoMedi', 'valorNetoProc', 'valorNetoInsu', 'ValorBruto', 'valorBrutoServ', 'valorbrutoMedi', 'valorbrutopro', 'valorbrutoins', 'ate_idlugar', 'Capita', 'Componente', 'Finalidad', 'RM', 'ParaEstadistica', 'TipoPago', 'ModalidadAtencion', 'FUA', 'Contrato', 'ate_idnumreg', 'ate_tipdig', 'ate_odsis', 'ate_idppdd', 'ate_odsisrecep', 'ate_pdigrecep', 'ate_estado', 'ate_aus', 'ate_disa', 'ate_lote', 'ate_numregate', 'ate_autogenerado', 'ate_edad', 'ate_fecatencion', 'ate_appat', 'ate_apmat', 'ate_pnom', 'ate_snom', 'ate_fecnac', 'ate_idsexo', 'FechaCreacion', 'ate_esgestante', 'ate_fecparto', 'ate_ideessrefirio', 'ate_nrohojareferencia', 'ate_ideesscontrarefiere', 'ate_numhojacontrarefiere', 'ate_idorigenpersonal', 'ate_tipodocpersonalsalud', 'ate_dnipersonalsalud', 'pes_colegiatura', 'ate_especialidad', 'ate_tipo_personal_salud', 'SubPrograma_Funcional', 'Programa_PPTAL', 'Producto_Proyecto', 'Activ_Obra_Accinv', 'Nivel', 'ate_coddiag1', 'ate_dni', 'region', 'ComponenteGestion', 'ComponenteReposicion', 'ComponenteReposicionBruto', 'ate_Fissal', 'ate_FissalDiag', 'ate_FissalValorBruto', 'ate_fissalvalorbrutoserv', 'ate_fissalvalorbrutomed', 'ate_fissalvalorbrutoins', 'ate_fissalvalorbrutoapo', 'ate_FissalValorNeto', 'ate_FissalValorServ', 'ate_FissalValorNetoMed', 'ate_FissalValorNetoIns', 'ate_FissalValorNetoApo', 'ate_FissalValorConsumo', 'ate_esESSALUD', 'ate_esESSALUD_Documento', 'ate_esESSALUD_FecAct', 'ate_FinalidadAjuste', 'ate_AfiIdTablaGO', 'ate_AfiIdNumRegGO', 'ate_fissalConvenio', 'ate_Finalidad2012', 'ate_Finalidad2012_Ant', 'SubPrograma_Funcional_Ant', 'Programa_PPTAL_Ant', 'Producto_Proyecto_Ant', 'Activ_Obra_Accinv_Ant', 'Nivel_Ant', 'ate_estado_observacion_psa', 'ate_ue', 'ate_capita2013', 'ate_capita_grep', 'ate_idgrupo', 'ate_idfinanciamiento', 'ate_grupopoblacional', 'FechaReporte_ate', 'ate_fecinghosp', 'ate_fecaltahosp', 'ate_historiaclinica', 'afiins_tabla', 'afiins_tabla_id', 'ASEG_C_RENIECVALIDA', 'ASEG_D_RENIECFECACT', 'ASEG_V_UBIGEORESID', 'ASEG_V_IDEESSADSCRIP', 'ASEG_V_ESGRUPOFOCSISFOH', 'ASEG_V_NROCONTRATO', 'ASEG_C_ESTADO', 'ASEG_V_TIPODOCUMENTO', 'ASEG_V_NRODOCUMENTO', 'Complementario_TieneProcServ', 'Complementario_CantProcServ', 'Complementario_ValorBrutoFinal', 'Complementario_ValorBrutoRRHH', 'Complementario_ValorNetoFinal', 'Complementario_ValorNetoRRHH', 'ate_plan_sonreir', 'ate_codinstitucion', 'Ate_esMuestraPriorizada', 'ATE_IDTIPCONVENIO', 'Convenio', 'ValorBruto_SIS', 'ValorBrutoSer_SIS', 'ValorBrutoMed_SIS', 'ValorBrutoIns_SIS', 'ValorBrutoApo_SIS', 'ValorNeto_SIS', 'ValorNetoSer_SIS', 'ValorNetoMed_SIS', 'ValorNetoIns_SIS', 'ValorNetoApo_SIS', 'ATE_VALORNETO_SME', 'ATE_VALORNETOSER_SME', 'ATE_VALORNETOINS_SME', 'ATE_VALORNETOMED_SME', 'ATE_VALORNETOPRO_SME', 'ATE_FISSALVALORNETO_SME', 'ATE_FISSALVALORNETOAPO_SME', 'ATE_FISSALVALORNETOINS_SME', 'ATE_FISSALVALORNETOMED_SME', 'ATE_FISSALVALORSERV_SME', 'ATE_SIS_NETO_SME', 'ATE_SISPRO_NETO_SME', 'ATE_SISSER_NETO_SME', 'ATE_SISINS_NETO_SME', 'ATE_SISMED_NETO_SME', 'ATE_PLAN', 'ATE_V_TIPOSEGURO', 'ATE_ESNUEVOFORMATO', 'ATE_RENIPRESS', 'Fuente_Financiamiento', 'ATE_IDMECANISMOPAGO', 'Mecanismo_Pago', 'ATE_NIVEL_VALORIZACION']">
                        <template #header>
                            <div class="flex justify-between items-center p-4">
                                <h3 class="text-xl font-semibold text-gray-800">i_atencioncierre</h3>
                                <div>
                                    <InputText v-model="filters.global.value" placeholder="Buscar..."
                                        class="p-inputtext-sm" />
                                </div>
                            </div>
                        </template>
                        <!-- Definición de las columnas -->
                        <Column field="Periodo" header="Periodo" sortable style="min-width: 2rem" />
                        <Column field="Mes" header="Mes" sortable style="min-width: 2rem" />
                        <column field="Observado_PSA" header="Observado_PSA" style="min-width: 2rem" />
                        <Column field="Observado_SME" header="Observado_SME" style="min-width: 2rem" />
                        <Column field="Disa" header="Disa" sortable style="min-width: 2rem" />
                        <Column field="CodigoEESS" header="CodigoEESS" sortable style="min-width: 2rem" />
                        <Column field="Ejecutora" header="Ejecutora" sortable style="min-width: 2rem" />
                        <Column field="Categoria" header="Categoria" sortable style="min-width: 2rem" />
                        <Column field="Servicio" header="Servicio" sortable style="min-width: 2rem" />
                        <Column field="ServicioDesc" header="ServicioDesc" sortable style="min-width: 2rem" />
                        <Column field="ate_codate" header="ate_codate" sortable style="min-width: 2rem" />
                        <Column field="ate_coddestino" header="ate_coddestino" sortable style="min-width: 2rem" />
                        <column field="destino" header="destino" sortable style="min-width: 2rem" />
                        <Column field="ValorNeto" header="ValorNeto" sortable style="min-width: 2rem" />
                        <Column fiel="valorNetoServ" header="valorNetoServ" sortable style="min-width: 2rem" />
                        <Column field="valorNetoMedi" header="valorNetoMedi" sortable style="min-width: 2rem" />
                        <Column field="valorNetoProc" header="valorNetoProc" sortable style="min-width: 2rem" />
                        <Column field="valorNetoInsu" header="valorNetoInsu" sortable style="min-width: 2rem" />
                        <Column field="ValorBruto" header="ValorBruto" sortable style="min-width: 2rem" />
                        <Column field="valorBrutoServ" header="valorBrutoServ" sortable style="min-width: 2rem" />
                        <Column field="valorbrutoMedi" header="valorbrutoMedi" sortable style="min-width: 2rem" />
                        <Column field="valorbrutopro" header="valorbrutopro" sortable style="min-width: 2rem" />
                        <Column field="valorbrutoins" header="valorbrutoins" sortable style="min-width: 2rem" />
                        <Column field="ate_idlugar" header="ate_idlugar" sortable style="min-width: 2rem" />
                        <Column field="Capita" header="Capita" sortable style="min-width: 2rem" />
                        <Column field="Componente" header="Componente" sortable style="min-width: 2rem" />
                        <Column field="Finalidad" header="Finalidad" sortable style="min-width: 2rem" />
                        <Column field="RM" header="RM" sortable style="min-width: 2rem" />
                        <Column field="ParaEstadistica" header="ParaEstadistica" sortable style="min-width: 2rem" />
                        <Column field="TipoPago" header="TipoPago" sortable style="min-width: 2rem" />
                        <Column field="ModalidadAtencion" header="ModalidadAtencion" sortable style="min-width: 2rem" />
                        <Column field="FUA" header="FUA" sortable style="min-width: 2rem" />
                        <Column field="Contrato" header="Contrato" sortable style="min-width: 2rem" />
                        <Column field="ate_idnumreg" header="ate_idnumreg" sortable style="min-width: 2rem" />
                        <Column field="ate_tipdig" header="ate_tipdig" sortable style="min-width: 2rem" />
                        <Column field="ate_odsis" header="ate_odsis" sortable style="min-width: 2rem" />
                        <Column field="ate_idppdd" header="ate_idppdd" sortable style="min-width: 2rem" />
                        <Column field="ate_odsisrecep" header="ate_odsisrecep" sortable style="min-width: 2rem" />
                        <Column field="ate_pdigrecep" header="ate_pdigrecep" sortable style="min-width: 2rem" />
                        <Column field="ate_estado" header="ate_estado" sortable style="min-width: 2rem" />
                        <Column field="ate_aus" header="ate_aus" sortable style="min-width: 2rem" />
                        <Column field="ate_disa" header="ate_disa" sortable style="min-width: 2rem" />
                        <Column field="ate_lote" header="ate_lote" sortable style="min-width: 2rem" />
                        <Column field="ate_numregate" header="ate_numregate" sortable style="min-width: 2rem" />
                        <Column field="ate_autogenerado" header="ate_autogenerado" sortable style="min-width: 2rem" />
                        <Column field="ate_edad" header="ate_edad" sortable style="min-width: 2rem" />
                        <Column field="ate_fecatencion" header="ate_fecatencion" sortable style="min-width: 2rem" />
                        <Column field="ate_appat" header="ate_appat" sortable style="min-width: 2rem" />
                        <Column field="ate_apmat" header="ate_apmat" sortable style="min-width: 2rem" />
                        <Column field="ate_pnom" header="ate_pnom" sortable style="min-width: 2rem" />
                        <Column field="ate_snom" header="ate_snom" sortable style="min-width: 2rem" />
                        <Column field="ate_fecnac" header="ate_fecnac" sortable style="min-width: 2rem" />
                        <Column field="ate_idsexo" header="ate_idsexo" sortable style="min-width: 2rem" />
                        <Column field="FechaCreacion" header="FechaCreacion" sortable style="min-width: 2rem" />
                        <Column field="ate_esgestante" header="ate_esgestante" sortable style="min-width: 2rem" />
                        <Column field="ate_fecparto" header="ate_fecparto" sortable style="min-width: 2rem" />
                        <Column field="ate_ideessrefirio" header="ate_ideessrefirio" sortable style="min-width: 2rem" />
                        <Column field="ate_nrohojareferencia" header="ate_nrohojareferencia" sortable style="min-width: 2rem" />
                        <Column field="ate_ideesscontrarefiere" header="ate_ideesscontrarefiere" sortable style="min-width: 2rem" />
                        <Column field="ate_numhojacontrarefiere" header="ate_numhojacontrarefiere" sortable style="min-width: 2rem" />
                        <Column field="ate_idorigenpersonal" header="ate_idorigenpersonal" sortable style="min-width: 2rem" />
                        <Column field="ate_tipodocpersonalsalud" header="ate_tipodocpersonalsalud" sortable style="min-width: 2rem" />
                        <Column field="pes_colegiatura" header="pes_colegiatura" sortable style="min-width: 2rem" />
                        <Column field="ate_especialidad" header="ate_especialidad" sortable style="min-width: 2rem" />
                        <Column field="ate_tipo_personal_salud" header="ate_tipo_personal_salud" sortable style="min-width: 2rem" />
                        <Column field="SubPrograma_Funcional" header="SubPrograma_Funcional" sortable style="min-width: 2rem" />
                        <Column field="Programa_PPTAL" header="Programa_PPTAL" sortable style="min-width: 2rem" />
                        <Column field="Producto_Proyecto" header="Producto_Proyecto" sortable style="min-width: 2rem" />
                        <Column field="Activ_Obra_Accinv" header="Activ_Obra_Accinv" sortable style="min-width: 2rem" />
                        <Column field="Nivel" header="Nivel" sortable style="min-width: 2rem" />
                        <Column field="ate_coddiag1" header="ate_coddiag1" sortable style="min-width: 2rem" />
                        <Column field="ate_dni" header="ate_dni" sortable style="min-width: 2rem" />
                        <Column field="region" header="region" sortable style="min-width: 2rem" />
                        <Column field="ComponenteGestion" header="ComponenteGestion" sortable style="min-width: 2rem" />
                        <Column field="ComponenteReposicion" header="ComponenteReposicion" sortable style="min-width: 2rem" />
                        <Column field="ComponenteReposicionBruto" header="ComponenteReposicionBruto" sortable style="min-width: 2rem" />
                        <Column field="ate_Fissal" header="ate_Fissal" sortable style="min-width: 2rem" />
                        <Column field="ate_FissalDiag" header="ate_FissalDiag" sortable style="min-width: 2rem" />
                        <Column field="ate_FissalValorBruto" header="ate_FissalValorBruto" sortable style="min-width: 2rem" />
                        <Column field="ate_fissalvalorbrutoserv" header="ate_fissalvalorbrutoserv" sortable style="min-width: 2rem" />
                        <Column field="ate_fissalvalorbrutomed" header="ate_fissalvalorbrutomed" sortable style="min-width: 2rem" />
                        <Column field="ate_fissalvalorbrutoins" header="ate_fissalvalorbrutoins" sortable style="min-width: 2rem" />
                        <Column field="ate_fissalvalorbrutoapo" header="ate_fissalvalorbrutoapo" sortable style="min-width: 2rem" />
                        <Column field="ate_FissalValorNeto" header="ate_FissalValorNeto" sortable style="min-width: 2rem" />
                        <Column field="ate_FissalValorServ" header="ate_FissalValorServ" sortable style="min-width: 2rem" />
                        <Column field="ate_FissalValorNetoMed" header="ate_FissalValorNetoMed" sortable style="min-width: 2rem" />
                        <Column field="ate_FissalValorNetoIns" header="ate_FissalValorNetoIns" sortable style="min-width: 2rem" />
                        <Column field="ate_FissalValorNetoApo" header="ate_FissalValorNetoApo" sortable style="min-width: 2rem" />
                        <Column field="ate_FissalValorConsumo" header="ate_FissalValorConsumo" sortable style="min-width: 2rem" />
                        <Column field="ate_esESSALUD" header="ate_esESSALUD" sortable style="min-width: 2rem" />
                        <Column field="ate_esESSALUD_Documento" header="ate_esESSALUD_Documento" sortable style="min-width: 2rem" />
                        <Column field="ate_esESSALUD_FecAct" header="ate_esESSALUD_FecAct" sortable style="min-width: 2rem" />
                        <Column field="ate_FinalidadAjuste" header="ate_FinalidadAjuste" sortable style="min-width: 2rem" />
                        <Column field="ate_AfiIdTablaGO" header="ate_AfiIdTablaGO" sortable style="min-width: 2rem" />
                        <Column field="ate_AfiIdNumRegGO" header="ate_AfiIdNumRegGO" sortable style="min-width: 2rem" />
                        <Column field="ate_fissalConvenio" header="ate_fissalConvenio" sortable style="min-width: 2rem" />
                        <Column field="ate_Finalidad2012" header="ate_Finalidad2012" sortable style="min-width: 2rem" />
                        <Column field="ate_Finalidad2012_Ant" header="ate_Finalidad2012_Ant" sortable style="min-width: 2rem" />
                        <Column field="SubPrograma_Funcional_Ant" header="SubPrograma_Funcional_Ant" sortable style="min-width: 2rem" />
                        <Column field="Programa_PPTAL_Ant" header="Programa_PPTAL_Ant" sortable style="min-width: 2rem" />
                        <Column field="Producto_Proyecto_Ant" header="Producto_Proyecto_Ant" sortable style="min-width: 2rem" />
                        <Column field="Activ_Obra_Accinv_Ant" header="Activ_Obra_Accinv_Ant" sortable style="min-width: 2rem" />
                        <Column field="Nivel_Ant" header="Nivel_Ant" sortable style="min-width: 2rem" />
                        <Column field="ate_estado_observacion_psa" header="ate_estado_observacion_psa" sortable style="min-width: 2rem" />
                        <Column field="ate_ue" header="ate_ue" sortable style="min-width: 2rem" />
                        <Column field="ate_capita2013" header="ate_capita2013" sortable style="min-width: 2rem" />
                        <Column field="ate_capita_grep" header="ate_capita_grep" sortable style="min-width: 2rem" />
                        <Column field="ate_idgrupo" header="ate_idgrupo" sortable style="min-width: 2rem" />
                        <Column field="ate_idfinanciamiento" header="ate_idfinanciamiento" sortable style="min-width: 2rem" />
                        <Column field="ate_grupopoblacional" header="ate_grupopoblacional" sortable style="min-width: 2rem" />
                        <Column field="FechaReporte_ate" header="FechaReporte_ate" sortable style="min-width: 2rem" />
                        <Column field="ate_fecinghosp" header="ate_fecinghosp" sortable style="min-width: 2rem" />
                        <Column field="ate_fecaltahosp" header="ate_fecaltahosp" sortable style="min-width: 2rem" />
                        <Column field="ate_historiaclinica" header="ate_historiaclinica" sortable style="min-width: 2rem" />
                        <Column field="afiins_tabla" header="afiins_tabla" sortable style="min-width: 2rem" />
                        <Column field="afiins_tabla_id" header="afiins_tabla_id" sortable style="min-width: 2rem" />
                        <Column field="ASEG_C_RENIECVALIDA" header="ASEG_C_RENIECVALIDA" sortable style="min-width: 2rem" />
                        <Column field="ASEG_D_RENIECFECACT" header="ASEG_D_RENIECFECACT" sortable style="min-width: 2rem" />
                        <Column field="ASEG_V_UBIGEORESID" header="ASEG_V_UBIGEORESID" sortable style="min-width: 2rem" />
                        <Column field="ASEG_V_IDEESSADSCRIP" header="ASEG_V_IDEESSADSCRIP" sortable style="min-width: 2rem" />
                        <Column field="ASEG_V_ESGRUPOFOCSISFOH" header="ASEG_V_ESGRUPOFOCSISFOH" sortable style="min-width: 2rem" />
                        <Column field="ASEG_V_NROCONTRATO" header="ASEG_V_NROCONTRATO" sortable style="min-width: 2rem" />
                        <Column field="ASEG_C_ESTADO" header="ASEG_C_ESTADO" sortable style="min-width: 2rem" />
                        <Column field="ASEG_V_TIPODOCUMENTO" header="ASEG_V_TIPODOCUMENTO" sortable style="min-width: 2rem" />
                        <Column field="ASEG_V_NRODOCUMENTO" header="ASEG_V_NRODOCUMENTO" sortable style="min-width: 2rem" />
                        <Column field="Complementario_TieneProcServ" header="Complementario_TieneProcServ" sortable style="min-width: 2rem" />
                        <Column field="Complementario_CantProcServ" header="Complementario_CantProcServ" sortable style="min-width: 2rem" />
                        <Column field="Complementario_ValorBrutoFinal" header="Complementario_ValorBrutoFinal" sortable style="min-width: 2rem" />
                        <Column field="Complementario_ValorBrutoRRHH" header="Complementario_ValorBrutoRRHH" sortable style="min-width: 2rem" />
                        <Column field="Complementario_ValorNetoFinal" header="Complementario_ValorNetoFinal" sortable style="min-width: 2rem" />
                        <Column field="Complementario_ValorNetoRRHH" header="Complementario_ValorNetoRRHH" sortable style="min-width: 2rem" />
                        <Column field="ate_plan_sonreir" header="ate_plan_sonreir" sortable style="min-width: 2rem" />
                        <Column field="ate_codinstitucion" header="ate_codinstitucion" sortable style="min-width: 2rem" />
                        <Column field="Ate_esMuestraPriorizada" header="Ate_esMuestraPriorizada" sortable style="min-width: 2rem" />
                        <Column field="ATE_IDTIPCONVENIO" header="ATE_IDTIPCONVENIO" sortable style="min-width: 2rem" />
                        <Column field="Convenio" header="Convenio" sortable style="min-width: 2rem" />
                        <Column field="ValorBruto_SIS" header="ValorBruto_SIS" sortable style="min-width: 2rem" />
                        <Column field="ValorBrutoSer_SIS" header="ValorBrutoSer_SIS" sortable style="min-width: 2rem" />
                        <Column field="ValorBrutoMed_SIS" header="ValorBrutoMed_SIS" sortable style="min-width: 2rem" />
                        <Column field="ValorBrutoIns_SIS" header="ValorBrutoIns_SIS" sortable style="min-width: 2rem" />
                        <Column field="ValorBrutoApo_SIS" header="ValorBrutoApo_SIS" sortable style="min-width: 2rem" />
                        <Column field="ValorNeto_SIS" header="ValorNeto_SIS" sortable style="min-width: 2rem" />
                        <Column field="ValorNetoSer_SIS" header="ValorNetoSer_SIS" sortable style="min-width: 2rem" />
                        <Column field="ValorNetoMed_SIS" header="ValorNetoMed_SIS" sortable style="min-width: 2rem" />
                        <Column field="ValorNetoIns_SIS" header="ValorNetoIns_SIS" sortable style="min-width: 2rem" />
                        <Column field="ValorNetoApo_SIS" header="ValorNetoApo_SIS" sortable style="min-width: 2rem" />
                        <Column field="ATE_VALORNETO_SME" header="ATE_VALORNETO_SME" sortable style="min-width: 2rem" />
                        <Column field="ATE_VALORNETOSER_SME" header="ATE_VALORNETOSER_SME" sortable style="min-width: 2rem" />
                        <Column field="ATE_VALORNETOINS_SME" header="ATE_VALORNETOINS_SME" sortable style="min-width: 2rem" />
                        <Column field="ATE_VALORNETOMED_SME" header="ATE_VALORNETOMED_SME" sortable style="min-width: 2rem" />
                        <Column field="ATE_VALORNETOPRO_SME" header="ATE_VALORNETOPRO_SME" sortable style="min-width: 2rem" />
                        <Column field="ATE_FISSALVALORNETO_SME" header="ATE_FISSALVALORNETO_SME" sortable style="min-width: 2rem" />
                        <Column field="ATE_FISSALVALORNETOAPO_SME" header="ATE_FISSALVALORNETOAPO_SME" sortable style="min-width: 2rem" />
                        <Column field="ATE_FISSALVALORNETOINS_SME" header="ATE_FISSALVALORNETOINS_SME" sortable style="min-width: 2rem" />
                        <Column field="ATE_FISSALVALORNETOMED_SME" header="ATE_FISSALVALORNETOMED_SME" sortable style="min-width: 2rem" />
                        <Column field="ATE_FISSALVALORSERV_SME" header="ATE_FISSALVALORSERV_SME" sortable style="min-width: 2rem" />
                        <Column field="ATE_SIS_NETO_SME" header="ATE_SIS_NETO_SME" sortable style="min-width: 2rem" />
                        <Column field="ATE_SISPRO_NETO_SME" header="ATE_SISPRO_NETO_SME" sortable style="min-width: 2rem" />
                        <Column field="ATE_SISSER_NETO_SME" header="ATE_SISSER_NETO_SME" sortable style="min-width: 2rem" />
                        <Column field="ATE_SISINS_NETO_SME" header="ATE_SISINS_NETO_SME" sortable style="min-width: 2rem" />
                        <Column field="ATE_SISMED_NETO_SME" header="ATE_SISMED_NETO_SME" sortable style="min-width: 2rem" />
                        <Column field="ATE_PLAN" header="ATE_PLAN" sortable style="min-width: 2rem" />
                        <Column field="ATE_V_TIPOSEGURO" header="ATE_V_TIPOSEGURO" sortable style="min-width: 2rem" />
                        <Column field="ATE_ESNUEVOFORMATO" header="ATE_ESNUEVOFORMATO" sortable style="min-width: 2rem" />
                        <Column field="ATE_RENIPRESS" header="ATE_RENIPRESS" sortable style="min-width: 2rem" />
                        <Column field="Fuente_Financiamiento" header="Fuente_Financiamiento" sortable style="min-width: 2rem" />
                        <Column field="ATE_IDMECANISMOPAGO" header="ATE_IDMECANISMOPAGO" sortable style="min-width: 2rem" />
                        <Column field="Mecanismo_Pago" header="Mecanismo_Pago" sortable style="min-width: 2rem" />
                        <Column field="ATE_NIVEL_VALORIZACION" header="ATE_NIVEL_VALORIZACION" sortable style="min-width: 2rem" />

                        <!-- Nueva columna con ícono para ver detalle -->
                        <Column class="min-w-[1rem]">
                            <template #body="slotProps">
                                <i class="pi pi-eye text-blue-500 cursor-pointer"
                                    :title="'med ' + slotProps.data.Periodo"
                                    @click="verDetalle(slotProps.data.ate_idnumreg)"></i>
                            </template>
                        </Column>
                    </DataTable>
                </template>
            </Card>
        </div>
        
        <div v-if="loadingDetail" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
            <ProgressSpinner />
        </div>
        <Dialog
            v-model:visible="dialogVisible"
            maximizable
            modal
            header="Detalle de Registros"
            :style="{ width: '80vw' }"
            :breakpoints="{ '1199px': '75vw', '575px': '90vw' }"
            :contentStyle="{ position: 'relative' }"
        >
            <div v-for="(section, key) in detalleData" :key="key" class="mb-5">
            <!-- Encabezado -->
            <h3 :class="headerClass(key)" class="text-lg font-bold mb-2">
                {{ getHeaderText(key) }}
            </h3>
            <!-- Tabla -->
            <DataTable
                v-if="section.data.length"
                :value="section.data"
                dataKey="IDNUMREG"
                :paginator="true"
                :rows="5"
                paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                :rowsPerPageOptions="[5, 10, 25]"
                currentPageReportTemplate="Mostrando {first} a {last} de {totalRecords} registros"
            >
                <Column
                v-for="column in section.columns"
                :key="column"
                :field="column"
                :header="column"
                />
            </DataTable>
            <p v-else class="text-gray-500 italic">No hay datos disponibles para esta sección.</p>
            </div>
        </Dialog>

    </AuthenticatedLayout>
</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import {
        ref,
        watch
    } from 'vue';
    import axios from 'axios';
    import DataTable from 'primevue/datatable';
    import Column from 'primevue/column';
    import Select from 'primevue/select';
    import InputText from 'primevue/inputtext';
    import Card from 'primevue/card';
    import ProgressBar from 'primevue/progressbar';
    import Dialog from 'primevue/dialog';
    import 'primeicons/primeicons.css';
    import ProgressSpinner from 'primevue/progressspinner';
    import Toolbar from 'primevue/toolbar';
    const periodo = ref(null);
    const mes = ref(null);
    const ejecutora = ref(null);
    const fraccionventas = ref([]);
    const filters = ref({
        global: {
            value: null
        }
    });
    const loading = ref(false);
    const loadingDetail = ref(false);
    const totalRecords = ref(0);
    const currentPage = ref(1);
    const perPage = ref(100);
    const startYear = 2024;
    const years = Array.from({ length: 7 }, (_, i) => String(startYear + i));

    console.log(years);
    const ejecutoras = ['900', '1117', '901'];
    const months = [{
            name: 'Enero',
            value: '01'
        },
        {
            name: 'Febrero',
            value: '02'
        },
        {
            name: 'Marzo',
            value: '03'
        },
        {
            name: 'Abril',
            value: '04'
        },
        {
            name: 'Mayo',
            value: '05'
        },
        {
            name: 'Junio',
            value: '06'
        },
        {
            name: 'Julio',
            value: '07'
        },
        {
            name: 'Agosto',
            value: '08'
        },
        {
            name: 'Septiembre',
            value: '09'
        },
        {
            name: 'Octubre',
            value: '10'
        },
        {
            name: 'Noviembre',
            value: '11'
        },
        {
            name: 'Diciembre',
            value: '12'
        }
    ];

    const dialogVisible = ref(false);
    const detalleData = ref([]);

    const fetchData = async (page = 1) => {
        loading.value = true;
        fraccionventas.value = [];
        try {
            const search = filters.value ?.global ?.value || ''; // Manejo seguro de `filters.global.value`
            const response = await axios.get('/fraccionventas', {
                params: {
                    Periodo: periodo.value,
                    mes: mes.value,
                    ejecutora: ejecutora.value,
                    search: search, // Parámetro de búsqueda
                    page: page
                }
            });
            if (response.data && response.data.data) {
                fraccionventas.value = response.data.data;
                totalRecords.value = response.data.pagination.total;
                currentPage.value = response.data.pagination.current_page;
                perPage.value = response.data.pagination.per_page;
            }
        } catch (err) {
            console.error('Error al obtener los datos:', err);
            fraccionventas.value = [];
        } finally {
            loading.value = false;
        }
    };
    const onPage = (event) => {
        currentPage.value = event.page + 1;
        perPage.value = event.rows;
        fetchData(currentPage.value);
    };
    
    // Función para obtener los datos
    const verDetalle = async (id) => {
        loadingDetail.value = true;
        dialogVisible.value = false;
        try {
            const response = await axios.get(`/atencion-cierre-consumosmed/${id}`);
            console.log('Data recibida:', response.data.data);
            detalleData.value = response.data.data || {};
        } catch (err) {
            console.error('Error al obtener los detalles:', err);
            detalleData.value = {};
        } finally {
            loadingDetail.value = false;
            dialogVisible.value = true;
        }
    };

    // Función para obtener el encabezado según la clave
    const getHeaderText = (key) => {
        const headers = {
            consumosMed: 'Consumos Medicamentos',
            consumosApo: 'Consumos Apoyo',
            consumosIns: 'Consumos Insumos',
            consumosSer: 'Consumos Servicios',
        };
        return headers[key] || 'Sección Desconocida';
    };

    // Función para asignar clases a los encabezados
    const headerClass = (key) => {
        const classes = {
            consumosMed: 'text-green-600',
            consumosApo: 'text-blue-600',
            consumosIns: 'text-yellow-600',
            consumosSer: 'text-red-600',
        };
        return classes[key] || 'text-gray-600';
    };

    watch([periodo, mes, ejecutora, () => filters.value ?.global ?.value], () => fetchData(1), {
        immediate: true
    });
</script>