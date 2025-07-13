
import { defineStore } from 'pinia';
import axios from 'axios';

export const useSearchStore = defineStore('search', {
  state: () => ({
    token: null,
    route: null,
    typesKpi: [],
    searchParams: {
      titulo: '',
      type_id: '',
    },
    results: {
      current_page: 1,
      data: [],
      per_page: 10,
      total: 0,
    },
  }),
  actions: {
    setToken(token) {
      this.token = token;
    },
    setRoute(route) {
      this.route = route;
    },
    setResults(data) {
      this.results = data;
    },
    async loadTypes() {
        const typesKpiResponse = await axios.get('/api/kpis/types', {
            headers: {
                'Authorization': `Bearer ${this.token}`
            }
        });

        this.typesKpi = typesKpiResponse.data;
    },
    async onSearch() {
      try {

        const response = await axios.get(this.route, {
          params: this.searchParams,
          headers: {
            'Authorization': `Bearer ${this.token}`
          }
        });

        this.setResults(response.data);

      } catch (error) {
        console.error('Erro na busca do KPI:', error);
        this.setResults({ // Resetar para um estado vazio em caso de erro
          current_page: 1, data: [], first_page_url: null, from: null,
          last_page: 1, last_page_url: null, links: [], next_page_url: null,
          path: null, per_page: 20, prev_page_url: null, to: null, total: 0,
        });
      }
    },
    async fetchPage(url) {
      if (!url) return;
      try {
        const response = await axios.get(url, {
          params: this.searchParams,
          headers: {
            'Authorization': `Bearer ${this.token}`
          }
        });
        this.setResults(response.data);
      } catch (error) {
        console.error('Erro ao buscar página:', error);
      }
    }
  },
});
