<template>
    <AuthenticatedLayout>
        <div class="w-4/5 mx-auto">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"></div>
                <div v-if="reactiveKpiList.length > 0">
                            <div v-for="typeGroup in reactiveKpiList" :key="typeGroup.type_id" class="mb-8">
                                <h3 class="text-2xl font-bold text-gray-800 mb-4">{{ typeGroup.type_name }}</h3>
                                <div v-if="typeGroup.kpis && typeGroup.kpis.length > 0" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                                    <div v-for="kpi in typeGroup.kpis" :key="kpi.id" class="bg-white rounded-lg shadow-md p-5 border border-gray-200 hover:shadow-lg transition-shadow duration-300">
                                        <h4 class="text-xl font-semibold text-gray-900 mb-2 truncate" :title="kpi.titulo">{{ kpi.titulo }}</h4>
                                        <p class="text-gray-700 text-lg mb-1">
                                            <span class="font-medium">Valor:</span> {{ formatCurrency(kpi.valor) }}
                                        </p>
                                        <p :class="[
                                            'text-lg mb-3',
                                            kpi.variacao_percentual >= 0 ? 'text-green-600' : 'text-red-600'
                                        ]">
                                            <span class="font-medium text-gray-700">Variação:</span> {{ formatPercentage(kpi.variacao_percentual) }}
                                            <span v-if="kpi.variacao_percentual >= 0">▲</span>
                                            <span v-else>▼</span>
                                        </p>
                                        <p class="text-gray-700 text-lg mb-1">
                                            <span class="font-medium">Criado em:</span> {{ formatToBrazilianDateTimeMoment(kpi.created_at) }}
                                        </p>
                                        </div>
                                </div>
                                <p v-else class="text-gray-600 italic">Nenhum KPI encontrado para este tipo.</p>
                            </div>
                        </div>
                        <div v-else class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center text-gray-600">
                            <p>Carregando KPIs ou nenhum KPI encontrado.</p>
                        </div>
            </div>
    </AuthenticatedLayout>
    <Toast />
</template>

<script lang="ts" setup>
    import { ref, onMounted, onUnmounted } from 'vue';
    import { useRouter } from 'vue-router';
    import axios from 'axios';
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { useToast } from 'primevue/usetoast';
    import Toast from 'primevue/toast';
    import moment from 'moment';
    import 'moment/locale/pt-br';

    const router = useRouter();
    const reactiveKpiList = ref([]);
    const toast = useToast();

    let autoReloadInterval: ReturnType<typeof setInterval> | null = null;

    async function getLastItemsByType(typeId: number) {
        try {
            const returnApi = await axios.get('/api/kpis', {
                params: {
                    type_id: typeId,
                    per_page: 4,
                },
                headers: {
                    Authorization: "Bearer " + localStorage.getItem('APP_USER_TOKEN')
                }
            });
            return returnApi.data;
        } catch (error) {
            console.error(`Erro ao buscar itens para o tipo ${typeId}:`, error);
            return { data: [] };
        }
    }

    async function getTypes() {
        try {
            const returnApi = await axios.get('/api/kpis/types', {
                headers: {
                    Authorization: "Bearer " + localStorage.getItem('APP_USER_TOKEN')
                }
            });
            return returnApi.data.data || returnApi.data;
        } catch (error) {
            console.error('Erro ao buscar tipos de KPI:', error);
            return [];
        }
    }

    const formatToBrazilianDateTimeMoment = (dateString) => {
        if (!dateString) return '';
        return moment(dateString).locale('pt-br').format('DD/MM/YYYY HH:mm:ss');
    }

    const formatCurrency = (value: number | string | null | undefined) => {
        if (value === null || value === undefined || value === '') return 'R$ 0,00';
        const numberValue = parseFloat(value as string);
        if (isNaN(numberValue)) return 'R$ 0,00';
        return numberValue.toLocaleString('pt-BR', {
            style: 'currency',
            currency: 'BRL',
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
        });
    };

    const formatPercentage = (value: number | string | null | undefined) => {
        if (value === null || value === undefined || value === '') return '0,00%';
        const numberValue = parseFloat(value as string);
        if (isNaN(numberValue)) return '0,00%';
        return numberValue.toLocaleString('pt-BR', {
            style: 'decimal',
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
        }) + '%';
    };

    async function setListOfKpisLimited() {
            const currentToken = localStorage.getItem('APP_USER_TOKEN');

            const typesList = await getTypes();

            const fetchPromises = typesList.map(async (type: { id: number; name: string }) => {
                const kpisData = await getLastItemsByType(type.id);
                return {
                    type_id: type.id,
                    type_name: type.name,
                    kpis: kpisData.data || kpisData
                };
            });
            reactiveKpiList.value = await Promise.all(fetchPromises);
    }

    onMounted(() => {
        setListOfKpisLimited();

        autoReloadInterval = setInterval(() => {

            setListOfKpisLimited();

            toast.add({
                severity: 'success',
                summary: 'Autocarregamento',
                detail: 'Lista Recarregada com sucesso',
                life: 3000
            });

        }, 30 * 1000);
    });

    onUnmounted(() => {
        if (autoReloadInterval) {
            clearInterval(autoReloadInterval);
            autoReloadInterval = null;
            console.log('Autocarregamento parado.');
        }
    });

</script>
