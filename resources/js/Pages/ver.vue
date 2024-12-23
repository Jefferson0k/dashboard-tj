<template>
    <div class="card flex justify-center">
        <Button label="Show" @click="visible = true" />
        <Dialog v-model:visible="visible" maximizable modal header="Header" :style="{ width: '50rem' }" :breakpoints="{ '1199px': '75vw', '575px': '90vw' }">
            
        </Dialog>
    </div>
</template>

<script setup>
import { ref } from "vue";
import Dialog from 'primevue/dialog';

const visible = ref(false);
</script>