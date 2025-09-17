<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Empleados | {{ employee.full_name }} | Periodos de Trabajo
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
                
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                    <div class="p-6 sm:px-12 bg-white border-b border-gray-200">


                        <div class="mt-6 mb-6">
                            <div class="mb-1 text-2xl">{{ employee.full_name }}</div>
                            <div class="text-gray-500">Empleos asignados
                                <span class="ml-1 bg-blue-100 text-blue-800 text-md font-semibold mr-2 px-2 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800">{{ data.length ?? '' }}</span>
                            </div>
                        </div>

                        <form @submit.prevent="store" autocomplete="off">

                            {{ data }}

                            <div class="mb-6 mt-4 text-right">
                                <a :href="data.id + '/edit'" class="text-gray-700 bg-gray-100 hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-400 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">Editar</a>
                                <button type="submit" class="ml-2 text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">Eliminar</button>
                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>
    </AppLayout>
</template>


<script>

export default {
    components: {
    },
    //layout: AppLayout,
    remember: 'form',
    data() {
        return {
        }
    },

    props: {
        data: Object,
        employee: Object,
        errors: Object,
        db: Object,
    },

}

</script>

