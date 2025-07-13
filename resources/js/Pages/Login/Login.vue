<template>
    <GuestLayout>

        <form @submit.prevent="submitForm">
            <div>
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="email"
                    required
                    autofocus
                    name="email"
                />

             </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="password"
                    required
                    name="password"
                    autocomplete="current-password"
                />

           </div>

            <div class="flex items-center justify-end mt-4">
                <PrimaryButton class="ms-4" :class="{ 'opacity-25': processing }" :disabled="processing">
                    Log in
                </PrimaryButton>
            </div>
        </form>
        <div style="margin: 10px 0;padding: 4px" v-if="messageError" class="p-invalid">{{ messageError }}</div>
    </GuestLayout>
</template>

<script setup>
    import GuestLayout from '@/Layouts/GuestLayout.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import TextInput from '@/Components/TextInput.vue';
    import { ref } from 'vue';
    import { useRouter } from 'vue-router';
    import axios from 'axios';

    const processing = ref(false);
    const email = ref('');
    const password = ref('');
    const messageError = ref('');

    const router = useRouter();

    const submitForm = () => {

        processing.value = true;
        messageError.value = null;

        axios.post('/api/login', {
            email: email.value,
            password: password.value
        }).then(response => {

            localStorage.setItem('APP_USER_TOKEN', response.data.access_token);

            router.push('/home');

        }).catch(error => {
            const responseApi = error.response.data;

            messageError.value = responseApi.message;

            if (responseApi.errors) {
                for (const [key, value] of Object.entries(responseApi.errors)) {
                    document.querySelector(`[name=${key}]`)
                            ?.classList.add("p-invalid");
                }
            }
        }).finally(() => {
            processing.value = false;
        });
    };
</script>


<style scooped>
    .p-invalid{
        border: 2px solid rgba(243, 66, 66, 0.5) !important;
        color: red;
    }

</style>
