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

const confirmingUserDeletion = ref(false);

const passwordInput = ref(null);
const form = useForm({
    password: '',
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;
    //setTimeout(() => passwordInput.value.focus(), 250);
};

const deleteItem = ( id ) => {
    form.delete( route('employment-areas.destroy', id ), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        // onError: () => passwordInput.value.focus(),
        // onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;
};


</script>

<template>
    <AppLayout title="Dashboard">

        <template #header>
            <Breadcrumbs :data="breadcrumbs"/>
        </template>

        <div class="py-12">

            <div class="max-w-2xl mx-auto px-4">
                
                <div class="bg-white shadow-xl sm:rounded-lg">

                    <div class="p-6 sm:px-8 bg-white border-b border-gray-200">

                        <header class="bg-white">
                            <div class="flex items-center justify-between">
                                <div class="my-4">
                                    <div class="mb-1 text-xl font-semibold tracking-tight text-gray-900">
                                        {{ data?.name }}
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
                                                <div class="block px-4 py-2 text-xs text-gray-400">Area options</div>
                                                <DropdownLink v-if="true" :href="route('employment-areas.edit', data.id )">Editar</DropdownLink>
                                                <div class="border-t border-gray-100"></div>
                                                <DropdownLink v-if="true" as="button" @click="confirmUserDeletion" class="dropdown-danger">Eliminar</DropdownLink>
                                            </div>
                                        </template>
                                    </Dropdown>

                                    <DialogModal :show="confirmingUserDeletion" max-width="xl" @close="closeModal">
                                        <template #title>Eliminar Área</template>
                                        <template #content>
                                            ¿Estás seguro que quieres eliminar el registro? Una vez que elimines el registro todos sus datos serán borrados permanentemente.
                                        </template>
                                        <template #footer>
                                            <SecondaryButton @click="closeModal">Cancelar</SecondaryButton>
                                            <DangerButton class="ml-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="deleteItem( data.id )">
                                                Eliminar Área
                                            </DangerButton>
                                        </template>
                                    </DialogModal>

                                </div>
                            </div>
                        </header>


                        <div class="flex flex-col items-center md:flex-row md:max-w-xl">
                        </div>

                    </div>

                </div>
            </div>
        </div>

    </AppLayout>
</template>


<script>
import Breadcrumbs from '@/Components/Go/Breadcrumbs.vue';

export default {
    components: {
        Breadcrumbs
    },
    //layout: AppLayout,
    remember: 'form',
    data() {
        return {
            breadcrumbs: [
                { label: "Empleados", url: route('employees') },
                { label: "Áreas", url: route('employment-areas') },
                { label: this.data.name }
            ]
        }
    },

    props: {
        data: Object,
        errors: Object,
        db: Object,
    },

}

</script>

