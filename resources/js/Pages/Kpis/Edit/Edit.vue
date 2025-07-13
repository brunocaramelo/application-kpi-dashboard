<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import EditForm from './Parts/EditForm.vue';


</script>

<template>
    <AuthenticatedLayout>
        <Head title="Update Task" />
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <EditForm
                            :kpi="kpi"
                        />
                </div>
            </div>
        </div>
    </div>
    </AuthenticatedLayout>
</template>
