<script setup>
import { ref } from 'vue';
import NavbarVue from '@/Components/Navbar.vue';
import SideBarVue from "@/Components/SideBar.vue";
import Toast from '@/Components/Toast.vue';
import Footer from '@/Components/Footer.vue';
import { usePage } from '@inertiajs/vue3';

const page = usePage();
const flash = page.props.flash;
const sidebarOpened = ref(false);
const emit = defineEmits(['close', 'open']);
</script>

<template>
    <div class="flex w-full overflow-hidden">
        <SideBarVue :open="sidebarOpened" @close="sidebarOpened = false" />
        <div class="pl-0 lg:pl-64 w-full min-h-screen block bg-gray-100 dark:bg-gray-900">
<!--            <Toast :flash="flash" />-->
            <Toast :flash="$page.props.flash" />
            <NavbarVue :open="sidebarOpened" @open="sidebarOpened = true" />
            
            
            <!-- Page Content -->
            <main class="max-w-8xl mx-auto sm:px-6 lg:px-8 pb-10 text-gray-900 dark:text-gray-100 dark:bg-gray-900 text-md">
                <slot />
            </main>
<!--            <Footer />-->
        </div>
    </div>
</template>
