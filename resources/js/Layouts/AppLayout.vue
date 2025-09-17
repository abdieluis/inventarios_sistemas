<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { Head, Link } from '@inertiajs/inertia-vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Banner from '@/Components/Banner.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { usePage } from '@inertiajs/inertia-vue3';

defineProps({
    title: String,
});

const page = usePage();

// console.log('Objeto de la página:', page.props);

const showingNavigationDropdown = ref(false);

const switchToTeam = (team) => {
    Inertia.put(route('current-team.update'), {
        team_id: team.id,
    }, {
        preserveState: false,
    });
};

const logout = () => {
    Inertia.post(route('logout'));
};
</script>

<template>
    <div>

        <Head :title="title" />

        <Banner />

        <div class="min-h-screen bg-gray-100">
            <nav class="bg-white border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <Link :href="route('dashboard')">
                                <ApplicationMark class="block h-9 w-auto" />
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex" v-if="$page.props.user?.id">
                                <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
                                    Dashboard
                                </NavLink>
                                <NavLink :href="route('users')"
                                    :active="route().current('users')">
                                    Usuarios
                                </NavLink>
                                <NavLink :href="route('employees')" :active="route().current('employees')">
                                    Empleados
                                </NavLink>
                                <NavLink :href="route('equipments')" :active="route().current('equipments')">
                                    Equipos
                                </NavLink>
                                <NavLink :href="route('phone-lines')" :active="route().current('phone-lines')">
                                    Lineas
                                </NavLink>
                                <NavLink :href="route('responsives')" :active="route().current('responsives')">
                                    Responsivas
                                </NavLink>
                                <NavLink :href="route('reports')" :active="route().current('reports')">
                                    Reportes
                                </NavLink>
                            </div>
                            <!-- <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex" v-if="$page.props.user?.id">

                                <NavLink :href="route('responsives')" :active="route().current('responsives')">
                                    Responsivas
                                </NavLink>

                            </div> -->
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                            <div class="ml-3 relative">
                                <!-- Teams Dropdown -->
                                <Dropdown v-if="$page.props.jetstream?.hasTeamFeatures" align="right" width="60">
                                    <template #trigger>
                                    </template>

                                    <template #content>
                                        <div class="w-60">
                                            <!-- Team Management -->
                                            <template v-if="$page.props.jetstream?.hasTeamFeatures">
                                                <div class="block px-4 py-2 text-xs text-gray-400">
                                                    Administrar equipo
                                                </div>

                                                <!-- Team Settings -->
                                                <DropdownLink
                                                    :href="route('teams.show', $page.props.user?.current_team)">
                                                    Ajustes de equipo
                                                </DropdownLink>

                                                <DropdownLink v-if="$page.props.jetstream?.canCreateTeams"
                                                    :href="route('teams.create')">
                                                    Crear nuevo equipo
                                                </DropdownLink>

                                                <div class="border-t border-gray-100" />

                                                <!-- Team Switcher -->
                                                <div class="block px-4 py-2 text-xs text-gray-400">
                                                    Cambiar equipo
                                                </div>

                                                <template v-for="team in $page.props.user?.all_teams" :key="team.id">
                                                    <form @submit.prevent="switchToTeam(team)">
                                                        <DropdownLink as="button">
                                                            <div class="flex items-center">
                                                                <svg v-if="team.id == $page.props.user?.current_team_id"
                                                                    class="mr-2 h-5 w-5 text-green-400" fill="none"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" stroke="currentColor"
                                                                    viewBox="0 0 24 24">
                                                                    <path
                                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                </svg>
                                                                <div>{{ team.name }}</div>
                                                            </div>
                                                        </DropdownLink>
                                                    </form>
                                                </template>
                                            </template>
                                        </div>
                                    </template>
                                </Dropdown>
                            </div>

                            <!-- Settings Dropdown -->
                            <div class="ml-3 relative">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <button v-if="$page.props.jetstream?.managesProfilePhotos"
                                            class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                            <img class="h-8 w-8 rounded-full object-cover"
                                                :src="$page.props.user?.profile_photo_url"
                                                :alt="$page.props.user?.name">
                                        </button>

                                        <span v-else class="inline-flex rounded-md">
                                            <button type="button"
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                                                {{ $page.props.user?.name }}

                                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <!-- Account Management -->
                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            Mi cuenta
                                        </div>

                                        <DropdownLink :href="route('profile.show')">
                                            Perfil
                                        </DropdownLink>

                                        <DropdownLink v-if="$page.props.jetstream?.hasApiFeatures"
                                            :href="route('api-tokens.index')">
                                            API Tokens
                                        </DropdownLink>

                                        <div class="border-t border-gray-100" />

                                        <!-- Authentication -->
                                        <form @submit.prevent="logout">
                                            <DropdownLink as="button">
                                                Cerrar sesión
                                            </DropdownLink>
                                        </form>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-mr-2 flex items-center sm:hidden">
                            <button
                                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition"
                                @click="showingNavigationDropdown = !showingNavigationDropdown">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path
                                        :class="{ 'hidden': showingNavigationDropdown, 'inline-flex': !showingNavigationDropdown }"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16" />
                                    <path
                                        :class="{ 'hidden': !showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{ 'block': showingNavigationDropdown, 'hidden': !showingNavigationDropdown }"
                    class="sm:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                            Dashboard
                        </ResponsiveNavLink>
                        <ResponsiveNavLink v-if="$page.props.user?.id != 9" :href="route('users')"
                            :active="route().current('users')">
                            Usuarios
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('employees')" :active="route().current('employees')">
                            Empleados
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('equipments')" :active="route().current('equipments')">
                            Equipos
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('phone-lines')" :active="route().current('phone-lines')">
                            Lineas
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('responsives')" :active="route().current('responsives')">
                            Responsivas
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('reports')" :active="route().current('reports')">
                            Reportes
                        </ResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="flex items-center px-4">
                            <div v-if="$page.props.jetstream?.managesProfilePhotos" class="shrink-0 mr-3">
                                <img class="h-10 w-10 rounded-full object-cover"
                                    :src="$page.props.user?.profile_photo_url" :alt="$page.props.user?.name">
                            </div>

                            <div>
                                <div class="font-medium text-base text-gray-800">
                                    {{ $page.props.user?.name }}
                                </div>
                                <div class="font-medium text-sm text-gray-500">
                                    {{ $page.props.user?.email }}
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('profile.show')" :active="route().current('profile.show')">
                                Perfil
                            </ResponsiveNavLink>

                            <ResponsiveNavLink v-if="$page.props.jetstream?.hasApiFeatures"
                                :href="route('api-tokens.index')" :active="route().current('api-tokens.index')">
                                API Tokens
                            </ResponsiveNavLink>

                            <!-- Authentication -->
                            <form method="POST" @submit.prevent="logout">
                                <ResponsiveNavLink as="button">
                                    Cerrar sesión
                                </ResponsiveNavLink>
                            </form>

                            <!-- Team Management -->
                            <!--template v-if="$page.props.jetstream.hasTeamFeatures"-->
                            <template v-if="false">
                                <div class="border-t border-gray-200" />

                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    Administrar equipo
                                </div>

                                <!-- Team Settings -->
                                <ResponsiveNavLink :href="route('teams.show', $page.props.user?.current_team)"
                                    :active="route().current('teams.show')">
                                    Ajustes de equipo
                                </ResponsiveNavLink>

                                <ResponsiveNavLink v-if="$page.props.jetstream?.canCreateTeams"
                                    :href="route('teams.create')" :active="route().current('teams.create')">
                                    Crear nuevo equipo
                                </ResponsiveNavLink>

                                <div class="border-t border-gray-200" />

                                <!-- Team Switcher -->
                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    Cambiar equipo
                                </div>

                                <template v-for="team in $page.props.user?.all_teams" :key="team.id">
                                    <form @submit.prevent="switchToTeam(team)">
                                        <ResponsiveNavLink as="button">
                                            <div class="flex items-center">
                                                <svg v-if="team.id == $page.props.user?.current_team_id"
                                                    class="mr-2 h-5 w-5 text-green-400" fill="none"
                                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <div>{{ team.name }}</div>
                                            </div>
                                        </ResponsiveNavLink>
                                    </form>
                                </template>
                            </template>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header v-if="$slots.header" class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot />
            </main>

            <Toast :show="isOpenToast" @close="closeToast" :data="$page.props.jetstream?.flash">
            </Toast>

        </div>
    </div>
</template>


<script>
import Toast from '@/Components/Toast.vue';

export default {
    components: {
        Toast
    },
    data() {
        return {
            isOpenToast: true,
        }
    },

    props: {
    },

    methods: {
        closeToast() {
            this.isOpenToast = false;
            console.log('cloang toast');
        },
    },

}

</script>
