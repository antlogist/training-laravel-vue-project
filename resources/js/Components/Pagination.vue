<template>
  <div class="text-center" v-if="pagesCount() > 1">
    <v-pagination
      v-model="page"
      :length="pagesCount()"
      @update:modelValue="changePage(page)"
    ></v-pagination>
  </div>
</template>

<script>
import { Inertia } from '@inertiajs/inertia'
  export default {
    props: {
      total: Number,
      perPage: Number,
      currentPage: Number,
      path: String
    },
    data () {
      return {
        page: 1,
      }
    },
    methods: {
      changePage(page) {
        Inertia.visit(this.path + '?page=' + page, {
          method: 'get',
          replace: true,
          preserveState: true
        });
      },
      pagesCount() {
        const count = Math.ceil(this.total / this.perPage);
        return count;
      }
    },
  }
</script>