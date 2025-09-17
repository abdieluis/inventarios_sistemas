<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';

import { ref } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';
import DangerButton from '@/Components/DangerButton.vue';
import DialogModal from '@/Components/DialogModal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';


const confirmingUserDeletion = ref(false);

const form = useForm({});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;
};

const deleteItem = ( id ) => {
    form.delete( route('responsives.destroy', id ), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;
};





const confirmingEndResopsive = ref(false);

const confirmResponsiveEnding = () => {
    confirmingEndResopsive.value = true;
};


const endForm = useForm({
    end_at: null,
    ending: null,
    ending_notes: null
});
const finailzeResponsive = ( id ) => {
    endForm.put( route('responsives.finalize', id ), {
        preserveScroll: true,
        onSuccess: () => closeFinailzeResponsiveModal(),
    });
};

const closeFinailzeResponsiveModal = () => {
    confirmingEndResopsive.value = false;
};






const confirmingPromissoryNote  = ref(false);

let equipmentSelected = null;
const confirmPromissoryNote = ( equipment ) => {
    equipmentSelected = equipment;
    confirmingPromissoryNote.value = true;

    console.log( equipmentSelected );
};

const PromissoryNoteForm = useForm({
    amount: null,
});
const createPromissoryNote  = ( responsive_id, id ) => {
    console.log( responsive_id + ' : ' + equipmentSelected.id );
    PromissoryNoteForm.put( route('responsives.equipments.create-promissory-note', [responsive_id, equipmentSelected.id] ), {
        preserveScroll: true,
        onSuccess: () => closePromissoryNoteModal(),
    });
};
const closePromissoryNoteModal = () => {
    confirmingPromissoryNote.value = false;
};




</script>

<template>
    <AppLayout title="Dashboard">

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Responsivas
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-2xl mx-auto px-4">
                
                <div class="bg-white shadow-xl sm:rounded-lg">

                    <div class="p-6 sm:px-8 bg-white border-b border-gray-200">

                        <header class="bg-white">
                            <div class="flex items-center justify-between">
                                <div class="my-4">
                                    <div class="mb-1 text-xl font-semibold tracking-tight text-gray-900">
                                        <span v-if="(data.employee_number!=null)">
                                            {{ data.employment.employee.employee_number }} - 
                                        </span>
                                        {{ data.employment.employee.full_name }}
                                   </div>
                                    <div class="text-gray-500">
                                        <div v-if="(data.equipments.length)">
                                            <div v-for="equipment in data.equipments" class="mb-1">
                                                {{ equipment?.data?.category?.name }}, {{ equipment?.data?.brand?.name }} {{ data.equipment?.data?.model?.name }}<br/>
                                             </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="relative inline-block text-left">

                                    <Dropdown width="48">
                                        <template #trigger>
                                            <span class="inline-flex rounded-md">
                                                <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#474747" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
                                                </button>
                                            </span>
                                        </template>
                                        <template #content>
                                            <div class="w-48">
                                                <div class="block px-4 py-2 text-xs text-gray-400">Opciones de responsiva</div>
                                                <DropdownLink v-if="false" :href="route('equipment-responsives.edit', data.id )">Editar</DropdownLink>
                                                <div class="border-t border-gray-100"></div>
                                                <DropdownLink v-if="data.end_at==null && $page.props.user.id!=9" as="button" @click="confirmResponsiveEnding">Finalizar responsiva</DropdownLink>
                                                <div class="border-t border-gray-100"></div>
                                                <DropdownLink v-if="false" as="button" @click="confirmUserDeletion" class="dropdown-danger">Eliminar</DropdownLink>
                                            </div>
                                        </template>
                                    </Dropdown>

                                    <DialogModal :show="confirmingUserDeletion" max-width="xl" @close="closeModal">
                                        <template #title>Eliminar Responsiva</template>
                                        <template #content>
                                            ¿Estás seguro que quieres eliminar el registro? Una vez que elimines el registro todos sus datos serán borrados permanentemente.
                                        </template>
                                        <template #footer>
                                            <SecondaryButton @click="closeModal">Cancelar</SecondaryButton>
                                            <DangerButton class="ml-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="deleteItem( data.id )">
                                                Eliminar responsiva
                                            </DangerButton>
                                        </template>
                                    </DialogModal>

                                    <DialogModal :show="confirmingEndResopsive" max-width="xl" @close="closeFinailzeResponsiveModal">
                                        <template #title>Finalizar Responsiva</template>
                                        <template #content>
                                            ¿Estás seguro que quieres finalizar la responsiva? Una vez que la finalices todo los equipos que fueron asignados quedarán disponibles
                                            <div class="row">
                                                <div class="my-6">
                                                    <label for="end_at" class="block tracking-wide text-sm font-medium text-gray-900 mb-1">Fecha de recepción del equipo</label>
                                                    <input type="date" :min="data.start_at" v-model="endForm.end_at" id="end_at" class="appearance-none block w-full bg-gray-50 text-gray-700 border border-gray-400 rounded py-2 px-3" required>
                                                    <div v-if="errors.end_at" class="text-error">{{ errors.end_at }}</div>
                                                </div>
                                                <div class="my-6">
                                                    <label for="end_at" class="block tracking-wide text-sm font-medium text-gray-900 mb-1">Motivo de finalización</label>
                                                    <VueMultiselect 
                                                        v-model="endForm.ending"
                                                        :options="db.endings"
                                                        placeholder="Selecciona una opción"
                                                        label="name"
                                                        track-by="id" 
                                                        :show-labels="false"
                                                    ></VueMultiselect>
                                                    <div v-if="errors.ending" class="text-error">{{ errors.ending }}</div>
                                                </div>
                                                <div class="my-6">
                                                    <label for="end_at" class="block tracking-wide text-sm font-medium text-gray-900 mb-1">Notas de finalización</label>
                                                    <textarea v-model="endForm.ending_notes" id="end_at" class="appearance-none block w-full bg-gray-50 text-gray-700 border border-gray-400 rounded py-2 px-3"></textarea>
                                                    <div v-if="errors.ending_notes" class="text-error">{{ errors.ending_notes }}</div>
                                                </div>
                                            </div>
                                        </template>

                                        <template #footer>
                                            <SecondaryButton @click="closeFinailzeResponsiveModal">Cancelar</SecondaryButton>
                                            <PrimaryButton class="ml-3" :class="{ 'opacity-25': endForm.processing }" :disabled="endForm.processing" @click="finailzeResponsive( data.id )">
                                                Finalizar responsiva
                                            </PrimaryButton>
                                        </template>
                                    </DialogModal>

                                    <DialogModal :show="confirmingPromissoryNote" max-width="xl" @close="closePromissoryNoteModal">
                                        <template #title>Generar pagaré</template>
                                        <template #content>
                                            ¿Estás seguro que quieres generar pagaré del equipo seleccinado?, una vez generado el pagaré no podrás eliminarlo.
                                            <div class="my-6">
                                                <label for="amount" class="block tracking-wide text-sm font-medium text-gray-900 mb-1">Importe del pagaré</label>
                                                <input type="text" :min="data.start_at" v-model="PromissoryNoteForm.amount" id="end_at" class="appearance-none block w-full bg-gray-50 text-gray-700 border border-gray-400 rounded py-2 px-3" required>
                                                <div v-if="errors.amount" class="text-error">{{ errors.amount }}</div>
                                            </div>
                                        </template>
                                        <template #footer>
                                            <SecondaryButton @click="closePromissoryNoteModal">Cancelar</SecondaryButton>
                                            <PrimaryButton class="ml-3" :class="{ 'opacity-25': PromissoryNoteForm.processing }" :disabled="PromissoryNoteForm.processing" @click="createPromissoryNote( data.id, data.id )">
                                                Generar pagaré
                                            </PrimaryButton>
                                        </template>
                                    </DialogModal>


                                </div>
                            </div>
                        </header>


                        <div class="text-gray-900 mb-4">
                            <div class="">
                                <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                                    <table class="w-full text-sm text-left text-gray-500">
                                        <caption class="p-5 text-lg font-semibold text-left text-gray-900 bg-stone-100">
                                            <div v-if="(data.end_at!=null)">
                                                Responsiva Finalizada
                                            </div>
                                            <div v-else>
                                                Responsiva Vigente
                                            </div>

                                            <div class="text-blue-600 text-sm text-rigth text-right">
                                                <a :href="route( 'responsives.print', [data.id] )" target="_blank">DESCARGAR RESPONSIVA</a>
                                            </div>

                                        </caption>
                                        <tbody>
                                            <tr class="bg-white border-b">
                                                <th scope="row" class="py-3 px-4 font-medium text-gray-900 whitespace-nowrap">Fecha de inicio</th>
                                                <td class="py-3 px-4">{{ data?.start_at }}</td>
                                            </tr>
                                            <tr class="bg-white border-b">
                                                <th scope="row" class="py-3 px-4 font-medium text-gray-900 whitespace-nowrap">Fecha de finalización</th>
                                                <td class="py-3 px-4">{{ data?.end_at }}</td>
                                            </tr>
                                            <tr class="bg-white border-b" v-if="data?.end_at">
                                                <th scope="row" class="py-3 px-4 font-medium text-gray-900 whitespace-nowrap">Motivo de finalización</th>
                                                <td class="py-3 px-4">{{ data?.ending?.name }}</td>
                                            </tr>
                                            <tr class="bg-white border-b" v-if="data?.end_at">
                                                <th scope="row" class="py-3 px-4 font-medium text-gray-900 whitespace-nowrap">Observaciones de finalización</th>
                                                <td class="py-3 px-4">{{ data?.ending_notes }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>


                        <h5 class="mt-8 mb-1 text-base font-semibold text-gray-900 md:text-lg">
                            Responsable
                        </h5>
                        <div v-if="(data.employment!=null)" class="text-gray-900 mb-4">

                            <div class="">
                                <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                                    <table class="w-full text-sm text-left text-gray-500">
                                        <caption class="p-5 text-lg font-semibold text-left text-gray-900 bg-stone-100">
                                            <div v-if="(data.employment?.employee!=null)">
                                                <span v-if="(data.employment?.employee?.employee_number!=null)">
                                                    {{ data.employment?.employee?.employee_number }} - 
                                                </span>
                                                {{ data.employment?.employee?.full_name }}
                                            </div>
                                            <div v-else>
                                                Sin Responsable
                                            </div>
                                        </caption>
                                        <tbody>
                                            <tr class="bg-white border-b">
                                                <th scope="row" class="py-3 px-4 font-medium text-gray-900 whitespace-nowrap">Planta</th>
                                                <td class="py-3 px-4">{{ data?.employment?.branch?.name }}</td>
                                            </tr>
                                            <tr class="bg-white border-b">
                                                <th scope="row" class="py-3 px-4 font-medium text-gray-900 whitespace-nowrap">Área</th>
                                                <td class="py-3 px-4">{{ data?.employment?.area?.name }}</td>
                                            </tr>
                                            <tr class="bg-white border-b">
                                                <th scope="row" class="py-3 px-4 font-medium text-gray-900 whitespace-nowrap">Puesto</th>
                                                <td class="py-3 px-4">{{ data?.employment?.title?.name }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <p class="m-4 text-sm font-normal text-gray-500 underline text-right">
                                    <a :href="route('employees.show', data?.employment?.employee?.id)">Ver datos del responsable</a>
                                </p>
                            </div>
                                                        
                        </div>
                        <div v-else class="text-gray-700 mb-4">
                            <div class="w-full p-4 bg-white border rounded-lg shadow-md sm:p-6 dark:bg-gray-800 dark:border-gray-700">
                                <p class="text-sm font-normal text-gray-500 text-center">
                                    SIN RESPONSALE
                                </p>
                            </div>
                        </div>

                        
                        <h5 class="mt-8 mb-1 text-base font-semibold text-gray-900 md:text-lg">
                            Equipos Entregados
                            <span class="ml-1 bg-blue-100 text-blue-800 text-md font-semibold mr-2 px-2 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800">{{ data.equipments.length ?? '' }}</span>
                        </h5>
                        <div v-if="(data.equipments.length)" class="text-gray-900 mb-4">
                            <div v-for="equipment in data.equipments" class="mb-4">
                                <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                                    <table class="w-full text-sm text-left text-gray-500">
                                        <caption class="p-5 text-lg font-semibold text-left text-gray-900 bg-stone-100">
                                            <div v-if="(equipment.amount!=null)">
                                                <div class="flex items-center justify-between">
                                                    <div class="my-4">
                                                        <div class="mb-1 text-xl font-semibold tracking-tight text-gray-600">
                                                            Pagaré
                                                        </div>
                                                    </div>
                                                    <div class="relative inline-block text-left">
                                                        $ {{ Intl.NumberFormat('es-MX').format(equipment.amount) }}
                                                    </div>
                                                </div>
                                                <div class="text-blue-600 text-sm text-rigth text-right">
                                                    <a :href="route( 'responsives.equipments.print-promissory-note', [data.id, equipment.id] )" target="_blank">DESCARGAR PAGARÉ</a>
                                                </div>
                                            </div>
                                            <div v-else>
                                                <div class="flex items-center justify-between">
                                                    <div class="my-4">
                                                        <div class="mb-1 text-xl font-semibold tracking-tight text-gray-600">
                                                            Sin pagaré
                                                        </div>
                                                    </div>
                                                    <div v-if="data.end_at==null" class="relative inline-block text-left">
                                                        <PrimaryButton @click="confirmPromissoryNote(equipment)">Generar pagaré</PrimaryButton>
                                                    </div>
                                                </div>
                                            </div>
                                        </caption>
                                        <tbody>
                                            <tr class="bg-white border-b">
                                                <th scope="row" class="py-3 px-4 font-medium text-gray-900 whitespace-nowrap">Tipo de Equipo</th>
                                                <td class="py-3 px-4">{{ equipment.data?.category?.name }}</td>
                                            </tr>
                                            <tr class="bg-white border-b">
                                                <th scope="row" class="py-3 px-4 font-medium text-gray-900 whitespace-nowrap">Marca</th>
                                                <td class="py-3 px-4">{{ equipment.data?.brand?.name }}</td>
                                            </tr>
                                            <tr class="bg-white border-b">
                                                <th scope="row" class="py-3 px-4 font-medium text-gray-900 whitespace-nowrap">Modelo</th>
                                                <td class="py-3 px-4">{{ equipment.data?.model?.name }}</td>
                                            </tr>
                                            <tr class="bg-white border-b">
                                                <th scope="row" class="py-3 px-4 font-medium text-gray-900 whitespace-nowrap">Placa</th>
                                                <td class="py-3 px-4">{{ equipment.data?.sku }}</td>
                                            </tr>
                                            <tr class="bg-white border-b">
                                                <th scope="row" class="py-3 px-4 font-medium text-gray-900 whitespace-nowrap">No. de Serie</th>
                                                <td class="py-3 px-4">{{ equipment.data?.serial }}</td>
                                            </tr>
                                            <tr class="bg-white border-b">
                                                <th scope="row" class="py-3 px-4 font-medium text-gray-900 whitespace-nowrap">Estado del equipo</th>
                                                <td class="py-3 px-4">{{ equipment.data?.lifecycle }}</td>
                                            </tr>

                                            <tr v-if="equipment.phoneline!=null" class="bg-white border-b">
                                                <th scope="row" class="py-3 px-4 font-medium text-gray-900 whitespace-nowrap">Linea teléfonica</th>
                                                <td class="py-3 px-4">{{ equipment.phoneline?.number }}</td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                                <p class="m-4 text-sm font-normal text-gray-500 underline text-right">
                                    <a :href="route('equipments.show', equipment.equipment_id)">Ver datos del equipo</a>
                                </p>
                            </div>
                        </div>
                        <div v-else class="text-gray-700 mb-4">
                            <div class="w-full p-4 bg-white border rounded-lg shadow-md sm:p-6 dark:bg-gray-800 dark:border-gray-700">
                                <p class="text-sm font-normal text-gray-500 text-center">
                                    SIN EQUIPO
                                </p>
                            </div>
                        </div>

                        <h5 class="mt-8 mb-1 text-base font-semibold text-gray-900 md:text-lg">
                            Accesorios
                        </h5>
                        <div v-if="data.accessories.length" class="text-gray-700 mb-4">
                            <div class="w-full p-4 bg-white border rounded-lg shadow-md sm:p-6 dark:bg-gray-800 dark:border-gray-700">
                                <p class="text-sm font-normal text-gray-500 text-center">
                                    SIN ACCESORIOS
                                </p>
                            </div>
                        </div>
                        <div v-else class="text-gray-700 mb-4">
                            <div class="w-full p-4 bg-white border rounded-lg shadow-md sm:p-6 dark:bg-gray-800 dark:border-gray-700">
                                <p class="text-sm font-normal text-gray-500 text-center">
                                    {{ data.accessories }}
                                </p>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>

    </AppLayout>
</template>


<script>
import VueMultiselect from 'vue-multiselect';


export default {
    components: {
        VueMultiselect
    },
    //layout: AppLayout,
    remember: 'form',
    data() {
        return {
            openMenu: false
        }
    },

    props: {
        base_url: String,
        data: Object,
        errors: Object,
        db: Object,
    },

    methods: {
    }

}

</script>

