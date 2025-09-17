<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import DialogModal from '@/Components/DialogModal.vue';
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <Breadcrumbs :data="breadcrumbs" />
        </template>
        <div class="py-12 max-w-2xl mx-auto px-6">
            <div class="bg-white shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-12 bg-white border-b border-gray-200">
                    
                    <div class="mt-6 mb-6">
                        <div class="mb-1 text-2xl">
                            Editar Linea
                        </div>
                        <div class="text-gray-500">
                          {{ data.number }}
                        </div>
                    </div>

                    <div v-if="data.current_equipment_responsive==null">
                      <form @submit.prevent="update" autocomplete="off">

                        <div class="">

                            <div class="flex flex-col">
                                <div class="-mx-3 md:flex mb-6">
                                    <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                        <label for="number" class="block tracking-wide text-sm font-medium text-gray-900 mb-1">Número Teléfonico</label>
                                        <input type="text" v-model="form.number" id="number" class="appearance-none block w-full bg-gray-50 text-gray-700 border border-gray-400 rounded py-2 px-3">
                                        <div v-if="errors.number" class="text-error">{{ errors.number }}</div>
                                    </div>
                                    <div class="md:w-1/2 px-3">
                                        <label for="iccid" class="block tracking-wide text-sm font-medium text-gray-900 mb-1">ICCID</label>
                                        <input type="text" v-model="form.iccid" id="iccid" class="appearance-none block w-full bg-gray-50 text-gray-700 border border-gray-400 rounded py-2 px-3">
                                        <div v-if="errors.iccid" class="text-error">{{ errors.iccid }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col">
                                <div class="-mx-3 md:flex mb-6">
                                    <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                        <label class="required block tracking-wide text-sm font-medium text-gray-900 mb-1">Compañia</label>
                                        <VueMultiselect
                                            v-model="form.company"
                                            :options="db.companies"
                                            placeholder="Selecciona una compañia "
                                        ></VueMultiselect>
                                        <div v-if="errors.company" class="text-error">{{ errors.company }}</div>
                                    </div>
                                    <div class="md:w-1/2 px-3">
                                        <label class="required block tracking-wide text-sm font-medium text-gray-900 mb-1">Controlada / Abierta</label>
                                        <VueMultiselect
                                            v-model="form.scope"
                                            :options="db.scope"
                                            placeholder="Selecciona una si es controlada o abierta"
                                        ></VueMultiselect>
                                        <div v-if="errors.scope" class="text-error">{{ errors.scope }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="block tracking-wide text-sm font-medium text-gray-900 mb-1">Plan</label>
                                <VueMultiselect
                                    v-model="form.modality"
                                    :options="db.modalities"
                                    placeholder="Selecciona una plan"
                                    label="name"
                                    track-by="id"
                                ></VueMultiselect>
                                <div v-if="errors.modality" class="text-error">{{ errors.modality }}</div>
                            </div>

                            <div class="mb-6">
                                <label for="notes" class="block tracking-wide text-sm font-medium text-gray-900 mb-1">Observaciones</label>
                                <textarea v-model="form.notes" id="notes" class="appearance-none block w-full bg-gray-50 text-gray-700 border border-gray-400 rounded py-2 px-3"></textarea>
                            </div>

                            <div class="mb-4 mt-4 text-right">
                                <a :href="route('phone-lines.show', data.id)" class="text-gray-700 bg-gray-100 hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-400 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">Cancelar</a>
                                <button type="submit" class="ml-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Actualizar</button>
                            </div>
                        </div>

                    </form>
                    </div>
                    <div v-else>
                      <div class="text-lg text-gray-800">
                        Ooops, no puedes editar este equipo
                      </div>
                      <div class="text-sm text-gray-600">
                        Para editar el equipo debes finalizar la responsiva vigente 
                      </div>
                    </div>
                    
                </div>

            </div>
        </div>

    </AppLayout>
</template>

<script>

import { useForm } from "@inertiajs/inertia-vue3";
import VueMultiselect from 'vue-multiselect';
import Breadcrumbs from '../../Components/Go/Breadcrumbs.vue';

export default {
    components: {
      VueMultiselect,
      Breadcrumbs
    },
    data() {
        return {
          form: useForm({
                ...this.data,
            }),
            breadcrumbs: [
                { label: "Lineas", url: route('equipments') },
                { label: this.data?.number, url: route('equipments.show', this.data.id) },
                { label: 'Editar' }
            ]

        }
    },

    props: {
        db: Object,
        data: Object,
        errors: Object,
    },

    methods: {
        update() {
            this.form.put( route('phone-lines.update', this.data.id) );
        },
    },

}

</script>




