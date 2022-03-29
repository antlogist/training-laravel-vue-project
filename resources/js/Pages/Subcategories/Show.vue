<template>

    <BreezeAuthenticatedLayout>

        <Head :title="title" />

        <v-container>

            <v-row class="mt-5 mb-5" justify-md="center" no-gutters>

                <v-col md="8">

                  <h1>Subcategory: {{ subcategory.data.title }}</h1>
                  <small>Slug: {{ subcategory.data.slug }} || Category: {{ category ? category.data.title : 'no category' }}</small>

                  <div class="mt-5 mb-5" justify-md="center" no-gutters>

                        <h2>Subcategory description</h2>

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

export default {
    props: {
        title: String,
        subcategory: Object,
        category: Object
    },
    components: {
        BreezeAuthenticatedLayout,
        Head,
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
