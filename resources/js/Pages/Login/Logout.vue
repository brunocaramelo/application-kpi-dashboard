<template>
</template>

<script setup>

    import { useRouter } from 'vue-router';
    import { onMounted } from 'vue';

    const router = useRouter();

    onMounted(async () => {

        localStorage.removeItem('APP_USER_TOKEN');

        router.push('/login');
    });


</script>


<style scooped>
    .p-invalid{
        border: 2px solid rgba(243, 66, 66, 0.5) !important;
        color: red;
    }

</style>
