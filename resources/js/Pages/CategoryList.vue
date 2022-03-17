<template>

    <BreezeAuthenticatedLayout>

        <Head :title="title" />

        <v-container>
            <h1>Category List</h1>
            <div v-if="categories.total > 0">
                <v-list-item two line v-for="category in categories.data" :key="category.id">
                    <v-list-item-header>
                        <v-list-item-title>{{ category.title }}</v-list-item-title>
                        <v-list-item-subtitle>{{ category.slug }}</v-list-item-subtitle>
                    </v-list-item-header>
                </v-list-item>
                <Pagination :total='categories.total' :perPage='categories.per_page' :path='categories.path' :currentPage='categories.current_page' />
            </div>

            <div v-else>
                <p>No categories found</p>
            </div>

        </v-container>
    </BreezeAuthenticatedLayout>

</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head } from '@inertiajs/inertia-vue3';
import Pagination from '../Components/Pagination';

export default {
    props: {
        title: String,
        categories: Array
    },
    components: {
        BreezeAuthenticatedLayout,
        Head,
        Pagination
    },
}
</script>
