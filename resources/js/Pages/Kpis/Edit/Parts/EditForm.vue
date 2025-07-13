<template>
            <div class="row">
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <InputLabel for="titulo" value="Titulo" />

                        <TextInput
                            id="title"
                            type="text"
                            class="mt-1 block w-full
                            bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5"
                            v-model="formUpdateStore.dataToSend.titulo"
                            required
                            autofocus
                            autocomplete="titulo"
                        />
                        <InputError class="mt-2" :message="formUpdateStore.errorsResponse?.titulo" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="kpi_type_id" value="Tipo" />
                        <select v-model="formUpdateStore.dataToSend.kpi_type_id" id="kpi_type_id" class="g-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                            <option value="" disabled>Selecione um tipo</option>
                            <option v-for="tipo in formUpdateStore.typesKpi" :key="tipo.id" :value="tipo.id">
                                {{ tipo.name }}
                            </option>
                        </select>
                        <InputError class="mt-2" :message="formUpdateStore.errorsResponse?.kpi_type_id" />
                    </div>


                    <div>
                        <InputLabel for="valor" value="Valor" />

                        <TextInput
                            id="title"
                            type="text"
                            class="mt-1 block w-full
                            bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5"                            v-model="formattedValorBrl"
                            required
                            autofocus
                            autocomplete="valor"
                        />
                        <InputError class="mt-2" :message="formUpdateStore.errorsResponse?.valor" />
                    </div>

                    <div>
                        <InputLabel for="variacao_percentual" value="Variação Percentual" />

                        <TextInput
                            id="title"
                            type="text"
                            class="mt-1 block w-full
                            bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5"
                            v-model="formattedVariacaoPercentualBrl"
                            required
                            autofocus
                            autocomplete="variacao_percentual"
                        />
                        <InputError class="mt-2" :message="formUpdateStore.errorsResponse?.variacao_percentual" />
                    </div>
            </div>
        </div>
        <div class="row">
            <div class="flex items-center justify-end mt-4">
                <PrimaryButton class="ms-4 border-black"
                    :disabled="formUpdateStore.processing"
                    @click="formUpdateStore.onSubmit()"
                >
                    Enviar
                </PrimaryButton>
            </div>
        </div>
    <Toast />
</template>


<script setup>
    import { watch} from 'vue'
    import InputLabel from '@/Components/InputLabel.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import TextInput from '@/Components/TextInput.vue';
    import InputError from '@/Components/InputError.vue';
    import { useUpdateKpiStore } from '../../../../States/useUpdateKpiStore';
    import { useToast } from 'primevue/usetoast';
    import { ref, computed, onMounted } from 'vue';
    import { useRoute, useRouter } from 'vue-router';
    import Toast from 'primevue/toast';

    const toast = useToast();
    const router = useRouter();
    const route = useRoute();

    const formUpdateStore = useUpdateKpiStore();

    const currentToken = localStorage.getItem('APP_USER_TOKEN');

    onMounted(async () => {

        const kpiId = route.params.kpiId;

        formUpdateStore.setToken(currentToken);
        formUpdateStore.setRoute('/api/kpis/'+kpiId);
        formUpdateStore.loadTypes();

        const responseItem = await axios.get('/api/kpis/'+kpiId, {
          headers: {
            'Authorization': `Bearer ${currentToken}`
          }
        });

        responseItem.data.valor = parseFloat(responseItem.data.valor)
        responseItem.data.variacao_percentual = parseFloat(responseItem.data.variacao_percentual)

        formUpdateStore.setDataToSend(responseItem.data);
    });

    watch( () => formUpdateStore.responseSuccess, (newValue) => {
            if (newValue) {
                toast.add({
                    severity: 'success',
                    summary: 'KPI Alterado com Sucesso',
                    detail: 'KPI  ['+newValue.id+'] Alterado!..Redirecionando',
                    life: 3000
                });

                setTimeout(() => {
                    router.push({path: '/kpis'});
                }, "2000");
            }
        },
        { deep: true }
    );

    const formattedValorBrl = computed({
        get() {
            const value = formUpdateStore.dataToSend.valor;
            if (value === null || value === undefined || value === '') {
                return '';
            }
            const numberValue = parseFloat(value);
            if (isNaN(numberValue)) {
                return '';
            }

            return numberValue.toLocaleString('pt-BR', {
                style: 'currency',
                currency: 'BRL',
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
            });
        },
        set(newValue) {
            let digitsOnly = newValue.replace(/\D/g, '');

            if (!digitsOnly) {
                formUpdateStore.dataToSend.valor = null;
                return;
            }

            let numberValue = parseInt(digitsOnly, 10);

            if (isNaN(numberValue)) {
                formUpdateStore.dataToSend.valor = null;
                return;
            }
                numberValue /= 100;

                formUpdateStore.dataToSend.valor = numberValue;
        }
    });

    const formattedVariacaoPercentualBrl = computed({
        get() {
            const value = formUpdateStore.dataToSend.variacao_percentual;
            if (value === null || value === undefined || value === '') {
                return '';
            }
            const numberValue = parseFloat(value);
            if (isNaN(numberValue)) {
                return '';
            }

            return numberValue.toLocaleString('en-US', {
                style: 'decimal',
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
            });
        },
        set(newValue) {
            let cleanValue = newValue.replace(/[^\d.]/g, '');
            const parts = cleanValue.split('.');
            if (parts.length > 2) {
                cleanValue = parts[0] + '.' + parts.slice(1).join('');
            }

            let digitsOnly = cleanValue.replace(/\D/g, '');

            if (!digitsOnly) {
                formUpdateStore.dataToSend.variacao_percentual = null;
                return;
            }

            let numberValue = parseInt(digitsOnly, 10);

            if (isNaN(numberValue)) {
                formUpdateStore.dataToSend.variacao_percentual = null;
                return;
            }

            numberValue /= 100;
            formUpdateStore.dataToSend.variacao_percentual = numberValue;
        }
    });


</script>

