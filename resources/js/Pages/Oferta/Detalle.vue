<script setup  type="module">
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import {reactive, watchEffect} from 'vue';

const props = defineProps({
    show: Boolean,
    title: String,
    eldetalle: Object,
    maintitle: String,
})

const emit = defineEmits(["close"]);
const data = reactive({
    mostrarGeneral: 0,
})

watchEffect(() => {
    if (props.show) {
        if (!props.eldetalle?.length)
            data.mostrarGeneral = 0
    }
})
</script>

<template>
    <section class="space-y-6">
        <Modal :show="props.show" @close="emit('close')" :maxWidth="'xl8'">
            

        </Modal>
    </section>
</template>
