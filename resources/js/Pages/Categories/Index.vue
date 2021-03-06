<template>

    <BreezeAuthenticatedLayout>

        <Head :title="title" />

        <v-container>

            <v-row class="mt-5 mb-5" justify-md="center" no-gutters>

                <v-col md="8">

                    <h1>Category List</h1>

                    <div class="text-right mt-5 mb-5">

                        <v-btn
                            class="mr-3"
                            size="small"
                            icon="mdi-magnify"
                            color="grey">
                        </v-btn>

                        <v-btn
                            @click="goToPage(`categories/create`)"
                            size="small"
                            icon="mdi-plus"
                            color="grey">
                        </v-btn>

                    </div>

                    <div v-if="categories.meta.total > 0">
                        <v-list>
                            <v-list-item elevation="1" three-line v-for="category in categories.data" :key="category.id">

                                <v-list-item-header @click="goToPage(`categories/${category.slug}`)">
                                    <v-list-item-title>{{ category.title }}</v-list-item-title>
                                    <v-list-item-subtitle>slug: {{ category.slug }}</v-list-item-subtitle>
                                    <v-list-item-subtitle>id: {{ category.id }}</v-list-item-subtitle>
                                </v-list-item-header>

                                <template v-slot:append>

                                    <v-list-item-avatar right>
                                        <v-btn
                                            size="x-small"
                                            color="grey lighten-1"
                                            icon="mdi-eye"
                                            @click="goToPage(`categories/${category.slug}`)">
                                        </v-btn>
                                    </v-list-item-avatar>

                                    <v-list-item-avatar right>
                                        <v-btn
                                            size="x-small"
                                            color="grey lighten-1"
                                            icon="mdi-pen"
                                            @click="goToPage(`categories/${category.slug}/edit`)">
                                        </v-btn>
                                    </v-list-item-avatar>

                                    <v-list-item-avatar right>
                                        <v-btn
                                            size="x-small"
                                            color="grey lighten-1"
                                            icon="mdi-close
                                            " @click="destroy(category.slug)">
                                        </v-btn>
                                    </v-list-item-avatar>

                                </template>

                            </v-list-item>
                        </v-list>

                        <Pagination
                            :total='categories.meta.total'
                            :perPage='categories.meta.per_page'
                            :path='categories.meta.path'
                            :currentPage='categories.meta.current_page'>
                        </Pagination>

                    </div>

                    <div class="my-5" v-else>
                        <p>No categories found</p>
                    </div>

                </v-col>

            </v-row>

        </v-container>
    </BreezeAuthenticatedLayout>

</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head } from '@inertiajs/inertia-vue3';
import Pagination from '../../Components/Pagination';
import { Inertia } from '@inertiajs/inertia';

export default {
    props: {
        title: String,
        categories: Object
    },
    components: {
        BreezeAuthenticatedLayout,
        Head,
        Pagination
    },
    methods: {
        destroy(id) {
            if(confirm('Do you really want to delete this category?')) {
                this.$inertia.delete(this.route('categories.destroy', id));

                //If last item on last page
                if(
                    this.categories.links.next === null &&
                    this.categories.data.length === 1 &&
                    this.categories.meta.total > 1
                   ) {
                    this.goToPage(this.categories.meta.path + '?page=' + (this.categories.meta.current_page - 1));
                }
            }
        },
        goToPage(page) {
            Inertia.visit(page, {
                method: 'get',
                replace: false,
                preserveState: true,
            });
        }
    }
}
</script>
