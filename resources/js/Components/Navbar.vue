<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue'
import Dropdown from '@/Components/Dropdown.vue'
import DropdownLink from '@/Components/DropdownLink.vue'
import { Link } from '@inertiajs/vue3'
import { Bars3CenterLeftIcon, CheckBadgeIcon, ChevronDownIcon, UserIcon } from "@heroicons/vue/24/solid"
import SwitchDarkModeNavbar from '@/Components/SwitchDarkModeNavbar.vue'
import SwitchLangNavbar from '@/Components/SwitchLangNavbar.vue'

const emit = defineEmits(["open"])
const version = '1.2.1'

const downloadExcel = () => { window.open('demco' , '_blank') }

</script>

<template>
    <nav
        class="bg-gray-900 border-gray-700 text-gray-300 lg:bg-white dark:bg-gray-900 border-b lg:border-gray-100 dark:border-gray-800 lg:text-gray-500 dark:text-gray-300">
        <!-- Primary Navigation Menu -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <!-- Hamburger -->
                    <div class="mr-4 shrink-0 flex items-center lg:hidden">
                        <button v-on:click="emit('open')"
                            class="hover:text-gray-400 hover:bg-gray-900 focus:bg-gray-900 focus:text-gray-400 inline-flex items-center justify-center p-2 rounded-md lg:hover:text-gray-500 dark:hover:text-gray-400 lg:hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none lg:focus:bg-gray-100 dark:focus:bg-gray-900 lg:focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                            <Bars3CenterLeftIcon class="h-5 w-5" />
                        </button>
                    </div>
                    <!-- Logo -->
                    <div class="flex">
                        <Link :href="route('dashboard')" class="flex items-center space-x-2">
                        <ApplicationLogo class="hidden md:block h-5 w-auto fill-current" />
                        <p>Area Comercial</p>
                        </Link>
                    </div>
                </div>
                <div class="flex items-center">
                    <!-- <SwitchLangNavbar /> -->
                    <div class="flex">
                        <Link :href="route('ActualizaGoogleManual')" class="flex items-center mx-3">
                        <p>Actualizar</p>
                        </Link>
                    </div>
                    <div class="flex mx-12">
                        <Link v-if="$page.props.auth.user.id === 1" :href="route('Actualizaot')" class="flex items-center mx-3">
                        <p>Actualizar OT</p>
                        </Link>
                    </div>
                    <SwitchDarkModeNavbar />
                    <div class="">
                        <!-- Settings Dropdown -->
                        <div class="relative">
                            <Dropdown align="right" width="48">
                                <template #trigger>
                                    <span class="inline-flex rounded-md">
                                        <button type="button"
                                            class="hover:text-gray-400 hover:bg-gray-900 focus:bg-gray-900 focus:text-gray-400 inline-flex items-center justify-center p-2 rounded-md lg:hover:text-gray-500 dark:hover:text-gray-400 lg:hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none lg:focus:bg-gray-100 dark:focus:bg-gray-900 lg:focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out sm:hidden">
                                            <UserIcon class="h-5 w-5" />
                                        </button>
                                        <button type="button"
                                            class="hover:text-gray-400 hover:bg-gray-900 focus:bg-gray-900 focus:text-gray-400 items-center justify-center p-2 rounded-md lg:hover:text-gray-500 dark:hover:text-gray-400 lg:hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none lg:focus:bg-gray-100 dark:focus:bg-gray-900 lg:focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out truncate w-fit hidden sm:inline-flex">
                                            <span class="flex justify-between items-center">
                                                {{ $page.props.auth.user.name.split(' ')[0] }}
                                                <CheckBadgeIcon class="ml-[2px] w-4 h-4 text-white dark:text-white lg:text-primary"
                                                    v-show="$page.props.auth.user.email_verified_at" />
                                            </span>
                                            <span v-show="$page.props.auth.user.email_verified_at" class="flex items-center justify-start text-sm truncate">
                                                {{ version }}
                                            </span>
                                            <ChevronDownIcon class="ml-2 h-5 w-5 fill-current" />
                                        </button>
                                    </span>
                                </template>

                                <template #content>
                                    <div
                                        class="py-3 px-4 border-b border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-300">
                                        <span class="flex items-center justify-start text-sm truncate">
                                            {{ $page.props.auth.user.name }}
                                            <CheckBadgeIcon class="ml-[2px] w-4 h-4 dark:text-white text-primary"
                                                v-show="$page.props.auth.user.email_verified_at" />
                                        </span>

                                        <span class="block text-sm font-medium text-gray-500 truncate dark:text-gray-400">
                                            {{ $page.props.auth.user.email }}
                                        </span>
                                        <!-- <span class="block text-sm font-medium text-gray-500 truncate dark:text-gray-400">
                                            {{ $page.props.auth.user.id }}
                                        </span> -->
                                    </div>
                                    <DropdownLink :href="route('profile.edit')"> {{ lang().label.profile }}
                                    </DropdownLink>
                                    <form @submit.prevent="downloadExcel" id="downloadReporte" v-if="can(['create user'])" class="hover:bg-gray-100">
                                            <button class="mx-4 my-2" type="submit">
                                                Base de datos
                                            </button>
                                    </form>
                                    <DropdownLink :href="route('logout')" method="post" as="button">
                                        {{ lang().label.logout }}
                                    </DropdownLink>
                                </template>
                            </Dropdown>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</template>
