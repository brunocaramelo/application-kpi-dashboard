<template>
  <a
    :href="href"
    :class="class"
    :id="id"
    @click="handleClick"
  >
    <slot></slot>
  </a>
</template>

<script setup>
    import { defineProps, defineEmits } from 'vue';

    const props = defineProps({
    href: {
        type: String,
        default: '#'
    },
    class: {
        type: String,
        default: ''
    },
    id: {
        type: String,
        default: ''
    }
    });

    const emit = defineEmits(['click']);

    const handleClick = (event) => {
    emit('click', event);
    };
</script>

<style scoped>
    /* Estilos opcionais para o componente */
    a {
    text-decoration: none;
    color: inherit;
    transition: all 0.3s ease;
    }

    a:hover {
    opacity: 0.8;
    }
</style>
