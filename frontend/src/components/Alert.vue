<script setup>
import { FwbAlert } from 'flowbite-vue'
import { useAlert } from '@/composables/useAlert';

const { isVisible, message, type, closeAlert } = useAlert();
</script>

<template>
    <Transition name="slide">
        <div v-if="isVisible" class="alert-fixed-container">
            <fwb-alert :type="type" icon closable @close="closeAlert">
                {{ message }}
            </fwb-alert>
        </div>
    </Transition>
</template>

<style scoped>
/* Positionne l'alerte Flowbite proprement en haut à droite de l'écran */
.alert-fixed-container {
    position: fixed;
    top: 1.5rem;
    right: 1.5rem;
    z-index: 9999;
    width: 100%;
    max-width: 24rem;
}

/* Animation fluide de glissement */
.slide-enter-active,
.slide-leave-active {
    transition: all 0.3s ease;
}

.slide-enter-from {
    transform: translateX(100%);
    opacity: 0;
}

.slide-leave-to {
    transform: translateY(-10px);
    opacity: 0;
}
</style>