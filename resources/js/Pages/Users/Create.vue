<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

/*
export default {

    setup () {
        const forms = reactive({
            first_name: null,
            last_name: null,
            email: null,
        })

        const form2 = useForm({
            first_name: null,
            last_name: null,
            email: null,
        });

        function submit() {
            Inertia.post('/users', form)
        }

        return { form, submit }

    },

    methods: {
        submit() {
            this.form.post(route("posts.store"));
        },
    },

}
*/

</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Empleados
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
                
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                    <div class="p-6 sm:px-12 bg-white border-b border-gray-200">

                        <div class="mt-6 mb-6">
                            <div class="mb-1 text-2xl">
                                Registro de Empleado!
                            </div>
                            <div class="text-gray-500">
                                Completa los siguientes datos del Empleado
                            </div>
                        </div>

                        <form @submit.prevent="store" autocomplete="off">
                            <div class="mb-6">
                                <label for="employee_number" class="block mb-0 text-sm font-medium text-gray-900 dark:text-white">No. Empleado</label>
                                <input type="text" v-model="form.employee_number" id="employee_number" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                            </div>
                            <div class="mb-6">
                                <label for="first_name" class="block mb-0 text-sm font-medium text-gray-900 dark:text-white">Nombre</label>
                                <input type="text" v-model="form.first_name" id="first_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                            </div>
                            <div class="mb-6">
                                <label for="last_name" class="block mb-0 text-sm font-medium text-gray-900 dark:text-white">Apellidos</label>
                                <input type="text" v-model="form.last_name" id="last_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                            </div>
                            <div class="mb-6">
                                <label for="phone" class="block mb-0 text-sm font-medium text-gray-900 dark:text-white">Teléfono</label>
                                <input type="text" v-model="form.phone" id="phone" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                            </div>
                            <div class="mb-6">
                                <label for="address" class="block mb-0 text-sm font-medium text-gray-900 dark:text-white">Dirección</label>
                                <textarea v-model="form.address" id="address" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required></textarea>
                            </div>
                            <div class="mb-6 text-rigth text-right">
                                <button type="button" class="text-gray-700 bg-gray-100 hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-400 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">Cancelar</button>
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
import { reactive } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { useForm } from "@inertiajs/inertia-vue3";

export default {
    components: {
    },
    //layout: AppLayout,
    remember: 'form',
    data() {
        return {
            form: useForm({
                first_name: '',
                last_name: '',
                phone: '',
                address: '',
            }),
        }
    },
    methods: {
        store() {
            this.form.post('/employees')
        },
    },

}


/*

export default {
  setup () {
    const form = reactive({
      first_name: null,
      last_name: null,
      email: null,
    })

    function submit() {
      Inertia.post('/users', form)
    }

    return { form, submit }
  },


    components: {
    },
    props: {
        posts: Object,
    },
    methods: {
        destroy(id) {
            this.$inertia.delete(route("employees.destroy", id));
        },
    },

}
*/


</script>

