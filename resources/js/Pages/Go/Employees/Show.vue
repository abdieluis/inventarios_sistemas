<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Header from './Components/Header.vue';

import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';

import DangerButton from '@/Components/DangerButton.vue';
import DialogModal from '@/Components/DialogModal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';

import { ref, computed, toRaw } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';

import Multiselect from '@vueform/multiselect';
import '@vueform/multiselect/themes/default.css';

// Se importan las props directamente
const props = defineProps({
    data: Object,
    errors: Object,
    db: Object,
    allTitles: Object,

});
const confirmingUserDeletion = ref(false);


const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;
};

const deleteItem = (id) => {
    form.delete(route('employees.destroy', id), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;
};

const isEditing = ref(false);

const selectedTitle = ref(props.data.current_employment?.title?.id || null);
// const selectedTitle = ref(props.data.current_employment?.title || null);
const form = useForm({
    title_id: selectedTitle.value?.id || null,
});

const titlesArray = computed(() => {
    if (!props.allTitles || typeof props.allTitles !== 'object') {
        return [];
    }

    return Object.values(props.allTitles).map(item => ({
        value: item.id,
        label: item.name
    }));
});

const nameWithLang = (title) => {
    return title.name;
};

const handleUpdateTitle = () => {

    if (!selectedTitle.value) {
        alert('Debes seleccionar un puesto.');
        return;
    }

    form.title_id = toRaw(selectedTitle.value);

    form.put(route('employees.update', props.data.id), {
        preserveScroll: true,
        onSuccess: () => {
            isEditing.value = false;
        },
        onError: (errors) => {
            console.error('Error al actualizar el puesto.', errors);
        },
    });
};

const cancelEditing = () => {
    isEditing.value = false;
    selectedTitle.value = props.data.current_employment?.title?.id || null;
};

</script>

<style src="vue-toastification/dist/index.css"></style>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>


<template>
    <AppLayout title="Dashboard">

        <template #header>
            <Header />
        </template>

        <div class="py-12">
            <div class="max-w-2xl mx-auto px-4">

                <div class="bg-white shadow-xl sm:rounded-lg">

                    <div class="p-6 sm:px-8 bg-white border-b border-gray-200">

                        <header class="bg-white">
                            <div class="flex items-center justify-between">
                                <div class="my-4">
                                    <div class="mb-1 text-xl font-semibold tracking-tight text-gray-900">
                                        <span v-if="(data.employee_number != null)">
                                            {{ data.employee_number }} -
                                        </span>
                                        {{ data.full_name }}
                                    </div>

                                    <div v-if="(data.current_employment != null)" class="text-gray-500">
                                        {{ data.current_employment.title?.name }}
                                    </div>

                                </div>

                                <div class="relative inline-block text-left">

                                    <Dropdown width="48">
                                        <template #trigger>
                                            <span class="inline-flex rounded-md">
                                                <button type="button"
                                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28"
                                                        viewBox="0 0 24 24" fill="none" stroke="#474747"
                                                        stroke-width="1.5" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <line x1="3" y1="12" x2="21" y2="12"></line>
                                                        <line x1="3" y1="6" x2="21" y2="6"></line>
                                                        <line x1="3" y1="18" x2="21" y2="18"></line>
                                                    </svg>
                                                </button>
                                            </span>
                                        </template>
                                        <template #content>
                                            <div class="w-48">
                                                <div class="block px-4 py-2 text-xs text-gray-400">Employee options
                                                </div>
                                                <DropdownLink v-if="$page.props.user.id != 9"
                                                    :href="route('employees.edit', data.id)">Editar</DropdownLink>
                                                <DropdownLink v-if="$page.props.user.id != 9"
                                                    :href="route('employees.create')">Duplicar</DropdownLink>
                                                <div class="border-t border-gray-100"></div>
                                                <DropdownLink v-if="$page.props.user.id != 9"
                                                    :href="route('responsives.create', { employee: data.id })">Asignar
                                                    equipo</DropdownLink>
                                                <DropdownLink v-if="$page.props.user.id != 9"
                                                    :href="route('employees.employments', data.id)">Cargos anteriores
                                                    ({{ data.employments?.length ?? 0 }})</DropdownLink>
                                                <div class="border-t border-gray-100"></div>
                                                <DropdownLink v-if="$page.props.user.id != 9" as="button"
                                                    @click="confirmUserDeletion" class="dropdown-danger">Eliminar
                                                </DropdownLink>
                                            </div>
                                        </template>
                                    </Dropdown>

                                    <DialogModal :show="confirmingUserDeletion" max-width="xl" @close="closeModal">
                                        <template #title>Eliminar Empleado</template>
                                        <template #content>
                                            ¿Estás seguro que quieres eliminar el registro? Una vez que elimines el
                                            registro todos sus datos serán borrados permanentemente.
                                        </template>
                                        <template #footer>
                                            <SecondaryButton @click="closeModal">Cancelar</SecondaryButton>
                                            <DangerButton class="ml-3" :class="{ 'opacity-25': form.processing }"
                                                :disabled="form.processing" @click="deleteItem(data.id)">
                                                Eliminar Empleado
                                            </DangerButton>
                                        </template>
                                    </DialogModal>

                                </div>
                            </div>
                        </header>

                        <div v-if="(data.current_employment != null)" class="text-gray-900 mb-4">

                            <h5 class="mt-2 mb-1 text-base font-semibold text-gray-900 md:text-lg">
                                Puesto laboral vigente
                            </h5>
                            <div class="mb-8">
                                <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                                    <table class="w-full text-sm text-left text-gray-500">
                                        <!--caption class="p-5 text-lg font-semibold text-left text-gray-900 bg-white">
                                            Puesto laboral vigente
                                        </caption-->
                                        <tbody>
                                            <tr class="bg-white border-b">
                                                <th scope="row"
                                                    class="py-3 px-4 font-medium text-gray-900 whitespace-nowrap">
                                                    Planta</th>
                                                <td class="py-3 px-4">{{ data.current_employment.branch?.name }}</td>
                                            </tr>
                                            <tr class="bg-white border-b">
                                                <th scope="row"
                                                    class="py-3 px-4 font-medium text-gray-900 whitespace-nowrap">
                                                    Área</th>
                                                <td class="py-3 px-4">{{ data.current_employment.area?.name }}</td>
                                            </tr>
                                            <tr class="bg-white border-b">
                                                <th scope="row"
                                                    class="py-3 px-4 font-medium text-gray-900 whitespace-nowrap">
                                                    Puesto</th>
                                                <td class="py-3 px-4">
                                                    <div v-if="!isEditing" class="flex items-center">
                                                        <span>{{ data.current_employment.title?.name }}</span>
                                                        <button @click="isEditing = true"
                                                            class="ml-2 text-gray-500 hover:text-blue-600">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                            </svg>
                                                        </button>
                                                    </div>

                                                    <div v-else>
                                                        <div class="relative">
                                                            <Multiselect v-model="selectedTitle" :options="titlesArray"
                                                                placeholder="Filtrar puestos..." :searchable="true" />
                                                        </div>
                                                        <div class="mt-2 flex justify-end space-x-2">
                                                            <button @click="handleUpdateTitle"
                                                                class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">Aceptar</button>
                                                            <button @click="cancelEditing"
                                                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300">Cancelar</button>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="bg-white border-b">
                                                <th scope="row"
                                                    class="py-3 px-4 font-medium text-gray-900 whitespace-nowrap">
                                                    Desde</th>
                                                <td class="py-3 px-4">{{ new
                                                    Date(data.current_employment.start_at).toLocaleDateString("es-MX")
                                                    }}</td>
                                            </tr>
                                            <tr class="bg-white border-b">
                                                <th scope="row"
                                                    class="py-3 px-4 font-medium text-gray-900 whitespace-nowrap">
                                                    Hasta</th>
                                                <td class="py-3 px-4">{{ data.current_employment.end_at ?? 'ACTUAL' }}
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                                <!-- aqui quiero agregar un boton de aceptar o cancelar -->
                            </div>

                            <h5 class="mt-6 mb-1 text-base font-semibold text-gray-900 md:text-lg">
                                Equipos Asignados
                                <span
                                    class="ml-1 bg-blue-100 text-blue-800 text-md font-semibold mr-2 px-2 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800">{{
                                        data.current_employment.responsives?.length ?? '0' }}</span>
                            </h5>
                            <div class="mb-4">
                                <div v-if="data.current_employment.responsives.length">
                                    <div v-for="responsive in data.current_employment.responsives" class="mb-4">
                                        <div
                                            class="w-full p-4 bg-white border rounded-lg shadow-md sm:p-6 dark:bg-gray-800 dark:border-gray-700">

                                            <div v-for="equipment in responsive.equipments"
                                                class="flex items-center justify-between">
                                                <h6 class="mb-1 text-base font-semibold text-gray-700 md:text-md">
                                                    {{ equipment.category?.name }}
                                                </h6>

                                                <!--div class="relative inline-block text-left">
                                                    <Dropdown width="48">
                                                        <template #trigger>
                                                            <span class="inline-flex rounded-md">
                                                                <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#474747" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                                                                </button>
                                                            </span>
                                                        </template>
                                                        <template #content>
                                                            <div class="w-48">
                                                                <DropdownLink v-if="true" :href="route('employees.edit', data.id )">Asignar equipo</DropdownLink>
                                                                <div class="border-t border-gray-100" />
                                                                <DropdownLink v-if="true" as="button" @click="confirmUserDeletion" class="dropdown-danger">Finalizar cargo</DropdownLink>
                                                            </div>
                                                        </template>
                                                    </Dropdown>
                                                    <DialogModal :show="confirmingUserDeletion" max-width="xl" @close="closeModal">
                                                        <template #title>Eliminar Empleado</template>
                                                        <template #content>
                                                            ¿Estás seguro que quieres eliminar el registro? Una vez que elimines el registro todos sus datos serán borrados permanentemente.
                                                        </template>
                                                        <template #footer>
                                                            <SecondaryButton @click="closeModal">Cancelar</SecondaryButton>
                                                            <DangerButton class="ml-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="deleteItem( data.id )">
                                                                Eliminar Empleado
                                                            </DangerButton>
                                                        </template>
                                                    </DialogModal>
                                                </div-->


                                                <p class="text-sm font-normal text-gray-500 dark:text-gray-400">Marca:
                                                    {{
                                                        equipment.data?.brand.name }}</p>

                                                <p class="text-sm font-normal text-gray-500 dark:text-gray-400">Placa:
                                                    {{
                                                        equipment.data?.sku }}</p>
                                                <p class="text-sm font-normal text-gray-500 dark:text-gray-400">modelo:
                                                    {{
                                                        equipment.data?.model }}</p>

                                                <p class="text-sm font-normal text-gray-500 dark:text-gray-400">{{
                                                    equipment.data?.start_at }}</p>
                                                <p class="text-sm font-normal text-gray-500 dark:text-gray-400">{{
                                                    equipment.data?.end_at }}</p>

                                                <p class="text-sm font-normal text-gray-500 dark:text-gray-400">{{
                                                    equipment.data?.lifecycle }}</p>

                                                <p class="text-sm font-normal text-gray-500 dark:text-gray-400">{{
                                                    equipment.data?.serial }}</p>
                                                <p class="text-sm font-normal text-gray-500 dark:text-gray-400">{{
                                                    equipment.data?.features }}</p>
                                                <p class="text-sm font-normal text-gray-500 dark:text-gray-400">{{
                                                    equipment.data?.notes }}</p>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div v-else>
                                    <div
                                        class="w-full p-4 bg-white border rounded-lg shadow-md sm:p-6 dark:bg-gray-800 dark:border-gray-700">
                                        <p class="text-sm font-normal text-gray-500 text-center">
                                            El empleado no tiene equipos asignados en el cargo laboral vigente, haz
                                            <a :href="route('responsives.create', { employee: data.id })"
                                                class="hover:underline font-bold text-gray-700">
                                                clic aquí
                                            </a>
                                            para asignarle uno
                                        </p>
                                    </div>
                                </div>
                            </div>

                        </div>


                        <div v-else="(data.current_employment!=null)" class="text-gray-700 mb-4">

                            <div
                                class="w-full p-4 bg-white border rounded-lg shadow-md sm:p-6 dark:bg-gray-800 dark:border-gray-700">
                                <p class="text-sm font-normal text-gray-500 text-center">
                                    El empleado no tiene un cargo laboral vigente, haz
                                    <a :href="route('employees.employments.create', data.id)"
                                        class="hover:underline font-bold text-gray-700">
                                        clic aquí
                                    </a>
                                    para asignarle uno, una vez que agregues un cargo laboral también podrás asignarle
                                    equipos
                                </p>
                            </div>

                        </div>

                        <div>
                            <!--a href="#" class="inline-flex items-center text-xs font-normal text-gray-500 hover:underline dark:text-gray-400">
                                <svg class="w-3 h-3 mr-2" aria-hidden="true" focusable="false" data-prefix="far" data-icon="question-circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M256 8C119.043 8 8 119.083 8 256c0 136.997 111.043 248 248 248s248-111.003 248-248C504 119.083 392.957 8 256 8zm0 448c-110.532 0-200-89.431-200-200 0-110.495 89.472-200 200-200 110.491 0 200 89.471 200 200 0 110.53-89.431 200-200 200zm107.244-255.2c0 67.052-72.421 68.084-72.421 92.863V300c0 6.627-5.373 12-12 12h-45.647c-6.627 0-12-5.373-12-12v-8.659c0-35.745 27.1-50.034 47.579-61.516 17.561-9.845 28.324-16.541 28.324-29.579 0-17.246-21.999-28.693-39.784-28.693-23.189 0-33.894 10.977-48.942 29.969-4.057 5.12-11.46 6.071-16.666 2.124l-27.824-21.098c-5.107-3.872-6.251-11.066-2.644-16.363C184.846 131.491 214.94 112 261.794 112c49.071 0 101.45 38.304 101.45 88.8zM298 368c0 23.159-18.841 42-42 42s-42-18.841-42-42 18.841-42 42-42 42 18.841 42 42z"></path></svg>
                                {{ data.phone }}, {{ data.address }}
                            </a-->
                            <span class="inline-flex items-center text-sm font-normal text-gray-500">
                                {{ data.phone }}, {{ data.address }}
                            </span>
                        </div>

                        <div v-if="data.files?.id != null">
                            <a :href="data.files?.id" target="_blank"
                                class="inline-flex items-center text-xs font-normal text-gray-500 hover:underline dark:text-gray-400">
                                <svg class="w-3 h-3 mr-2" aria-hidden="true" focusable="false" data-prefix="far"
                                    data-icon="question-circle" role="img" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 512 512">
                                    <path fill="currentColor"
                                        d="M256 8C119.043 8 8 119.083 8 256c0 136.997 111.043 248 248 248s248-111.003 248-248C504 119.083 392.957 8 256 8zm0 448c-110.532 0-200-89.431-200-200 0-110.495 89.472-200 200-200 110.491 0 200 89.471 200 200 0 110.53-89.431 200-200 200zm107.244-255.2c0 67.052-72.421 68.084-72.421 92.863V300c0 6.627-5.373 12-12 12h-45.647c-6.627 0-12-5.373-12-12v-8.659c0-35.745 27.1-50.034 47.579-61.516 17.561-9.845 28.324-16.541 28.324-29.579 0-17.246-21.999-28.693-39.784-28.693-23.189 0-33.894 10.977-48.942 29.969-4.057 5.12-11.46 6.071-16.666 2.124l-27.824-21.098c-5.107-3.872-6.251-11.066-2.644-16.363C184.846 131.491 214.94 112 261.794 112c49.071 0 101.45 38.304 101.45 88.8zM298 368c0 23.159-18.841 42-42 42s-42-18.841-42-42 18.841-42 42-42 42 18.841 42 42z">
                                    </path>
                                </svg>
                                Identificación
                            </a>
                        </div>

                        <div v-if="data.files?.address != null">
                            <a :href="data.files?.address" target="_blank"
                                class="inline-flex items-center text-xs font-normal text-gray-500 hover:underline dark:text-gray-400">
                                <svg class="w-3 h-3 mr-2" aria-hidden="true" focusable="false" data-prefix="far"
                                    data-icon="question-circle" role="img" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 512 512">
                                    <path fill="currentColor"
                                        d="M256 8C119.043 8 8 119.083 8 256c0 136.997 111.043 248 248 248s248-111.003 248-248C504 119.083 392.957 8 256 8zm0 448c-110.532 0-200-89.431-200-200 0-110.495 89.472-200 200-200 110.491 0 200 89.471 200 200 0 110.53-89.431 200-200 200zm107.244-255.2c0 67.052-72.421 68.084-72.421 92.863V300c0 6.627-5.373 12-12 12h-45.647c-6.627 0-12-5.373-12-12v-8.659c0-35.745 27.1-50.034 47.579-61.516 17.561-9.845 28.324-16.541 28.324-29.579 0-17.246-21.999-28.693-39.784-28.693-23.189 0-33.894 10.977-48.942 29.969-4.057 5.12-11.46 6.071-16.666 2.124l-27.824-21.098c-5.107-3.872-6.251-11.066-2.644-16.363C184.846 131.491 214.94 112 261.794 112c49.071 0 101.45 38.304 101.45 88.8zM298 368c0 23.159-18.841 42-42 42s-42-18.841-42-42 18.841-42 42-42 42 18.841 42 42z">
                                    </path>
                                </svg>
                                Comprobante de domicilio
                            </a>
                        </div>

                    </div>

                </div>
            </div>
        </div>

    </AppLayout>
</template>


<!-- <script>
import { reactive, ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { useForm } from "@inertiajs/inertia-vue3";
export default {
    components: {
    },
    //layout: AppLayout,
    remember: 'form',
    data() {
        return {
        }
    },

    // props: {
    //     base_url: String,
    //     data: Object,
    //     errors: Object,
    //     db: Object,
    // },
    // mounted() {
    //     console.log('Props completas:', this.$props);
    //     console.log('Prop "data":', this.data);
    //     console.log('Prop "errors":', this.errors);
    //     console.log('Prop "db":', this.db);
    // },

    props: {
        data: Object,
        errors: Object,
        db: Object,
        employmentTitles: {
            type: Array,
            default: () => []
        }
    },

    setup(props) {
        // Variable para controlar si el select está visible
        const isEditing = ref(false);
        // Variable para la lista de puestos (la vamos a usar para filtrar)
        const allTitles = ref(props.employmentTitles);
        // Variable para el puesto seleccionado
        const selectedTitle = ref(null);
        // Variable para el término de búsqueda en el input
        const searchTerm = ref('');

        // Lógica para filtrar los puestos
        const filteredTitles = computed(() => {
            if (!searchTerm.value) {
                return allTitles.value;
            }
            return allTitles.value.filter(title =>
                title.name.toLowerCase().includes(searchTerm.value.toLowerCase())
            );
        });

        const updateTitle = () => {
            // Lógica para enviar la actualización al backend
            Inertia.put(route('employees.update-title', props.data.id), {
                new_title_id: selectedTitle.value.id
            }).then(() => {
                // Después de una actualización exitosa, vuelve al modo de visualización
                isEditing.value = false;
            });
        };

        return {
            isEditing,
            selectedTitle,
            searchTerm,
            filteredTitles,
            updateTitle,
        };
    },

    methods: {
    },

}

</script> -->
