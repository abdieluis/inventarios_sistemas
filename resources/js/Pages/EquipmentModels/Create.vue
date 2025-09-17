<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <Breadcrumbs :data="breadcrumbs"/>
        </template>
        <div class="py-12 max-w-2xl mx-auto px-6">
            <div class="bg-white shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-12 bg-white border-b border-gray-200">
                    
                    <div class="mt-6 mb-6">
                        <div class="mb-1 text-2xl">
                            Registro de modelo
                        </div>
                        <div class="text-gray-500">
                            Completa los siguientes datos del modelo
                        </div>
                    </div>

                    <form @submit.prevent="store" autocomplete="off">

                        <div class="">
                            <div class="mb-4">
                                <label for="category" class="required block tracking-wide text-sm font-medium text-gray-900 mb-1">Tipo de Equipo</label>
                                <VueMultiselect
                                    v-model="form.category"
                                    :options="db.categories"
                                    placeholder="Selecciona una categoría"
                                    label="name"
                                    track-by="id"
                                ></VueMultiselect>
                                <div v-if="errors.category" class="text-error">{{ errors.category }}</div>
                            </div>
                            <div class="mb-4">
                                <label for="brand" class="required block tracking-wide text-sm font-medium text-gray-900 mb-1">Marca</label>
                                <VueMultiselect
                                    v-model="form.brand"
                                    :options="db.brands"
                                    placeholder="Selecciona una marca"
                                    label="name"
                                    track-by="id"
                                ></VueMultiselect>
                                <div v-if="errors.brand" class="text-error">{{ errors.brand }}</div>
                            </div>
                            
                            <div class="mb-6">
                                <label for="name" class="block tracking-wide text-sm font-medium text-gray-900 mb-1">Nombre del modelo</label>
                                <input type="text" v-model="form.name" id="name" class="appearance-none block w-full bg-gray-50 text-gray-700 border border-gray-400 rounded py-2 px-3" required />
                                <div v-if="errors.name" class="text-error">{{ errors.name }}</div>
                            </div>
                            
                            <div class="mb-4 mt-4 text-right">
                                <a :href="route('equipment-models')" class="text-gray-700 bg-gray-100 hover:bg-gray-200 focus:ring-2 focus:outline-none focus:ring-gray-400 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">Cancelar</a>
                                <button type="submit" class="ml-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-2 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Registrar</button>
                            </div>
                        </div>
                    </form>
                    
                </div>

            </div>
        </div>

    </AppLayout>
</template>

<script>
import { useForm } from "@inertiajs/inertia-vue3";
import VueMultiselect from 'vue-multiselect';
import Breadcrumbs from '@/Components/Go/Breadcrumbs.vue';

export default {
    components: {
        VueMultiselect,
        Breadcrumbs
    },

    //layout: AppLayout,
    remember: 'form',
        data() {
        return {
            form: useForm({
                category: null,
                brand: null,
                name: null,
            }),
            breadcrumbs: [
                { label: "Equipos", url: route('equipments') },
                { label: "Modelos", url: route('equipment-models') },
                { label: "Nuevo" }
            ]
        }
    },

    props: {
        db: Object,
        data: Object,
        errors: Object,
    },

    methods: {
        store() {
            this.form.post( route('equipment-models.store') )
        },
    },

}


</script>




