<script setup>
import {
    HomeIcon,
    UserIcon,
    CheckBadgeIcon,
    KeyIcon,
    ShieldCheckIcon,
    ClockIcon,
    PresentationChartLineIcon,
    BanknotesIcon,
} from "@heroicons/vue/24/solid";
import { Link } from '@inertiajs/vue3';
import { reactive, watch } from 'vue';

const data = reactive({
    showContent: false,
    showContent2: true,
    showContent3: false,
    showContent4: true,
})
const toggleContent = () => data.showContent = !data.showContent
const toggleContent2 = () => data.showContent2 = !data.showContent2
const toggleContent3 = () => data.showContent3 = !data.showContent3
const toggleContent4 = () => data.showContent4 = !data.showContent4

const sidebarButtons = [ //SAME AS WEB.PHP
    'reporte',
];
const sidebarButtonsAdmin = [ //SAME AS WEB.PHP
    // 'ordentrabajo',
    'centrotrabajo',
    'actividad',
    'disponibilidad',
    'reproceso',
    
];
const sidebar2 = [ //SAME AS WEB.PHP
	'Proveedor',
	// 'Item',
];
const sidebar3 = [ 
	'Equipo',
	'Oferta',
	//aquipuesSide
];

</script>
<template>
    <div class="text-gray-300 pt-5 pb-20">
        <div class="flex justify-center">
            <div
                class="rounded-full flex items-center justify-center bg-primary text-gray-300 w-12 h-12 text-4xl uppercase">
                <!-- imagen del nombre -->
                {{ $page.props.auth.user.name.match(/(^\S\S?|\b\S)?/g).join("").match(/(^\S|\S$)?/g).join("") }}
            </div>
        </div>
        <div class="text-center py-3 px-4 border-b border-gray-700 dark:border-gray-800">
            <span class="flex items-center justify-center">
                <p class="truncate text-md">{{ $page.props.auth.user.name }}</p>
                <div>
                    <CheckBadgeIcon class="ml-[2px] w-4 h-4" v-show="$page.props.auth.user.email_verified_at" />
                </div>
            </span>
            <span class="block text-xs font-medium truncate">{{ $page.props.auth.user.email }}</span>
            <span class="block text-sm font-medium truncate">{{ $page.props.auth.user.roles[0].name }}</span>
        </div>


        <ul class="space-y-2 my-4">
            <li class="bg-gray-700/40 dark:bg-gray-800/40 text-white rounded-lg hover:bg-primary dark:hover:bg-primary"
                :class="{ 'bg-sky-600 dark:bg-sky-600': route().current('dashboard') }">
                <Link :href="route('dashboard')" class="flex items-center py-2 px-4">
                <HomeIcon class="w-6 h-5" />
                <span class="ml-3">Tablero principal</span>
                </Link>
            </li>
            <!-- <li v-show="can(['read user'])" class="py-2"> <p>{{ lang().label.data }}</p> </li> -->
            <!-- <li v-show="can(['read role', 'read permission'])" class="py-2"> <p>{{ lang().label.access }}</p> </li> -->

            <li v-show="can(['read user'])"
                class="bg-gray-700/40 dark:bg-gray-800/40 text-white rounded-lg hover:bg-primary dark:hover:bg-primary"
                :class="{ 'bg-sky-600 dark:bg-sky-600': route().current('user.index') }">
                <Link :href="route('user.index')" class="flex items-center py-2 px-4">
                <UserIcon class="w-6 h-5" />
                <span class="ml-3">{{ lang().label.user }}</span>
                </Link>
            </li>
            <button v-show="can(['isAdmin'])" @click="toggleContent" class="text-blue-500">
                {{ data.showContent ? 'Ocultar roles' : 'Mostrar roles' }}
            </button>

            <li v-if="data.showContent" v-show="can(['isAdmin'])"
                class="bg-gray-700/40 dark:bg-gray-800/40 text-white rounded-lg hover:bg-primary dark:hover:bg-primary"
                :class="{ 'bg-sky-600 dark:bg-sky-600': route().current('role.index') }">
                <Link :href="route('role.index')" class="flex items-center py-2 px-4">
                <KeyIcon class="w-6 h-5" />
                <span class="ml-3">{{ lang().label.role }}</span>
                </Link>
            </li>
            <li v-if="data.showContent" v-show="can(['isSuper'])"
                class="bg-gray-700/40 dark:bg-gray-800/40 text-white rounded-lg hover:bg-primary dark:hover:bg-primary"
                :class="{ 'bg-sky-600 dark:bg-sky-600': route().current('permission.index') }">
                <Link :href="route('permission.index')" class="flex items-center py-2 px-4">
                <ShieldCheckIcon class="w-6 h-5" />
                <span class="ml-3">{{ lang().label.permission }}</span>
                </Link>
            </li>


            <!-- zone parametros -->
            <!-- <li v-show="can(['isAdmin'])" class="py-2"> <p>Parametros</p> </li> -->
            <!-- <li v-if="data.showContent" v-show="can(['isAdmin'])"
                class="bg-gray-700/40 dark:bg-gray-800/40 text-white rounded-lg hover:bg-primary dark:hover:bg-primary"
                :class="{ 'bg-sky-600 dark:bg-sky-600': route().current('parametro.index') }">
                <Link :href="route('parametro.index')" class="flex items-center py-2 px-4">
                <PresentationChartLineIcon class="w-6 h-5" />
                <span class="ml-3">{{ lang().label.parametros }}</span>
                </Link>
            </li> -->


            <!-- zone normal -->
        </ul>
        <ul class="space-y-2 my-4">
        
        <button @click="toggleContent2" v-show="can(['isAdmin'])" class="text-blue-500">{{ data.showContent2 ? 'Ocultar' : 'Mostrar' }}</button>
        <ul v-if="data.showContent2" class="space-y-2 my-4">
            <div class="" v-for="value in sidebarButtons">
                <li v-show="can(['istrabajador','issupervisor'])"
                    class="bg-gray-700/40 dark:bg-gray-800/40 text-white rounded-lg hover:bg-primary dark:hover:bg-primary"
                    :class="{ 'bg-blue-700 dark:bg-blue-700': route().current(value+'.index') }">
                    <Link :href="route(value+'.index')" class="flex items-center py-1 px-4">
                        <PresentationChartLineIcon class="w-6 h-5" />
                        <span class="ml-3">{{ lang().label[value] }}</span>
                    </Link>
                </li>
            </div>
        </ul>
        </ul>
        <ul v-if="data.showContent2" v-show="can((['isAdmin']))" class="space-y-2 my-4">
            <div class="" v-for="value in sidebarButtonsAdmin">
                <li v-show="can(['istrabajador'])"
                    class="bg-gray-700/40 dark:bg-gray-800/40 text-white rounded-lg hover:bg-primary dark:hover:bg-primary"
                    :class="{ 'bg-blue-700 dark:bg-blue-700': route().current(value+'.index') }">
                    <Link :href="route(value+'.index')" class="flex items-center py-1 px-4">
                        <PresentationChartLineIcon class="w-6 h-5" />
                        <span class="ml-3">{{ lang().label[value] }}</span>
                    </Link>
                </li>
            </div>
        </ul>
        
        <button @click="toggleContent3" v-show="true" class="text-blue-500">{{ data.showContent3 ? 'Ocultar Items' : 'Mostrar Items' }}</button>
        <ul v-show="can((['isAdmin'])) && data.showContent3" class="space-y-2 my-4">
            <div class="" v-for="value in sidebar2">
                <li v-show="can(['isAdmin'])"
                    class="bg-gray-700/40 dark:bg-gray-800/40 text-white rounded-lg hover:bg-primary dark:hover:bg-primary"
                    :class="{ 'bg-blue-700 dark:bg-blue-700': route().current(value+'.index') }">
                    <Link :href="route(value+'.index')" class="flex items-center py-1 px-4">
                        <PresentationChartLineIcon class="w-6 h-5" />
                        <span class="ml-3">{{ lang().label[value] }}</span>
                    </Link>
                </li>
            </div>
        </ul>
        <div class="block my-1"></div>
        <button @click="toggleContent4" v-show="true" class="text-blue-500">{{ data.showContent4 ? 'Equipos y Ofertas' : 'Mostrar ofertas' }}</button>
        <ul v-show="can((['isAdmin'])) && data.showContent4" class="space-y-2 my-4">
            <div class="" v-for="value in sidebar3">
                <li v-show="can(['isAdmin'])"
                    class="bg-gray-700/40 dark:bg-gray-800/40 text-white rounded-lg hover:bg-primary dark:hover:bg-primary"
                    :class="{ 'bg-blue-700 dark:bg-blue-700': route().current(value+'.index') }">
                    <Link :href="route(value+'.index')" class="flex items-center py-1 px-4">
                        <PresentationChartLineIcon class="w-6 h-5" />
                        <span class="ml-3">{{ lang().label[value] }}</span>
                    </Link>
                </li>
            </div>
        </ul>
    </div></template>
