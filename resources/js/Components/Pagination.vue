<template>
  <div class="text-center mt-5" v-if="pagesCount() > 1">
    <v-pagination
      v-model="pagination"
      :length="pagesCount()"
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
        page: this.currentPage,
      }
    },

    methods: {
      pagesCount() {
        const count = Math.ceil(this.total / this.perPage);
        return count;
      }
    },

    computed: {
      pagination: {
        get() {
          return this.currentPage;
        },
        set(page) {
          Inertia.visit(this.path + '?page=' + page, {
            method: 'get',
            replace: true,
            preserveState: true
          });
        }
      }
    }
  }
</script>