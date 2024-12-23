<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <div>
            <br />
            <Card class="mr-2">
                <template #content>
                    <div class="flex flex-col gap-4">
                        <!-- Selección de Periodo -->
                        <div class="relative">
                            <label for="periodo" class="block text-sm font-medium text-gray-700 mb-1">Periodo:</label>
                            <Select id="periodo" v-model="periodo" :options="years" placeholder="Selecciona un año"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" />
                            <ProgressSpinner v-if="loading" style="width: 20px; height: 20px"
                                class="absolute right-2 top-8" />
                        </div>

                        <!-- Selección de Ejecutora -->
                        <div class="relative">
                            <label for="ejecutora" class="block text-sm font-medium text-gray-700 mb-1">Ejecutora:</label>
                            <Select id="ejecutora" v-model="ejecutora" :options="ejecutoras"
                                placeholder="Selecciona una ejecutora"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" />
                            <ProgressSpinner v-if="loading" style="width: 20px; height: 20px"
                                class="absolute right-2 top-8" />
                        </div>

                        <!-- Selección de Mes -->
                        <div class="relative">
                            <label for="mes" class="block text-sm font-medium text-gray-700 mb-1">Mes:</label>
                            <Select id="mes" v-model="mes" :options="months" optionLabel="name" optionValue="value"
                                placeholder="Selecciona un mes"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" />
                            <ProgressSpinner v-if="loading" style="width: 20px; height: 20px"
                                class="absolute right-2 top-8" />
                        </div>
                    </div>
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
                        :globalFilterFields="['Periodo', 'Observado_SME', 'CodigoEESS', 'destino', 'ValorNeto', 'valorNetoServ', 'ValorBruto', 'NuevoOjo']">
                        <template #header>
                            <div class="flex justify-between items-center p-4">
                                <h3 class="text-xl font-semibold text-gray-800">Registros</h3>
                                <div>
                                    <InputText v-model="filters.global.value" placeholder="Buscar..."
                                        class="p-inputtext-sm" />
                                </div>
                            </div>
                        </template>

                        <!-- Definición de las columnas -->
                        <Column field="Periodo" header="Periodo" sortable class="min-w-[12rem]" />
                        <Column field="Observado_SME" header="Observaciones" sortable class="min-w-[10rem]" />
                        <Column field="CodigoEESS" header="Código EESS" sortable class="min-w-[10rem]" />
                        <Column field="destino" header="Destino" sortable class="min-w-[12rem]" />
                        <Column field="ValorNeto" header="Neto" sortable class="min-w-[12rem]" />
                        <Column field="valorNetoServ" header="Servicio" sortable class="min-w-[14rem]" />
                        <Column field="ValorBruto" header="Bruto" sortable class="min-w-[8rem]" />

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
            <div v-if="loadingDetail" class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                <ProgressSpinner />
            </div>

            <DataTable v-if="!loadingDetail" :value="detalleData" class="p-datatable-striped">
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
const loadingDetail = ref(false);  // Nueva variable para controlar la carga del modal
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
const detalleData = ref([]);  // Nueva variable para almacenar los datos del detalle

const fetchData = async (page = 1) => {
    loading.value = true;
    fraccionventas.value = [];
    try {
        const response = await axios.get('/fraccionventas', {
            params: {
                Periodo: periodo.value,
                mes: mes.value,
                ejecutora: ejecutora.value,
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
    loadingDetail.value = true;  // Mostrar el spinner de carga del modal
    try {
        const response = await axios.get(`/atencion-cierre-consumosmed/${id}`);
        if (response.data && response.data.data) {
            selectedRecord.value = response.data.data;
            detalleData.value = response.data.data;  // Asignar los datos a detalleData
            dialogVisible.value = true;  // Mostrar el diálogo
        }
    } catch (err) {
        console.error('Error al obtener los detalles:', err);
    } finally {
        loadingDetail.value = false;  // Ocultar el spinner de carga del modal
    }
};

watch([periodo, mes, ejecutora], () => fetchData(1), {
    immediate: true
});
</script>
