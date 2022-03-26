<template>

    <BreezeAuthenticatedLayout>

        <Head :title="title" />

        <v-container>

            <v-row class="mt-5 mb-5" justify-md="center" no-gutters>

                <v-col md="8">

                  <h1>Category: {{ category.data.title }}</h1>
                  <small>{{ category.data.slug }}</small>

                  <div class="mt-5 mb-5" justify-md="center" no-gutters>

                        <h2>Subcategory List</h2>

                        <div class="text-right mt-5 mb-5">

                            <v-btn
                              class="mr-3"
                              icon="mdi-format-list-bulleted"
                              size="small"
                              color="grey"
                              @click="goToPage('/categories')">
                            </v-btn>

                            <v-btn
                              class="mr-3"
                              size="small"
                              icon="mdi-magnify"
                              color="grey">
                            </v-btn>

                            <v-btn
                              @click="goToPage(`/subcategories/create`)"
                              size="small"
                              icon="mdi-plus"
                              color="grey">
                            </v-btn>

                        </div>

                        <div v-if="subcategories.meta && subcategories.meta.total > 0">
                            <v-list>
                                <v-list-item elevation="1" two-line v-for="subcategory in subcategories.data" :key="subcategory.id">

                                    <v-list-item-header>
                                        <v-list-item-title>{{ subcategory.title }}</v-list-item-title>
                                        <v-list-item-subtitle>slug: {{ subcategory.slug }} || id: {{ subcategory.id }}</v-list-item-subtitle>
                                    </v-list-item-header>

                                    <template v-slot:append>

                                        <v-list-item-avatar right>
                                            <v-btn
                                                size="x-small"
                                                color="grey lighten-1"
                                                icon="mdi-eye"
                                                @click="goToPage(`subcategories/${subcategory.slug}`)">
                                            </v-btn>
                                        </v-list-item-avatar>

                                        <v-list-item-avatar right>
                                            <v-btn
                                                size="x-small"
                                                color="grey lighten-1"
                                                icon="mdi-pen"
                                                @click="goToPage(`subcategories/${subcategory.slug}/edit`)">
                                            </v-btn>
                                        </v-list-item-avatar>

                                        <v-list-item-avatar right>
                                            <v-btn
                                                size="x-small"
                                                color="grey lighten-1"
                                                icon="mdi-close
                                                " @click="destroy(subcategory.slug)">
                                            </v-btn>
                                        </v-list-item-avatar>

                                    </template>

                                </v-list-item>
                            </v-list>

                            <Pagination
                                :total='subcategories.meta.total'
                                :perPage='subcategories.meta.per_page'
                                :path='subcategories.meta.path'
                                :currentPage='subcategories.meta.current_page'>
                            </Pagination>

                        </div>

                        <div class="my-5" v-else>
                            <p>No subcategories found</p>
                        </div>

                  </div>

                </v-col>

            </v-row>

        </v-container>
    </BreezeAuthenticatedLayout>

</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import Pagination from '../../Components/Pagination';

export default {
    props: {
        title: String,
        category: Object,
        subcategories: Object
    },
    components: {
        BreezeAuthenticatedLayout,
        Head,
        Pagination
    },
    setup() {

      function goToPage(page) {
        Inertia.visit(page, {
            method: 'get',
            replace: false,
            preserveState: true
        });
      }

      return {
        goToPage
      }
    }
}
</script>
