<template>
    <div class="flex justify-end">
      <nav aria-label="Page navigation example">
          <ul class="flex list-style-none">
              <div class="flex mt-1 text-gray-500 font-semibold pt-0.5 mr-5">
                  <p class="mr-2 ">Total por pagina {{ data.per_page }} </p>
                  <p>{{ data.current_page }}</p> -
                  <p class="mr-2">{{ data.last_page }}</p> of
                  <p class="ml-2">{{ data.total }}</p>
              </div>
          <li class="page-item">
              <a
                  class="cursor-pointer capitalize page-link relative block py-1.5 px-3 border-0 bg-transparent outline-none transition-all duration-300 rounded-md text-gray-800 hover:text-gray-800 hover:bg-gray-200 focus:shadow-none"
                  v-if="data.prev_page_url"
                  @click.prevent="handlePageClick(data.prev_page_url)"
              >Prev</a>
          </li>

          <li v-for="link in cleanLInks" :key="link.label"
              :class="{'bg-gray-100 text-gray-700 rounded-md' : link.active}"
              class="page-item mx-1">
              <a
                @click.prevent="handlePageClick(link.url)"
                class="cursor-pointer page-link relative block py-1.5 px-3 border-1 outline-none transition-all duration-300 rounded-md hover:text-white hover:bg-sky-500 shadow focus:shadow-md"
              >{{ link.label }}</a>
          </li>

          <li class="page-item">
              <a
                  class="cursor-pointer capitalize page-link relative block py-1.5 px-3 border-0 bg-transparent outline-none transition-all duration-300 rounded-full text-gray-800 hover:text-gray-800 hover:bg-gray-200 focus:shadow-none"
                  v-if="data.next_page_url"
                  @click.prevent="handlePageClick(data.next_page_url)"
              >Next</a>
          </li>
          </ul>
      </nav>
    </div>
</template>

<script setup>
import { defineEmits } from 'vue';

const emit = defineEmits(['page-clicked']);

const props = defineProps({
    data: Object,
    params: String
});

const cleanLInks = [...props.data.links];
cleanLInks.shift();
cleanLInks.pop();

const handlePageClick = (url) => {
    emit('page-clicked', url);
};
</script>
