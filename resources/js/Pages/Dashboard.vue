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
                        :globalFilterFields="['ate_dnipersonalsalud','ate_dni','nombre_completo', 'nombres', 'Observado_SME', 'CodigoEESS', 'destino', 'ValorNeto', 'valorNetoServ', 'ValorBruto', 'NuevoOjo', 'Periodo', 'Mes', 'Observado_PSA', 'Observado_SME', 'Disa', 'CodigoEESS', 'Ejecutora', 'Categoria', 'Servicio', 'ServicioDesc', 'ate_codate', 'ate_coddestino', 'destino', 'ValorNeto', 'valorNetoServ', 'valorNetoMedi', 'valorNetoProc', 'valorNetoInsu', 'ValorBruto', 'valorBrutoServ', 'valorbrutoMedi', 'valorbrutopro', 'valorbrutoins', 'ate_idlugar', 'Capita', 'Componente', 'Finalidad', 'RM', 'ParaEstadistica', 'TipoPago', 'ModalidadAtencion', 'FUA', 'Contrato', 'ate_idnumreg', 'ate_tipdig', 'ate_odsis', 'ate_idppdd', 'ate_odsisrecep', 'ate_pdigrecep', 'ate_estado', 'ate_aus', 'ate_disa', 'ate_lote', 'ate_numregate', 'ate_autogenerado', 'ate_edad', 'ate_fecatencion', 'ate_appat', 'ate_apmat', 'ate_pnom', 'ate_snom', 'ate_fecnac', 'ate_idsexo', 'FechaCreacion', 'ate_esgestante', 'ate_fecparto', 'ate_ideessrefirio', 'ate_nrohojareferencia', 'ate_ideesscontrarefiere', 'ate_numhojacontrarefiere', 'ate_idorigenpersonal', 'ate_tipodocpersonalsalud', 'ate_dnipersonalsalud', 'pes_colegiatura', 'ate_especialidad', 'ate_tipo_personal_salud', 'SubPrograma_Funcional', 'Programa_PPTAL', 'Producto_Proyecto', 'Activ_Obra_Accinv', 'Nivel', 'ate_coddiag1', 'ate_dni', 'region', 'ComponenteGestion', 'ComponenteReposicion', 'ComponenteReposicionBruto', 'ate_Fissal', 'ate_FissalDiag', 'ate_FissalValorBruto', 'ate_fissalvalorbrutoserv', 'ate_fissalvalorbrutomed', 'ate_fissalvalorbrutoins', 'ate_fissalvalorbrutoapo', 'ate_FissalValorNeto', 'ate_FissalValorServ', 'ate_FissalValorNetoMed', 'ate_FissalValorNetoIns', 'ate_FissalValorNetoApo', 'ate_FissalValorConsumo', 'ate_esESSALUD', 'ate_esESSALUD_Documento', 'ate_esESSALUD_FecAct', 'ate_FinalidadAjuste', 'ate_AfiIdTablaGO', 'ate_AfiIdNumRegGO', 'ate_fissalConvenio', 'ate_Finalidad2012', 'ate_Finalidad2012_Ant', 'SubPrograma_Funcional_Ant', 'Programa_PPTAL_Ant', 'Producto_Proyecto_Ant', 'Activ_Obra_Accinv_Ant', 'Nivel_Ant', 'ate_estado_observacion_psa', 'ate_ue', 'ate_capita2013', 'ate_capita_grep', 'ate_idgrupo', 'ate_idfinanciamiento', 'ate_grupopoblacional', 'FechaReporte_ate', 'ate_fecinghosp', 'ate_fecaltahosp', 'ate_historiaclinica', 'afiins_tabla', 'afiins_tabla_id', 'ASEG_C_RENIECVALIDA', 'ASEG_D_RENIECFECACT', 'ASEG_V_UBIGEORESID', 'ASEG_V_IDEESSADSCRIP', 'ASEG_V_ESGRUPOFOCSISFOH', 'ASEG_V_NROCONTRATO', 'ASEG_C_ESTADO', 'ASEG_V_TIPODOCUMENTO', 'ASEG_V_NRODOCUMENTO', 'Complementario_TieneProcServ', 'Complementario_CantProcServ', 'Complementario_ValorBrutoFinal', 'Complementario_ValorBrutoRRHH', 'Complementario_ValorNetoFinal', 'Complementario_ValorNetoRRHH', 'ate_plan_sonreir', 'ate_codinstitucion', 'Ate_esMuestraPriorizada', 'ATE_IDTIPCONVENIO', 'Convenio', 'ValorBruto_SIS', 'ValorBrutoSer_SIS', 'ValorBrutoMed_SIS', 'ValorBrutoIns_SIS', 'ValorBrutoApo_SIS', 'ValorNeto_SIS', 'ValorNetoSer_SIS', 'ValorNetoMed_SIS', 'ValorNetoIns_SIS', 'ValorNetoApo_SIS', 'ATE_VALORNETO_SME', 'ATE_VALORNETOSER_SME', 'ATE_VALORNETOINS_SME', 'ATE_VALORNETOMED_SME', 'ATE_VALORNETOPRO_SME', 'ATE_FISSALVALORNETO_SME', 'ATE_FISSALVALORNETOAPO_SME', 'ATE_FISSALVALORNETOINS_SME', 'ATE_FISSALVALORNETOMED_SME', 'ATE_FISSALVALORSERV_SME', 'ATE_SIS_NETO_SME', 'ATE_SISPRO_NETO_SME', 'ATE_SISSER_NETO_SME', 'ATE_SISINS_NETO_SME', 'ATE_SISMED_NETO_SME', 'ATE_PLAN', 'ATE_V_TIPOSEGURO', 'ATE_ESNUEVOFORMATO', 'ATE_RENIPRESS', 'Fuente_Financiamiento', 'ATE_IDMECANISMOPAGO', 'Mecanismo_Pago', 'ATE_NIVEL_VALORIZACION']">
                        <template #header>
                            <div class="flex justify-between items-center p-4">
                                <h3 class="text-xl font-semibold text-gray-800"></h3>
                                <div>
                                    <InputText v-model="filters.global.value" placeholder="Buscar..."
                                        class="p-inputtext-sm" />
                                </div>
                            </div>
                        </template>
                        <!-- Definición de las columnas -->
                        <Column field="ate_dnipersonalsalud" header="Personal" sortable style="min-width: 2rem" />
                        <Column field="ate_dni" header="Paciente" sortable style="min-width: 2rem" />
                        <Column field="nombre_completo" header="Apellidos" sortable class="min-w-[12rem]" />
                        <Column field="nombres" header="Nombres" sortable class="min-w-[12rem]" />
                        <Column field="Observado_SME" header="Observaciones" style="min-width: 2rem" />
                        <Column field="CodigoEESS" header="C. EESS" sortable style="min-width: 2rem" />
                        <Column field="destino" header="Destino" sortable style="min-width: 2rem" />
                        <Column field="ValorNeto" header="Neto" sortable style="min-width: 2rem" />
                        <Column field="valorNetoServ" header="Servicio" sortable style="min-width: 2rem" />
                        <Column field="ValorBruto" header="Bruto" sortable style="min-width: 2rem" />
                        <Column field="Periodo" header="Periodo" sortable style="min-width: 2rem" />
                        <Column field="Mes" header="Mes" sortable style="min-width: 2rem" />
                        <Column field="Observado_PSA" header="Observado PSA" sortable style="min-width: 2rem" />
                        <Column field="Disa" header="Disa" sortable style="min-width: 2rem" />
                        <Column field="Ejecutora" header="Ejecutora" sortable style="min-width: 2rem" />
                        <Column field="Categoria" header="Categoria" sortable style="min-width: 2rem" />
                        <Column field="Servicio" header="Servicio" sortable style="min-width: 2rem" />
                        <Column field="ServicioDesc" header="Descripción Servicio" sortable style="min-width: 2rem" />
                        <Column field="ate_codate" header="Código ATE" sortable style="min-width: 2rem" />
                        <Column field="ate_coddestino" header="Código Destino" sortable style="min-width: 2rem" />
                        <Column field="valorNetoMedi" header="Neto Medicamentos" sortable style="min-width: 2rem" />
                        <Column field="valorNetoProc" header="Neto Procedimientos" sortable style="min-width: 2rem" />
                        <Column field="valorNetoInsu" header="Neto Insumos" sortable style="min-width: 2rem" />
                        <Column field="valorBrutoServ" header="Bruto Servicios" sortable style="min-width: 2rem" />
                        <Column field="valorbrutoMedi" header="Bruto Medicamentos" sortable style="min-width: 2rem" />
                        <Column field="valorbrutopro" header="Bruto Procedimientos" sortable style="min-width: 2rem" />
                        <Column field="valorbrutoins" header="Bruto Insumos" sortable style="min-width: 2rem" />
                        <Column field="ate_idlugar" header="ID Lugar" sortable style="min-width: 2rem" />
                        <Column field="Capita" header="Capita" sortable style="min-width: 2rem" />
                        <Column field="Componente" header="Componente" sortable style="min-width: 2rem" />
                        <Column field="Finalidad" header="Finalidad" sortable style="min-width: 2rem" />
                        <Column field="RM" header="RM" sortable style="min-width: 2rem" />
                        <Column field="ParaEstadistica" header="Para Estadística" sortable style="min-width: 2rem" />
                        <Column field="TipoPago" header="Tipo Pago" sortable style="min-width: 2rem" />
                        <Column field="ModalidadAtencion" header="Modalidad Atención" sortable style="min-width: 2rem" />
                        <Column field="FUA" header="FUA" sortable style="min-width: 2rem" />
                        <Column field="Contrato" header="Contrato" sortable style="min-width: 2rem" />
                        <Column field="ate_idnumreg" header="ID Registro" sortable style="min-width: 2rem" />
                        <Column field="ate_tipdig" header="Tipo Dig" sortable style="min-width: 2rem" />
                        <Column field="ate_odsis" header="ODSIS" sortable style="min-width: 2rem" />
                        <Column field="ate_idppdd" header="ID PPDD" sortable style="min-width: 2rem" />
                        <Column field="ate_odsisrecep" header="ODSIS Recep" sortable style="min-width: 2rem" />
                        <Column field="ate_pdigrecep" header="P Dig Recep" sortable style="min-width: 2rem" />
                        <Column field="ate_estado" header="Estado" sortable style="min-width: 2rem" />
                        <Column field="ate_aus" header="AUS" sortable style="min-width: 2rem" />
                        <Column field="ate_disa" header="ATE Disa" sortable style="min-width: 2rem" />
                        <Column field="ate_lote" header="Lote" sortable style="min-width: 2rem" />
                        <Column field="ate_numregate" header="Num Reg ATE" sortable style="min-width: 2rem" />
                        <Column field="ate_autogenerado" header="Autogenerado" sortable style="min-width: 2rem" />
                        <Column field="ate_edad" header="Edad" sortable style="min-width: 2rem" />
                        <Column field="ate_fecatencion" header="Fecha Atención" sortable style="min-width: 2rem" />
                        <Column field="ate_appat" header="Apellido Paterno" sortable style="min-width: 2rem" />
                        <Column field="ate_apmat" header="Apellido Materno" sortable style="min-width: 2rem" />
                        <Column field="ate_pnom" header="Primer Nombre" sortable style="min-width: 2rem" />
                        <Column field="ate_snom" header="Segundo Nombre" sortable style="min-width: 2rem" />
                        <Column field="ate_fecnac" header="Fecha Nacimiento" sortable style="min-width: 2rem" />
                        <Column field="ate_idsexo" header="Sexo" sortable style="min-width: 2rem" />
                        <Column field="FechaCreacion" header="Fecha Creación" sortable style="min-width: 2rem" />
                        <Column field="ate_esgestante" header="Es Gestante" sortable style="min-width: 2rem" />
                        <Column field="ate_fecparto" header="Fecha Parto" sortable style="min-width: 2rem" />
                        <Column field="ate_ideessrefirio" header="ID EESS Refirió" sortable style="min-width: 2rem" />
                        <Column field="ate_nrohojareferencia" header="Nro Hoja Referencia" sortable style="min-width: 2rem" />
                        <Column field="ate_ideesscontrarefiere" header="ID EESS Contrarefiere" sortable style="min-width: 2rem" />
                        <Column field="ate_numhojacontrarefiere" header="Nro Hoja Contrarefiere" sortable style="min-width: 2rem" />
                        <Column field="ate_idorigenpersonal" header="ID Origen Personal" sortable style="min-width: 2rem" />
                        <Column field="ate_tipodocpersonalsalud" header="Tipo Doc Personal" sortable style="min-width: 2rem" />
                        <Column field="pes_colegiatura" header="Colegiatura" sortable style="min-width: 2rem" />
                        <Column field="ate_especialidad" header="Especialidad" sortable style="min-width: 2rem" />
                        <Column field="ate_tipo_personal_salud" header="Tipo Personal Salud" sortable style="min-width: 2rem" />
                        <Column field="SubPrograma_Funcional" header="SubPrograma Funcional" sortable style="min-width: 2rem" />
                        <Column field="Programa_PPTAL" header="Programa PPTAL" sortable style="min-width: 2rem" />
                        <Column field="Producto_Proyecto" header="Producto Proyecto" sortable style="min-width: 2rem" />
                        <Column field="Activ_Obra_Accinv" header="Activ Obra Accinv" sortable style="min-width: 2rem" />
                        <Column field="Nivel" header="Nivel" sortable style="min-width: 2rem" />
                        <Column field="ate_coddiag1" header="Código Diagnóstico" sortable style="min-width: 2rem" />
                        <Column field="region" header="Región" sortable style="min-width: 2rem" />
                        <Column field="ComponenteGestion" header="Componente Gestión" sortable style="min-width: 2rem" />
                        <Column field="ComponenteReposicion" header="Componente Reposición" sortable style="min-width: 2rem" />
                        <Column field="ComponenteReposicionBruto" header="Componente Reposición Bruto" sortable style="min-width: 2rem" />
                        <Column field="ate_Fissal" header="Fissal" sortable style="min-width: 2rem" />
                        <Column field="ate_FissalDiag" header="Fissal Diagnóstico" sortable style="min-width: 2rem" />
                        <Column field="ate_FissalValorBruto" header="Fissal Valor Bruto" sortable style="min-width: 2rem" />
                        <Column field="ate_fissalvalorbrutoserv" header="Fissal Valor Bruto Serv" sortable style="min-width: 2rem" />
                        <Column field="ate_fissalvalorbrutomed" header="Fissal Valor Bruto Med" sortable style="min-width: 2rem" />
                        <Column field="ate_fissalvalorbrutoins" header="Fissal Valor Bruto Ins" sortable style="min-width: 2rem" />
                        <Column field="ate_fissalvalorbrutoapo" header="Fissal Valor Bruto Apo" sortable style="min-width: 2rem" />
                        <Column field="ate_FissalValorNeto" header="Fissal Valor Neto" sortable style="min-width: 2rem" />
                        <Column field="ate_FissalValorServ" header="Fissal Valor Serv" sortable style="min-width: 2rem" />
                        <Column field="ate_FissalValorNetoMed" header="Fissal Valor Neto Med" sortable style="min-width: 2rem" />
                        <Column field="ate_FissalValorNetoIns" header="Fissal Valor Neto Ins" sortable style="min-width: 2rem" />
                        <Column field="ate_FissalValorNetoApo" header="Fissal Valor Neto Apo" sortable style="min-width: 2rem" />
                        <Column field="ate_FissalValorConsumo" header="Fissal Valor Consumo" sortable style="min-width: 2rem" />
                        <Column field="ate_esESSALUD" header="Es ESSALUD" sortable style="min-width: 2rem" />
                        <Column field="ate_esESSALUD_Documento" header="ESSALUD Documento" sortable style="min-width: 2rem" />
                        <Column field="ate_esESSALUD_FecAct" header="ESSALUD Fecha Act" sortable style="min-width: 2rem" />
                        <Column field="ate_FinalidadAjuste" header="Finalidad Ajuste" sortable style="min-width: 2rem" />
                        <Column field="ate_AfiIdTablaGO" header="Afi Id Tabla GO" sortable style="min-width: 2rem" />
                        <Column field="ate_AfiIdNumRegGO" header="Afi Id Num Reg GO" sortable style="min-width: 2rem" />
                        <Column field="ate_fissalConvenio" header="Fissal Convenio" sortable style="min-width: 2rem" />
                        <Column field="ate_Finalidad2012" header="Finalidad 2012" sortable style="min-width: 2rem" />
                        <Column field="ate_Finalidad2012_Ant" header="Finalidad 2012 Ant" sortable style="min-width: 2rem" />
                        <Column field="SubPrograma_Funcional_Ant" header="SubPrograma Funcional Ant" sortable style="min-width: 2rem" />
                        <Column field="Programa_PPTAL_Ant" header="Programa PPTAL Ant" sortable style="min-width: 2rem" />
                        <Column field="Producto_Proyecto_Ant" header="Producto Proyecto Ant" sortable style="min-width: 2rem" />
                        <Column field="Activ_Obra_Accinv_Ant" header="Activ Obra Accinv Ant" sortable style="min-width: 2rem" />
                        <Column field="Nivel_Ant" header="Nivel Ant" sortable style="min-width: 2rem" />
                        <Column field="ate_estado_observacion_psa" header="Estado Observación PSA" sortable style="min-width: 2rem" />
                        <Column field="ate_ue" header="UE" sortable style="min-width: 2rem" />
                        <Column field="ate_capita2013" header="Capita 2013" sortable style="min-width: 2rem" />
                        <Column field="ate_capita_grep" header="Capita GREP" sortable style="min-width: 2rem" />
                        <Column field="ate_idgrupo" header="ID Grupo" sortable style="min-width: 2rem" />
                        <Column field="ate_idfinanciamiento" header="ID Financiamiento" sortable style="min-width: 2rem" />
                        <Column field="ate_grupopoblacional" header="Grupo Poblacional" sortable style="min-width: 2rem" />
                        <Column field="FechaReporte_ate" header="Fecha Reporte" sortable style="min-width: 2rem" />
                        <Column field="ate_fecinghosp" header="Fecha Ingreso Hosp" sortable style="min-width: 2rem" />
                        <Column field="ate_fecaltahosp" header="Fecha Alta Hosp" sortable style="min-width: 2rem" />
                        <Column field="ate_historiaclinica" header="Historia Clínica" sortable style="min-width: 2rem" />
                        <Column field="afiins_tabla" header="Afiins Tabla" sortable style="min-width: 2rem" />
                        <Column field="afiins_tabla_id" header="Afiins Tabla ID" sortable style="min-width: 2rem" />
                        <Column field="ASEG_C_RENIECVALIDA" header="RENIEC Válida" sortable style="min-width: 2rem" />
                        <Column field="ASEG_D_RENIECFECACT" header="RENIEC Fecha Act" sortable style="min-width: 2rem" />
                        <Column field="ASEG_V_UBIGEORESID" header="Ubig" sortable style="min-width: 2rem" />
                        <Column field="ASEG_V_IDEESSADSCRIP" header="EESS Adscrip." sortable style="min-width: 2rem" />
                        <Column field="ASEG_V_ESGRUPOFOCSISFOH" header="Grupo FOCSISFOH" sortable style="min-width: 2rem" />
                        <Column field="ASEG_V_NROCONTRATO" header="Nro Contrato" sortable style="min-width: 2rem" />
                        <Column field="ASEG_C_ESTADO" header="Estado" sortable style="min-width: 2rem" />
                        <Column field="ASEG_V_TIPODOCUMENTO" header="Tipo Doc." sortable style="min-width: 2rem" />
                        <Column field="ASEG_V_NRODOCUMENTO" header="Nro Doc." sortable style="min-width: 2rem" />
                        <Column field="Complementario_TieneProcServ" header="Tiene Proc. Serv." sortable style="min-width: 2rem" />
                        <Column field="Complementario_CantProcServ" header="Cant. Proc. Serv." sortable style="min-width: 2rem" />
                        <Column field="Complementario_ValorBrutoFinal" header="Valor Bruto Final" sortable style="min-width: 2rem" />
                        <Column field="Complementario_ValorBrutoRRHH" header="Valor Bruto RRHH" sortable style="min-width: 2rem" />
                        <Column field="Complementario_ValorNetoFinal" header="Valor Neto Final" sortable style="min-width: 2rem" />
                        <Column field="Complementario_ValorNetoRRHH" header="Valor Neto RRHH" sortable style="min-width: 2rem" />
                        <Column field="ate_plan_sonreir" header="Plan Sonreír" sortable style="min-width: 2rem" />
                        <Column field="ate_codinstitucion" header="Cod. Institución" sortable style="min-width: 2rem" />
                        <Column field="Ate_esMuestraPriorizada" header="Muestra Priorizada" sortable style="min-width: 2rem" />
                        <Column field="ATE_IDTIPCONVENIO" header="ID Tipo Convenio" sortable style="min-width: 2rem" />
                        <Column field="Convenio" header="Convenio" sortable style="min-width: 2rem" />
                        <Column field="ValorBruto_SIS" header="Valor Bruto SIS" sortable style="min-width: 2rem" />
                        <Column field="ValorBrutoSer_SIS" header="Valor Bruto Ser. SIS" sortable style="min-width: 2rem" />
                        <Column field="ValorBrutoMed_SIS" header="Valor Bruto Med. SIS" sortable style="min-width: 2rem" />
                        <Column field="ValorBrutoIns_SIS" header="Valor Bruto Ins. SIS" sortable style="min-width: 2rem" />
                        <Column field="ValorBrutoApo_SIS" header="Valor Bruto Apo. SIS" sortable style="min-width: 2rem" />
                        <Column field="ValorNeto_SIS" header="Valor Neto SIS" sortable style="min-width: 2rem" />
                        <Column field="ValorNetoSer_SIS" header="Valor Neto Ser. SIS" sortable style="min-width: 2rem" />
                        <Column field="ValorNetoMed_SIS" header="Valor Neto Med. SIS" sortable style="min-width: 2rem" />
                        <Column field="ValorNetoIns_SIS" header="Valor Neto Ins. SIS" sortable style="min-width: 2rem" />
                        <Column field="ValorNetoApo_SIS" header="Valor Neto Apo. SIS" sortable style="min-width: 2rem" />
                        <Column field="ATE_VALORNETO_SME" header="Valor Neto SME" sortable style="min-width: 2rem" />
                        <Column field="ATE_VALORNETOSER_SME" header="Valor Neto Ser. SME" sortable style="min-width: 2rem" />
                        <Column field="ATE_VALORNETOINS_SME" header="Valor Neto Ins. SME" sortable style="min-width: 2rem" />
                        <Column field="ATE_VALORNETOMED_SME" header="Valor Neto Med. SME" sortable style="min-width: 2rem" />
                        <Column field="ATE_VALORNETOPRO_SME" header="Valor Neto Pro. SME" sortable style="min-width: 2rem" />
                        <Column field="ATE_FISSALVALORNETO_SME" header="FISSAL Valor Neto SME" sortable style="min-width: 2rem" />
                        <Column field="ATE_FISSALVALORNETOAPO_SME" header="FISSAL Valor Neto Apo. SME" sortable style="min-width: 2rem" />
                        <Column field="ATE_FISSALVALORNETOINS_SME" header="FISSAL Valor Neto Ins. SME" sortable style="min-width: 2rem" />
                        <Column field="ATE_FISSALVALORNETOMED_SME" header="FISSAL Valor Neto Med. SME" sortable style="min-width: 2rem" />
                        <Column field="ATE_FISSALVALORSERV_SME" header="FISSAL Valor Ser. SME" sortable style="min-width: 2rem" />
                        <Column field="ATE_SIS_NETO_SME" header="SIS Neto SME" sortable style="min-width: 2rem" />
                        <Column field="ATE_SISPRO_NETO_SME" header="SIS Pro. Neto SME" sortable style="min-width: 2rem" />
                        <Column field="ATE_SISSER_NETO_SME" header="SIS Ser. Neto SME" sortable style="min-width: 2rem" />
                        <Column field="ATE_SISINS_NETO_SME" header="SIS Ins. Neto SME" sortable style="min-width: 2rem" />
                        <Column field="ATE_SISMED_NETO_SME" header="SIS Med. Neto SME" sortable style="min-width: 2rem" />
                        <Column field="ATE_PLAN" header="Plan" sortable style="min-width: 2rem" />
                        <Column field="ATE_V_TIPOSEGURO" header="Tipo Seguro" sortable style="min-width: 2rem" />
                        <Column field="ATE_ESNUEVOFORMATO" header="Es Nuevo Formato" sortable style="min-width: 2rem" />
                        <Column field="ATE_RENIPRESS" header="RENIPRESS" sortable style="min-width: 2rem" />
                        <Column field="Fuente_Financiamiento" header="Fuente Financiamiento" sortable style="min-width: 2rem" />
                        <Column field="ATE_IDMECANISMOPAGO" header="ID Mecanismo Pago" sortable style="min-width: 2rem" />
                        <Column field="Mecanismo_Pago" header="Mecanismo Pago" sortable style="min-width: 2rem" />
                        <Column field="ATE_NIVEL_VALORIZACION" header="Nivel Valorización" sortable style="min-width: 2rem" />

                        <!-- Nueva columna con ícono para ver detalle -->
                        <Column class="min-w-[1rem]">
                            <template #body="slotProps">
                                <i class="pi pi-eye text-blue-500 cursor-pointer"
                                    :title="'Detalle para ' + slotProps.data.Periodo"
                                    @click="verDetalle(slotProps.data.ate_idnumreg)"></i>
                            </template>
                        </Column>
                    </DataTable>
                </template>
            </Card>
        </div>
        <!-- Spinner global -->
        <div v-if="loadingDetail" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
            <ProgressSpinner />
        </div>
        <!-- Diálogo para mostrar los detalles del registro -->
        <Dialog v-model:visible="dialogVisible" maximizable modal header="Detalle"
            :style="{ width: '50rem' }" :breakpoints="{ '1199px': '75vw', '575px': '90vw' }"
            :contentStyle="{ position: 'relative' }">
            <DataTable ref="dt" v-model:selection="selectedProducts" :value="detalleData" dataKey="id" :paginator="true"
                :rows="5" :filters="filters"
                paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                :rowsPerPageOptions="[5, 10, 25]"
                currentPageReportTemplate="Mostrando {first} a {last} de {totalRecords} Detalle">
                <template #header>
                </template>
                <!-- Tabla con los datos cargados -->
                <Column field="TIPOCONSUMO" header="Tipo Consumo" />
                <Column field="IDNUMREG" header="ID Número Registro" />
                <Column field="IDNUMREGATE" header="ID Número Registro Ate" />
                <Column field="CODIGO" header="Código" />
                <Column field="CANTIDAD" header="Cantidad" />
                <Column field="CANTIDADAPROBADA" header="Cantidad Aprobada" />
                <Column field="PRECIOAPLICADO" header="Precio Aplicado" />
                <Column field="PRECIO_NETO" header="Precio Neto" />
                <Column field="TIPOPRECIO" header="Tipo Precio" />
                <Column field="PRECIOAPLICADO_REPOS" header="Precio Aplicado Reposición" />
                <Column field="NUMREGPRA_REPOS" header="Número Registro PRA Reposición" />
                <Column field="TIPOPRECIO_REPOS" header="Tipo Precio Reposición" />
                <Column field="ESFISSAL" header="Es Fiscal" />
                <Column field="TIPOPRECIO_ANT" header="Precio Anterior" />
                <Column field="TIPO_PAGO" header="Tipo Pago" />
                <Column field="ESTADO_OBSERVACION" header="Estado Observación" />
                <Column field="ATE_UE" header="Código UE" />
                <Column field="MESPROD_CONSUMO" header="Mes Producto Consumo" />
                <Column field="NRODIA" header="Número Día" />
                <Column field="PRECIO_BRUTO" header="Precio Bruto" />
                <Column field="ESTADO_OBSERVACION_SME" header="Estado Observación SME" />
                <Column field="CANTIDADAPROBADA_SME" header="Cantidad Aprobada SME" />
                <Column field="PRECIO_NETO_SME" header="Precio Neto SME" />
            </DataTable>
        </Dialog>

    </AuthenticatedLayout>
</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import {
        Head
    } from '@inertiajs/vue3';
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
    const selectedRow = ref(null)
    const loading = ref(false);
    const loadingDetail = ref(false);
    const totalRecords = ref(0);
    const currentPage = ref(1);
    const perPage = ref(100);
    const currentYear = new Date().getFullYear();
    const years = Array.from({
        length: 7
    }, (_, i) => String(currentYear + i));
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
    const selectedRecord = ref(null);
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
    const verDetalle = async (id) => {
        loadingDetail.value = true;
        dialogVisible.value = false;
        try {
            const response = await axios.get(`/atencion-cierre-consumosmed/${id}`);
            if (response.data && response.data.data) {
                detalleData.value = response.data.data;
            }
        } catch (err) {
            console.error('Error al obtener los detalles:', err);
            detalleData.value = [];
        } finally {
            loadingDetail.value = false;
            dialogVisible.value = true;
        }
    };
    watch([periodo, mes, ejecutora, () => filters.value ?.global ?.value], () => fetchData(1), {
        immediate: true
    });
</script>