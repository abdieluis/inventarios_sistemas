<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <Breadcrumbs :data="breadcrumbs"/>
        </template>

        <div class="py-12">
            <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
                
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                    <div class="p-6 sm:px-12 bg-white border-b border-gray-200">

                        <div class="mt-6 mb-6">
                            <div class="mb-1 text-2xl">
                                Nueva Área
                            </div>
                            <div class="text-gray-500">
                                Completa los siguientes datos del área
                            </div>
                        </div>

                        <form @submit.prevent="store" autocomplete="off">
                            <div class="mb-6">
                                <label for="name" class="block mb-0 text-sm font-medium text-gray-900 dark:text-white">Nombre</label>
                                <input type="text" v-model="form.name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                <div v-if="errors.name" class="text-red-600 flex justify-end text-sm">{{ errors.name }}</div>
                            </div>
                            <div class="mb-6 text-rigth text-right">
                                <a :href="route('employment-areas')" class="text-gray-700 bg-gray-100 hover:bg-gray-200 focus:ring-2 focus:outline-none focus:ring-gray-400 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">Cancelar</a>
                                <button type="submit" class="ml-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Registrar</button>
                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>
    </AppLayout>
</template>


<script>
import { useForm } from "@inertiajs/inertia-vue3";
import Breadcrumbs from '@/Components/Go/Breadcrumbs.vue';

export default {
    props: {
        errors: Object
    },
    components: {
        Breadcrumbs
    },
    //layout: AppLayout,
    remember: 'form',
    data() {
        return {
            form: useForm({
                name: '',
            }),
            breadcrumbs: [
                { label: "Empleados", url: route('employees') },
                { label: "Áreas", url: route('employment-areas') },
                { label: "Nueva" }
            ]
        }
    },
    methods: {
        store() {
            this.form.post( route('employment-areas.store') )
        },
    },

}

</script>

