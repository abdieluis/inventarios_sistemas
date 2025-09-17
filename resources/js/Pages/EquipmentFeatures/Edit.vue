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
                            Editar Característica
                        </div>
                        <div class="text-gray-500">
                            Actualiza los datos de la Características
                        </div>
                    </div>

                    <form @submit.prevent="update" autocomplete="off">

                        <div class="">

                            <div class="mb-6">
                                <label for="name" class="block tracking-wide text-sm font-medium text-gray-900 mb-1">Nombre de la característica</label>
                                <input type="text" v-model="form.name" id="name" class="appearance-none block w-full bg-gray-50 text-gray-700 border border-gray-400 rounded py-3 px-4" required />
                                <div v-if="errors.name" class="text-error">{{ errors.name }}</div>
                            </div>

                            <div class="mb-6">
                                <label for="name" class="block tracking-wide text-sm font-medium text-gray-900 mb-1">Tipo de característica</label>
                                <VueMultiselect
                                    v-model="form.type"
                                    :options="db.types"
                                    placeholder="Selecciona el tipo de característica"
                                ></VueMultiselect>
                                <div v-if="errors.type" class="text-error">{{ errors.type }}</div>
                            </div>

                            <div class="mb-6">
                                <label for="name" class="block tracking-wide text-sm font-medium text-gray-900 mb-1">Aplicar a las categorías</label>
                                <VueMultiselect
                                    v-model="form.categories"
                                    :options="db.categories"
                                    :multiple="true"
                                    placeholder="Selecciona las categorias a las que se aplicará"
                                    label="name"
                                    track-by="id"
                                ></VueMultiselect>
                                <div v-if="errors.categories" class="text-error">{{ errors.categories }}</div>
                            </div>
                            
                            <div class="mb-4 mt-4 text-right">
                                <a :href="route('equipment-features.show', data.id)" class="text-gray-700 bg-gray-100 hover:bg-gray-200 focus:ring-2 focus:outline-none focus:ring-gray-400 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">Cancelar</a>
                                <button type="submit" class="ml-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-2 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Actualizar</button>
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
        Breadcrumbs
    },
    data() {
        return {
            form: useForm({
                ...this.data,
            }),
            breadcrumbs: [
                { label: "Equipos", url: route('equipments') },
                { label: "Caracaterísticas", url: route('equipment-features') },
                { label: this.data.name }
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
            this.form.put( route('equipment-features.update', this.data.id) )
        },
    },

}

</script>
