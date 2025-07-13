<template>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard KPIs</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <span class="flex flex-col lg:items-start">
                        <div class="relative w-50 lg:w-[500px] md:w-full">
                            <div class="grid grid-cols-3 gap-3">
                                <input type="text" v-model="searchStore.searchParams.titulo" @blur="searchStore.onSearch()"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Titulo...">
                                <select v-model="searchStore.searchParams.type_id" @change="searchStore.onSearch()" class="g-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                                    <option value="">Selecione o tipo</option>
                                    <option v-for="tipo in searchStore.typesKpi" :key="tipo.id" :value="tipo.id">{{tipo.name}}</option>
                                </select>
                            </div>
                        </div>
                    </span>
                </div>

                <div class="overflow-x-auto shadow-xs sm:rounded-lg mt-5 px-2">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-lg">
                            <tr>
                                <th scope="col" class="px-5 py-3">Id</th>
                                <th scope="col" class="px-5 py-3 text-center">Titulo</th>
                                <th scope="col" class="px-5 py-3 text-center">Tipo KPI</th>
                                <th scope="col" class="px-5 py-3 text-center">Valor</th>
                                <th scope="col" class="px-5 py-3 text-center">Variacao Percentual</th>
                                <th scope="col" class="px-5 py-3 text-center">Data de criação</th>
                                <th scope="col" class="px-5 py-3 mx-2 text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-if="searchStore.results && searchStore.results.data.length > 0">
                                <tr v-for="item in searchStore.results.data" :key="item.id" class="bg-white hover:bg-gray-50">
                                    <td class="text-center font-medium text-lg text-zinc-700">{{ item.id }}</td>
                                    <td class="text-center font-medium text-lg text-zinc-700">{{ item.titulo }}</td>
                                    <td class="text-center font-medium text-lg text-zinc-700">{{ item.type ? item.type.name : 'N/A' }}</td>
                                    <td class="text-center font-medium text-lg text-zinc-700">R$ {{ item.valor }}</td>
                                    <td class="text-center font-medium text-lg text-zinc-700"><p :class="[
                                        'text-lg mb-3',
                                        item.variacao_percentual >= 0 ? 'text-green-600' : 'text-red-600'
                                    ]">{{ item.variacao_percentual }}
                                    <span v-if="item.variacao_percentual >= 0">▲</span>
                                    <span v-else>▼</span>
                                </p></td>
                                <td class="text-center font-medium text-lg text-zinc-700">{{ formatToBrazilianDateTimeMoment(item.created_at) }}</td>
                                <td class="text-center font-medium w-46 text-sm ml-2 text-zinc-70">
                                    <a @click="gotoEditItem(item.id)" class="cursor-pointer">
                                        <img src="https://unpkg.com/lucide-static@latest/icons/pencil.svg" alt="Edit" class="inline-block w-5 h-5">
                                    </a>
                                </td>
                                </tr>
                            </template>
                            <tr v-else>
                                <td colspan="6" class="text-center py-4 text-gray-600">Nenhum KPI encontrado.</td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="border-t mb-3 pt-3" v-if="searchStore.results && searchStore.results.data.length > 0">
                        <Pagination
                            :data="searchStore.results"
                            class="mt-5 text-right"
                            @page-clicked="handlePageChange"
                        >
                        </Pagination>
                    </div>
                </div>
            </div>
        </div>

        <div class="fixed bottom-4 right-4">
            <a @click="gotoNewItem()" class="cursor-pointer bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-full shadow-lg p-6 transition-colors duration-300 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus-circle">
                    <circle cx="12" cy="12" r="10"/><path d="M8 12h8"/><path d="M12 8v8"/>
                </svg>
            </a>
        </div>
        <Toast />

    </AuthenticatedLayout>
</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { onMounted, onUnmounted, ref } from 'vue';
    import { useSearchStore } from '../../../States/useSearchStore';
    import { useRouter } from 'vue-router';
    import Pagination from '@/Components/Pagination.vue';
    import { useToast } from 'primevue/usetoast';
    import Toast from 'primevue/toast';
    import moment from 'moment';
    import 'moment/locale/pt-br';

    const router = useRouter();
    const typesKpis = ref([]);

    const searchStore = useSearchStore();
    const toast = useToast();

    let intervalId = null;

    const handlePageChange = async (url) => {
        await searchStore.setRoute(url);
        await searchStore.onSearch();
    };

    const formatToBrazilianDateTimeMoment = (dateString) => {
        if (!dateString) return '';
        return moment(dateString).locale('pt-br').format('DD/MM/YYYY HH:mm:ss');
    }

    const startAutoReload = () => {
        if (intervalId) {
            clearInterval(intervalId);
        }

        intervalId = setInterval(async () => {

            await searchStore.onSearch();

            toast.add({
                severity: 'success',
                summary: 'Autocarregamento a cada 30 segundos',
                detail: 'Lista Recarregada com sucesso',
                life: 3000
            });

        }, 30 * 1000);
    };

    const stopAutoReload = () => {
        if (intervalId) {
            clearInterval(intervalId);
            intervalId = null;
        }
    };

    onMounted(async () => {
        const currentToken = localStorage.getItem('APP_USER_TOKEN');

        searchStore.setToken(currentToken);
        searchStore.setRoute('/api/kpis');

        await searchStore.loadTypes();

        await searchStore.onSearch();

        startAutoReload();
    });

     onUnmounted(() => {
        stopAutoReload();
    });

    const gotoEditItem = (id) => {
        router.push({path: '/kpis/'+id});
    }

    const gotoNewItem = () => {
        router.push({path: '/kpis/novo'});
    }
</script>
