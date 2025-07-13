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
                            v-model="formCreateStore.dataToSend.titulo"
                            required
                            autofocus
                            autocomplete="titulo"
                        />
                        <InputError class="mt-2" :message="formCreateStore.errorsResponse?.titulo" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="kpi_type_id" value="Tipo" />
                        <select v-model="formCreateStore.dataToSend.kpi_type_id" id="kpi_type_id" class="g-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                            <option value="" disabled>Selecione um tipo</option>
                            <option v-for="tipo in formCreateStore.typesKpi" :key="tipo.id" :value="tipo.id">
                                {{ tipo.name }}
                            </option>
                        </select>
                        <InputError class="mt-2" :message="formCreateStore.errorsResponse?.kpi_type_id" />
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
                        <InputError class="mt-2" :message="formCreateStore.errorsResponse?.valor" />
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
                        <InputError class="mt-2" :message="formCreateStore.errorsResponse?.variacao_percentual" />
                    </div>
            </div>
        </div>
        <div class="row">
            <div class="flex items-center justify-end mt-4">
                <PrimaryButton class="ms-4 border-black"
                    :disabled="formCreateStore.processing"
                    @click="formCreateStore.onSubmit()"
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
    import { useCreateStoreStore } from '../../../../States/useCreateKpiStore';
    import { useToast } from 'primevue/usetoast';
    import { ref, computed } from 'vue';
    import { useRouter } from 'vue-router';
    import Toast from 'primevue/toast';

    const toast = useToast();
    const router = useRouter();

    const formCreateStore = useCreateStoreStore();

    const currentToken = localStorage.getItem('APP_USER_TOKEN');

    formCreateStore.setToken(currentToken);
    formCreateStore.setRoute('/api/kpis');
    formCreateStore.loadTypes();

    watch( () => formCreateStore.responseSuccess, (newValue) => {
            if (newValue) {
                toast.add({
                    severity: 'success',
                    summary: 'KPI Criado com Sucesso',
                    detail: 'KPI  ['+newValue.id+'] Criado!..Redirecionando',
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
            const value = formCreateStore.dataToSend.valor;
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
                formCreateStore.dataToSend.valor = null;
                return;
            }

            let numberValue = parseInt(digitsOnly, 10);

            if (isNaN(numberValue)) {
                formCreateStore.dataToSend.valor = null;
                return;
            }
                numberValue /= 100;

                formCreateStore.dataToSend.valor = numberValue;
        }
    });

    const formattedVariacaoPercentualBrl = computed({
        get() {
            const value = formCreateStore.dataToSend.variacao_percentual;
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
                formCreateStore.dataToSend.variacao_percentual = null;
                return;
            }

            let numberValue = parseInt(digitsOnly, 10);

            if (isNaN(numberValue)) {
                formCreateStore.dataToSend.variacao_percentual = null;
                return;
            }

            numberValue /= 100;
            formCreateStore.dataToSend.variacao_percentual = numberValue;
        }
    });


</script>
