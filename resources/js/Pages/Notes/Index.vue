<template>

    <BreezeAuthenticatedLayout>

        <Head :title="title" />

        <v-container>
          <!-- <pre>
            {{ notes }}
          </pre> -->

            <v-row class="mt-5 mb-5" justify-md="center" no-gutters>

                <v-col md="8">

                    <h1>Note List</h1>

                    <div class="text-right mt-5 mb-5">

                        <v-btn
                            class="mr-3"
                            size="small"
                            icon="mdi-magnify"
                            color="grey">
                        </v-btn>

                        <v-btn
                            @click="goToPage(`notes/create`)"
                            size="small"
                            icon="mdi-plus"
                            color="grey">
                        </v-btn>

                    </div>

                    <div v-if="notes.meta.total > 0">
                        <v-list>
                            <v-list-item elevation="1" three-line v-for="note in notes.data" :key="note.id">

                                <v-list-item-header @click="goToPage(`notes/${note.slug}`)">
                                    <v-list-item-title>{{ note.title }}</v-list-item-title>
                                    <v-list-item-subtitle>slug: {{ note.slug }} || id: {{ note.id }}</v-list-item-subtitle>
                                    <v-list-item-subtitle>
                                      category: {{ note.category ? note.category.title : 'No category'}} ||
                                      subcategory: {{ note.subcategory ? note.subcategory.title : 'No subcategory'}}
                                    </v-list-item-subtitle>
                                </v-list-item-header>

                                <template v-slot:append>

                                    <v-list-item-avatar right>
                                        <v-btn
                                            size="x-small"
                                            color="grey lighten-1"
                                            icon="mdi-eye"
                                            @click="goToPage(`notes/${note.slug}`)"
                                        >
                                        </v-btn>
                                    </v-list-item-avatar>

                                    <v-list-item-avatar right>
                                        <v-btn
                                            size="x-small"
                                            color="grey lighten-1"
                                            icon="mdi-pen"
                                        >
                                        </v-btn>
                                    </v-list-item-avatar>

                                    <v-list-item-avatar right>
                                        <v-btn
                                            size="x-small"
                                            color="grey lighten-1"
                                            icon="mdi-close"
                                            @click="destroy(note.id)">
                                        </v-btn>
                                    </v-list-item-avatar>

                                </template>

                            </v-list-item>
                        </v-list>

                        <Pagination
                            :total='notes.meta.total'
                            :perPage='notes.meta.per_page'
                            :path='notes.meta.path'
                            :currentPage='notes.meta.current_page'>
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
        notes: Object
    },
    components: {
        BreezeAuthenticatedLayout,
        Head,
        Pagination
    },
    methods: {
        destroy(id) {
            if(confirm('Do you really want to delete this category?')) {
                this.$inertia.post(this.route('notes.destroy', id));

                //If last item on last page
                if(
                    this.notes.links.next === null &&
                    this.notes.data.length === 1 &&
                    this.notes.meta.total > 1
                   ) {
                    this.goToPage(this.notes.meta.path + '?page=' + (this.notes.meta.current_page - 1));
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
