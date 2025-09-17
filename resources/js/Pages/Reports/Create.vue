<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import DataTable from 'datatables.net-vue3'
import DataTablesLib from 'datatables.net';
import 'datatables.net-select';

import { ref, onMounted } from 'vue';

DataTable.use(DataTablesLib);

let dtEmployments;
const tableEmployments = ref();
let selectedEmploymentOnTable = null;
 
const columnsEmployments = [
  { data: 'employee_number', title: 'No. Empleado' },
  { data: 'employee_name', title: 'Empleado' },
  { data: 'branch_name', title: 'Planta' },
  { data: 'area_name', title: 'Área' },
  { data: 'title_name', title: 'Puesto' },
];
const optionsEmployments = {
    dom: 'Bfrtip',
    select: {
        style: 'single',
        info: false,
        toggleable: false
    },
    initComplete: function(settings, json) {
    }
}


let dtEquipments;
const tableEquipments = ref();
let selectedEquipmentsOnTable = [];

const columnsEquipments = [
  { data: 'id', title: 'ID' },
  { data: 'category_name', title: 'Categoría' },
  { data: 'sku', title: 'Placa' },
  { data: 'brand_name', title: 'Marca' },
  { data: 'model_name', title: 'Modelo' },
  { data: 'serial', title: 'No. Serie' },
];
const optionsEquipments = {
    dom: 'Bfrtip',
    select: {
        style: 'multi',
        info: false,
        toggleable: true
    },
    initComplete: function(settings, json) {
    }
}


let dtPhonelines;
const tablePhonelines = ref();
let selectedPhonelinesOnTable = [];

const columnsPhonelines = [
  { data: 'number', title: 'Teléfono' },
  { data: 'company', title: 'Compañia' },
  { data: 'scope', title: 'Modalidad' },
];
const optionsPhonelines = {
    dom: 'Bfrtip',
    select: {
        style: 'single',
        info: false,
        toggleable: true
    },
    initComplete: function(settings, json) {
    }
}



onMounted(function () {
    dtEmployments = tableEmployments.value.dt();

    dtEmployments.on( 'select', function ( e, dt, type, indexes ) {
        if ( type === 'row' ) {
            selectedEmploymentOnTable = dt.rows( indexes[0] ).data();
            selectedEmploymentOnTable = selectedEmploymentOnTable[0];
        }
    });

    /*
    if( 1 ){
        dtEmployments.row(':eq(0)', { page: 'current' }).select();
        selectedEmploymentOnTable = dtEmployments.row(':eq(0)', { page: 'current' }).data();
        console.log( selectedEmploymentOnTable );
    }
    */

    dtEquipments = tableEquipments.value.dt();

    let selectedData = null;


    const updateSelectedRows = ( e, dt, type, indexes ) => {

        selectedEquipmentsOnTable = [];
        let rows = dt.rows('.selected');
        dt.rows('.selected').every(function(rowIdx, tableLoop, rowLoop){
            let data = dt.rows( rowIdx ).data();
            selectedEquipmentsOnTable.push( data[0] );
            console.log( selectedEquipmentsOnTable );
        });        

    }
 
    dtEquipments.on( 'select', function ( e, dt, type, indexes ) {
        if ( type === 'row' ) {
            updateSelectedRows( e, dt, type, indexes );
        }
    });

    dtEquipments.on( 'deselect', function ( e, dt, type, indexes ) {
        if ( type === 'row' ) {
            updateSelectedRows( e, dt, type, indexes );
        }
    });

});
 
/*
onMounted(function () {
    dt = table.value.dt();

    dt.on( 'select', function ( e, dt, type, indexes ) {
        alert( 'DataTables has finished its initialisation.' );
        if ( type === 'row' ) {
            var data = table.rows( indexes ).data().pluck( 'id' );
            // do something with the ID of the selected items
        }
    });

    dt.rows().every(function () {
        let row = this.data();
        let id = row.id;

        let features = '';
        for( const property in row.features ){
        features += `<p class="px-2 py-1 border">${property}: ${row.features[property]}</p>`;
        }

        //JSON.stringify( row.features );
        //row.features = `<a class="text-blue-500 px-2 py-1 border bg-gray-50" href="employees/${id}">VER</a> | <a class="text-amber-500 px-2 py-1 border bg-gray-50" href="employees/${id}/edit">EDITAR</a>`;
        row.features = `<div class="px-2 py-1">${features}</div>`;
    });
});
*/


</script>

