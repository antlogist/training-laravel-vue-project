<template>

    <BreezeAuthenticatedLayout>

        <Head :title="title" />

        <v-container>

            <v-row class="mt-5 mb-5" justify-md="center" no-gutters>

                <v-col md="8">

                    <h1>Subcategory List</h1>

                    <div class="text-right mt-5 mb-5">

                        <v-btn
                            class="mr-3"
                            size="small"
                            icon="mdi-magnify"
                            color="grey">
                        </v-btn>

                        <v-btn
                            @click="goToPage(`subcategories/create`)"
                            size="small"
                            icon="mdi-plus"
                            color="grey">
                        </v-btn>

                    </div>

                    <div v-if="subcategories.meta.total > 0">
                        <v-list>
                            <v-list-item elevation="1" three-line v-for="subcategory in subcategories.data" :key="subcategory.id">

                                <v-list-item-header @click="goToPage(`${subcategory.category ? subcategory.category.slug : 'subcategories'}/${subcategory.slug}`)">
                                    <v-list-item-title>{{ subcategory.title }}</v-list-item-title>
                                    <v-list-item-subtitle>slug: {{ subcategory.slug }} || id: {{ subcategory.id }}</v-list-item-subtitle>
                                    <v-list-item-subtitle>category: {{ subcategory.category ? subcategory.category.title : 'No category'}}</v-list-item-subtitle>
                                </v-list-item-header>

                                <template v-slot:append>

                                    <v-list-item-avatar right>
                                        <v-btn
                                            size="x-small"
                                            color="grey lighten-1"
                                            icon="mdi-eye"
                                            @click="goToPage(`${subcategory.category ? subcategory.category.slug : 'subcategories'}/${subcategory.slug}`)">
                                        </v-btn>
                                    </v-list-item-avatar>

                                    <v-list-item-avatar right>
                                        <v-btn
                                            size="x-small"
                                            color="grey lighten-1"
                                            icon="mdi-pen"
                                            @click="goToPage(`${subcategory.category ? subcategory.category.slug : 'subcategories'}/${subcategory.slug}/edit`)">
                                        </v-btn>
                                    </v-list-item-avatar>

                                    <v-list-item-avatar right>
                                        <v-btn
                                            size="x-small"
                                            color="grey lighten-1"
                                            icon="mdi-close"
                                            @click="destroy(subcategory.id)">
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
        subcategories: Object
    },
    components: {
        BreezeAuthenticatedLayout,
        Head,
        Pagination
    },
    methods: {
        destroy(id) {
            if(confirm('Do you really want to delete this category?')) {
                this.$inertia.post(this.route('subcategories.destroy', id));

                //If last item on last page
                if(
                    this.subcategories.links.next === null &&
                    this.subcategories.data.length === 1 &&
                    this.subcategories.meta.total > 1
                   ) {
                    this.goToPage(this.subcategories.meta.path + '?page=' + (this.subcategories.meta.current_page - 1));
                }
            }
        },
        goToPage(page, data = {}) {
            Inertia.visit(page, {
                method: 'get',
                replace: false,
                preserveState: true,
                data: data
            });
        }
    }
}
</script>
