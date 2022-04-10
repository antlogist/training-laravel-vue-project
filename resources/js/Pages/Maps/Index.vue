<template>

    <BreezeAuthenticatedLayout>

        <Head :title="title" />

        <v-container>

            <v-row class="mt-5 mb-5" justify-md="center" no-gutters>

                <v-col md="8">

                    <h1>Maps List</h1>

                    <div class="text-right mt-5 mb-5">

                        <v-btn
                            class="mr-3"
                            size="small"
                            icon="mdi-magnify"
                            color="grey">
                        </v-btn>

                        <v-btn
                            @click="goToPage(`maps/create`)"
                            size="small"
                            icon="mdi-plus"
                            color="grey">
                        </v-btn>

                    </div>

                    <div v-if="maps && maps.meta.total > 0">
                        <v-list>
                            <v-list-item elevation="1" three-line v-for="map in maps.data" :key="map.id">

                                <v-list-item-header @click="goToPage(`maps/${map.slug}`)">
                                    <v-list-item-title>{{ map.title }}</v-list-item-title>
                                    <v-list-item-subtitle>slug: {{ map.slug }}</v-list-item-subtitle>
                                    <v-list-item-subtitle>id: {{ map.id }}</v-list-item-subtitle>
                                </v-list-item-header>

                                <template v-slot:append>

                                    <v-list-item-avatar right>
                                        <v-btn
                                            size="x-small"
                                            color="grey lighten-1"
                                            icon="mdi-eye"
                                            @click="goToPage(`maps/${map.slug}`)">
                                        </v-btn>
                                    </v-list-item-avatar>

                                    <v-list-item-avatar right>
                                        <v-btn
                                            size="x-small"
                                            color="grey lighten-1"
                                            icon="mdi-pen"
                                            @click="goToPage(`maps/${map.slug}/edit`)">
                                        </v-btn>
                                    </v-list-item-avatar>

                                    <v-list-item-avatar right>
                                        <v-btn
                                            size="x-small"
                                            color="grey lighten-1"
                                            icon="mdi-close
                                            " @click="destroy(map.slug)">
                                        </v-btn>
                                    </v-list-item-avatar>

                                </template>

                            </v-list-item>
                        </v-list>

                        <Pagination
                            :total='maps.meta.total'
                            :perPage='maps.meta.per_page'
                            :path='maps.meta.path'
                            :currentPage='maps.meta.current_page'>
                        </Pagination>

                    </div>

                    <div class="my-5" v-else>
                        <p>No maps found</p>
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
        maps: Object
    },
    components: {
        BreezeAuthenticatedLayout,
        Head,
        Pagination
    },
    methods: {
        destroy(id) {
            if(confirm('Do you really want to delete this map?')) {
                this.$inertia.delete(this.route('maps.destroy', id));

                //If last item on last page
                if(
                    this.maps.links.next === null &&
                    this.maps.data.length === 1 &&
                    this.maps.meta.total > 1
                   ) {
                    this.goToPage(this.maps.meta.path + '?page=' + (this.maps.meta.current_page - 1));
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
