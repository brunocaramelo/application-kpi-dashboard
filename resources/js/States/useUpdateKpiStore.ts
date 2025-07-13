import { defineStore } from 'pinia'
import { z } from 'zod';
import axios from 'axios';

export const useUpdateKpiStore = defineStore('updateKpi', {
 state: () => ({
    processing: false,
    dataToSend: {
      titulo: null,
      valor: null,
      variacao_percentual: null,
      kpi_type_id: null,
    },
    responseSuccess: null,
    errorsResponse: [],
    routeSuccess: '',
    routeName: '',
    token: '',
    typesKpi: [],
  }),

  actions: {
    dataSchemaValidator() {
      return z.object({
        titulo: z.string({invalid_type_error: 'O Título deve ser preenchido.',
        }).min(5, 'O Título deve ter pelo menos 5 caracteres.'),
        valor: z.number({ invalid_type_error: 'O Valor deve ser preenchido.' }),
        variacao_percentual: z.number({ invalid_type_error: 'A Variação Percentual deve ser preenchido.' }),
        kpi_type_id: z.number({ invalid_type_error: 'O Tipo de KPI deve ser um número.' }).int('O Tipo de KPI deve ser preenchido.'),
      });
    },

    setRoute(name) {
      this.routeName = name;
    },
    setDataToSend(name) {
      this.dataToSend = name;
    },
    setRouteSuccess(name) {
      this.routeSuccess = name;
    },
    setToken(token) {
      this.token = token;
    },

    async loadTypes() {
      try {
        const typesKpiResponse = await axios.get('/api/kpis/types', {
          headers: {
            'Authorization': `Bearer ${this.token}` // Usa o token do estado da store
          }
        });
        this.typesKpi = typesKpiResponse.data.data || typesKpiResponse.data;
      } catch (error) {
        console.error('Erro ao carregar tipos de KPI:', error);
        this.typesKpi = [];
      }
    },

    validateForm() {
      let validateReturn = { status: 'success', errors: {} };

      try {
        this.errorsResponse = {};
        this.dataSchemaValidator().parse(this.dataToSend);

        return validateReturn;
      } catch (error) {
        if (error.issues) {
          error.issues.forEach(issue => {
            const fieldName = issue.path[issue.path.length - 1];
            validateReturn.errors[fieldName] = issue.message;
          });
        }

        this.errorsResponse = validateReturn.errors;
        validateReturn.status = 'fail';
        return validateReturn;
      }
    },

    async onSubmit() {
      this.processing = true;
      this.responseSuccess = null;
      this.errorsResponse = {};

      const validateThisForm = this.validateForm();

      if (validateThisForm.status === 'fail') {
        this.processing = false;
        return false;
      }

      try {
        const response = await axios.put(this.routeName, this.dataToSend, {
          headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${this.token}`
          }
        });

        this.responseSuccess = response.data;

        this.dataToSend = {
            titulo: null,
            valor: null,
            variacao_percentual: null,
            kpi_type_id: null,
        };

        return true;

      } catch (error) {
        this.errorsResponse = { general: error.response.data.message };
        this.responseSuccess = null;
        return false;
      } finally {
        this.processing = false;
      }
    },
  },
});