<style>
@import 'datatables.net-dt';
</style>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Responsivas</h2>
        </template>

        <div class="py-12">
            <div class="max-w-2xl mx-auto px-6">
                
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                    <div class="p-6 sm:px-12 bg-white border-b border-gray-200">

                        <div class="mt-6 mb-6">
                            <div class="mb-1 text-2xl">
                                Nueva Responsiva
                            </div>
                            <div class="text-gray-500">
                                Completa los datos de la responsiva
                            </div>
                        </div>

                        <div v-show="modalEmployments" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full justify-center flex" style="background-color:#000000a0;">
                            <div class="relative w-full h-full max-w-2xl md:h-auto">
                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                    <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                            Buscar Empleado
                                        </h3>
                                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" v-on:click="(modalEmployments=false)">
                                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                    </div>
                                    <div class="p-6 space-y-6">

                                        <DataTable
                                            :columns="columnsEmployments"
                                            :data="db.employments"
                                            :options="optionsEmployments"
                                            ref="tableEmployments"
                                            class="table display w-100"
                                        />                                        
                                        <div v-if="db.employments?.length">
                                            <ul>
                                                <li v-for="(item, index) in db.employments" :key="index">
                                                    <span>{{ item.title }}</span>
                                                </li>
                                            </ul>
                                        </div>
                                        <div v-else class="text-gray-500">
                                            <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400 text-center p-4">
                                                No se encontraron resultados
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex justify-end p-6 space-x-2 border-t border-gray-200 rounded-b">
                                        <button type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600" v-on:click="(modalEmployments=false)">Cancelar</button>
                                        <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" v-on:click="selectedEmployment=selectedEmploymentOnTable, modalEmployments=false">Continuar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div v-show="modalEquipments" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full justify-center flex" style="background-color:#000000a0;">
                            <div class="relative w-full h-full max-w-2xl md:h-auto">
                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                    <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                            Buscar Equipo
                                        </h3>
                                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" v-on:click="(modalEquipments=false)">
                                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                    </div>
                                    <div class="p-6 space-y-6">

                                        <DataTable
                                            :columns="columnsEquipments"
                                            :data="db.equipments"
                                            :options="optionsEquipments"
                                            ref="tableEquipments"
                                            class="table display w-100"
                                        />
                                        <div v-if="db.employments?.length">
                                            <ul>
                                                <li v-for="(item, index) in db.employments" :key="index">
                                                    <span>{{ item.title }}</span>
                                                </li>
                                            </ul>
                                        </div>
                                        <div v-else class="text-gray-500">
                                            <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400 text-center p-4">
                                                No se encontraron resultados
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex justify-end p-6 space-x-2 border-t border-gray-200 rounded-b">
                                        <button type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600" v-on:click="(modalEquipments=false)">Cancelar</button>
                                        <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" v-on:click="selectedEquipments=selectedEquipmentsOnTable, modalEquipments=false">Continuar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div v-show="modalPhonelines" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full justify-center flex" style="background-color:#000000a0;">
                            <div class="relative w-full h-full max-w-2xl md:h-auto">
                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                    <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                            Asignar Línea Teléfonica
                                        </h3>
                                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" v-on:click="(modalPhonelines=false)">
                                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                    </div>
                                    <div class="p-6 space-y-6">
                                        <DataTable
                                            :columns="columnsPhonelines"
                                            :data="db.phonelines"
                                            :options="optionsPhonelines"
                                            ref="tablePhonelines"
                                            class="table display w-100"
                                        />                                        
                                    </div>
                                    <div class="flex justify-end p-6 space-x-2 border-t border-gray-200 rounded-b">
                                        <button type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600" v-on:click="(modalPhonelines=false)">Cancelar</button>
                                        <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" v-on:click="selectedPhoneline=selectedPhonelinesOnTable, modalPhonelines=false">Continuar</button>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <form @submit.prevent="store" autocomplete="off">

                            <div class="">

                                <div class="flex items-center">
                                    <div class="relative w-full">
                                        <h5 class="text-lg font-large font-bold">Responsable</h5>
                                    </div>
                                    <button type="button" class="inline-flex items-center py-2.5 px-3 ml-2 text-sm font-medium text-gray-600 bg-stone-100 rounded-lg border border-gray-100 hover:bg-stone-200 focus:ring-2 focus:outline-none focus:ring-stone-300" v-on:click="(modalEmployments=true)">
                                        <svg aria-hidden="true" class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>Buscar
                                    </button>
                                </div>
                                <div class="bg-white shadow-md rounded mt-2 mb-8 flex flex-col">
                                    <div class="mb-0 p-2">
                                        <div class="flex" v-if="selectedEmployment==null">
                                            <a class="mx-4 my-6 hover:border-blue-500 hover:border-solid hover:bg-white hover:text-blue-500 group w-full flex flex-col items-center justify-center rounded-md border-2 border-dashed border-slate-300 text-sm leading-6 text-slate-900 font-medium py-3 cursor-pointer" v-on:click="(modalEmployments=true)">
                                                <svg class="group-hover:text-blue-400 mb-1 text-slate-400" width="20" height="20" fill="currentColor" aria-hidden="true"><path d="M10 5a1 1 0 0 1 1 1v3h3a1 1 0 1 1 0 2h-3v3a1 1 0 1 1-2 0v-3H6a1 1 0 1 1 0-2h3V6a1 1 0 0 1 1-1Z" /></svg>
                                                Agregar Responsable
                                            </a>
                                        </div>
                                        <div v-else>
                                            <div class="flex flex-col items-center md:flex-row md:max-w-xl">
                                                
                                                <img v-if="selectedEmployment.employee_number==319" class="object-cover w-full rounded-t-lg h-32 md:h-auto md:w-24 md:rounded-none md:rounded-l-lg" src="https://www.diaadia.com.pa/sites/default/files/2019-04/cristiano-ronaldo-abdominales-.jpg" alt="...">
                                                <img v-else class="object-cover w-full rounded-t-lg h-32 md:h-auto md:w-24 md:rounded-none md:rounded-l-lg" src="https://img.icons8.com/ios/500/user--v1.png" alt="...">
                                                <div class="flex flex-col justify-between p-4 leading-normal">
                                                    <h5 class="mb-2 text-lg tracking-tight text-gray-900">
                                                        <span v-if="selectedEmployment.employee_number!=null">
                                                            {{ selectedEmployment.employee_number }} - 
                                                        </span>
                                                        {{ selectedEmployment.employee_name }}
                                                    </h5>
                                                    <p class="mb-3 font-normal text-gray-600">
                                                        {{ selectedEmployment.title_name }} en {{ selectedEmployment.branch_name }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div v-if="errors.employment" class="text-error">{{ errors.employment }}</div>

                                <div class="flex items-center mt-6">
                                    <div class="relative w-full">
                                        <h5 class="text-lg font-large font-bold">Equipos</h5>
                                    </div>
                                    <button type="button" class="inline-flex items-center py-2.5 px-3 ml-2 text-sm font-medium text-gray-600 bg-stone-100 rounded-lg border border-gray-100 hover:bg-stone-200 focus:ring-2 focus:outline-none focus:ring-stone-300" v-on:click="(modalEquipments=true)">
                                        <svg aria-hidden="true" class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>Buscar
                                    </button>
                                </div>
                                <div class="bg-white shadow-md rounded mt-2 mb-8 flex flex-col">
                                    <div class="mb-0 p-2">
                                        <div v-if="(selectedEquipments.length)" class="">
                                            <div v-for="(equipment, index) in selectedEquipments" :key="equipment.id" class="flex flex-col items-center md:flex-row md:max-w-xl">
                                                <img class="object-cover w-full rounded-t-lg h-32 md:h-auto md:w-24 md:rounded-none md:rounded-l-lg" src="https://img.freepik.com/vector-premium/simulacros-telefono-inteligente-tableta-computadora_389832-395.jpg" alt="...">
                                                <div class="flex flex-col justify-between p-4 leading-normal">
                                                    <h5 class="mb-2 text-lg tracking-tight text-gray-900">
                                                        {{ equipment.category_name }} {{ equipment.brand_name }} {{ equipment.model_name }}
                                                    </h5>
                                                    <p class="mb-3 font-normal text-gray-600">
                                                        Placa: {{ equipment.sku }}, No. serie: {{ equipment.serial }}
                                                    </p>

                                                    <div v-if="( [3].includes(equipment.category_id) )" class="">
                                                        <div class="">
                                                            <label for="status" class="required block tracking-wide text-sm font-medium text-gray-900 mb-1">Linea Teléfonica</label>
                                                            <VueMultiselect
                                                                v-model="selectedEquipments[index].phoneline"
                                                                :options="db.phonelines"
                                                                placeholder="Selecciona linea teléfonica"
                                                                label="number"
                                                                track-by="id"
                                                                :show-labels="false"
                                                            ></VueMultiselect>
                                                            <div v-if="errors.lifecycle" class="text-error">{{ errors.lifecycle }}</div>
                                                        </div>
                                                        <div v-if="errors.phoneline" class="text-error">{{ errors.phoneline }}</div>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                        <div v-else class="flex">
                                            <a class="mx-4 my-6 hover:border-blue-500 hover:border-solid hover:bg-white hover:text-blue-500 group w-full flex flex-col items-center justify-center rounded-md border-2 border-dashed border-slate-300 text-sm leading-6 text-slate-900 font-medium py-3 cursor-pointer" v-on:click="(modalEquipments=true)">
                                                <svg class="group-hover:text-blue-400 mb-1 text-slate-400" width="20" height="20" fill="currentColor" aria-hidden="true"><path d="M10 5a1 1 0 0 1 1 1v3h3a1 1 0 1 1 0 2h-3v3a1 1 0 1 1-2 0v-3H6a1 1 0 1 1 0-2h3V6a1 1 0 0 1 1-1Z" /></svg>
                                                Agregar Equipo
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div v-if="errors.equipments" class="text-error">{{ errors.equipments }}</div>

                                <div class="flex items-center mt-6">
                                    <div class="relative w-full">
                                        <h5 class="text-lg font-large font-bold">Accesorios</h5>
                                    </div>
                                </div>
                                <div class="bg-white shadow-md rounded mt-2 mb-8 flex flex-col">
                                    <VueMultiselect
                                        v-model="form.accessories"
                                        :options="db.accessories"
                                        :multiple="true"
                                        placeholder="Selecciona los accesorios adicionales"
                                        label="name"
                                        track-by="id"
                                        :show-labels="false"
                                    ></VueMultiselect>
                                    <div v-if="errors.title" class="text-error">{{ errors.title }}</div>
                                </div>

                                <!--div class="mb-6">
                                    <label for="amount" class="block tracking-wide text-sm font-medium text-gray-900 mb-1">Importe del pagaré</label>
                                    <input type="text" v-model="form.amount" id="amount" class="appearance-none block w-full bg-gray-50 text-gray-700 border border-gray-400 rounded py-2 px-3" required />
                                    <div v-if="errors.amount" class="text-error">{{ errors.amount }}</div>
                                </div-->

                                <div class="mb-6">
                                    <label for="start_at" class="block tracking-wide text-sm font-medium text-gray-900 mb-1">Fecha de entrega al usuario</label>
                                    <input type="date" v-model="form.start_at" id="start_at" class="appearance-none block w-full bg-gray-50 text-gray-700 border border-gray-400 rounded py-2 px-3" required>
                                    <div v-if="errors.start_at" class="text-error">{{ errors.start_at }}</div>
                                </div>

                                <div class="mb-6">
                                    <label for="notes" class="block tracking-wide text-sm font-medium text-gray-900 mb-1">Observaciones</label>
                                    <textarea v-model="form.notes" id="notes" class="appearance-none block w-full bg-gray-50 text-gray-700 border border-gray-400 rounded py-3 px-4"></textarea>
                                    <div v-if="errors.notes" class="text-error">{{ errors.notes }}</div>
                                </div>

                                <div class="mb-4 mt-4 text-right">
                                    <a :href="route('responsives')" class="text-gray-700 bg-gray-100 hover:bg-gray-200 focus:ring-2 focus:outline-none focus:ring-gray-400 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">Cancelar</a>
                                    <button type="submit" class="ml-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Registrar</button>
                                </div>
                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>
    </AppLayout>
</template>


<script>
import { reactive } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import VueMultiselect from 'vue-multiselect'

export default {
    components: {
        VueMultiselect
    },
    //layout: AppLayout,
    remember: 'form',

    data() {

        const form = reactive({
            employment: null,
            equipments: [],
            start_at: null,
            accessories: [],
        })

        return {
            modalEmployments: false,
            modalEquipments: false,
            modalPhonelines: false,

            selectedEmployment: null,
            selectedEquipments: [],

            form
        }
    },

    props: {
        data: Object,
        errors: Object,
        db: Object,
    },

    methods: {

        store() {
            //console.log( this.selectedEquipments );
            this.form.equipments = this.selectedEquipments;
            this.form.employment = this.selectedEmployment;

            console.log( this.form );

            Inertia.post( route('responsives.store'), this.form );
        },

    },

}


</script>

