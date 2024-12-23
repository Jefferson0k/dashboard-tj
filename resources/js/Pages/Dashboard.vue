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
                                placeholder="Selecciona una ejecutora"
                                class="w-96" />
                        </template>
                        <template #end>
                            <Select id="mes" v-model="mes" :options="months" optionLabel="name" optionValue="value"
                                placeholder="Selecciona un mes"
                                class="w-96" />
                        </template>
                    </Toolbar>
                </template>
            </Card>
            <br />
            <Card class="w-full max-w-full bg-white shadow-md rounded-md">
                <template #content>
                    <!-- Mostrar el ProgressBar mientras se cargan los datos -->
                    <ProgressBar v-if="loading" mode="indeterminate" style="height: 6px;" />
                    <DataTable ref="dt" :value="fraccionventas" dataKey="id" :paginator="true" :rows="perPage"
                        :totalRecords="totalRecords" :lazy="true" @page="onPage"
                        paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                        :rowsPerPageOptions="[100, 50, 25]"
                        currentPageReportTemplate="Mostrando {first} a {last} de {totalRecords} registros"
                        class="p-datatable-striped" :scrollable="true" scrollHeight="400px" :filters="filters"
                        filterDisplay="menu"
                        :globalFilterFields="['ate_dnipersonalsalud','ate_dni','nombre_completo', 'nombres', 'Observado_SME', 'CodigoEESS', 'destino', 'ValorNeto', 'valorNetoServ', 'ValorBruto', 'NuevoOjo']">
                        <template #header>
                            <div class="flex justify-between items-center p-4">
                                <h3 class="text-xl font-semibold text-gray-800">Registros</h3>
                                <div>
                                    <InputText v-model="filters.global.value" placeholder="Buscar..." class="p-inputtext-sm" />
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
        <Dialog 
            v-model:visible="dialogVisible" 
            maximizable 
            modal 
            header="Detalle de Consumo" 
            :style="{ width: '50rem' }"
            :breakpoints="{ '1199px': '75vw', '575px': '90vw' }"
            :contentStyle="{ position: 'relative' }"
        >
            <!-- Tabla con los datos cargados -->
            <DataTable :value="detalleData" class="p-datatable-striped">
                <Column field="TIPOCONSUMO" header="Tipo Consumo" />
                <Column field="CODIGO" header="Código" />
                <Column field="CANTIDAD" header="Cantidad" />
                <Column field="PRECIO_NETO" header="Precio Neto" />
                <Column field="TIPOPRECIO" header="Tipo Precio" />
                <Column field="TIPOPRECIO_ANT" header="Precio Anterior" />
                <Column field="ESFISSAL" header="Es Fiscal" />
                <Column field="TIPO_PAGO" header="Tipo Pago" />
                <Column field="ESTADO_OBSERVACION" header="Estado Observación" />
                <Column field="ATE_UE" header="Código UE" />
                <Column field="MESPROD_CONSUMO" header="Mes Producto Consumo" />
            </DataTable>
        </Dialog>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
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
const years = Array.from({ length: 7 }, (_, i) => String(currentYear + i));
const ejecutoras = ['900', '1117', '901'];
const months = [
    { name: 'Enero', value: '01' },
    { name: 'Febrero', value: '02' },
    { name: 'Marzo', value: '03' },
    { name: 'Abril', value: '04' },
    { name: 'Mayo', value: '05' },
    { name: 'Junio', value: '06' },
    { name: 'Julio', value: '07' },
    { name: 'Agosto', value: '08' },
    { name: 'Septiembre', value: '09' },
    { name: 'Octubre', value: '10' },
    { name: 'Noviembre', value: '11' },
    { name: 'Diciembre', value: '12' }
];
const dialogVisible = ref(false);
const selectedRecord = ref(null);
const detalleData = ref([]);

const fetchData = async (page = 1) => {
    loading.value = true;
    fraccionventas.value = [];
    try {
        const search = filters.value?.global?.value || ''; // Manejo seguro de `filters.global.value`
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

watch([periodo, mes, ejecutora, () => filters.value?.global?.value], () => fetchData(1), {
    immediate: true
});

</script>
