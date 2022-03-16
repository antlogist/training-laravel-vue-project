<template>

    <BreezeAuthenticatedLayout>

        <Head :title="title" />

        <v-container>
            <h1>Category List</h1>
        </v-container>
    </BreezeAuthenticatedLayout>

</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head } from '@inertiajs/inertia-vue3';

export default {
    props: {
        title: String
    },
    components: {
        BreezeAuthenticatedLayout,
        Head
    },
}
</script>
