<template>

    <BreezeAuthenticatedLayout>

        <Head :title="title" />

        <v-container>

            <v-row class="mt-5 mb-5" justify-md="center" no-gutters>

                <v-col md="8">

                  <h1>Note: {{ note.data.title }}</h1>
                  <small>Slug: {{ note.data.slug }}</small><br>
                  <small>Category: {{ category ? category.data.title : 'no category' }} || Subcategory: {{ subcategory ? subcategory.data.title : 'no subcategory' }}</small>

                  <div class="mt-5 mb-5" justify-md="center" no-gutters>

                        <h2>Note content</h2>

                        <div class="text-right mt-5 mb-5">

                            <v-btn
                              icon="mdi-arrow-left"
                              size="small"
                              color="grey"
                              @click="backPage()">
                            </v-btn>

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

export default {
    props: {
        title: String,
        note: Object,
        category: Object,
        subcategory: Object,
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

      function backPage() {
        window.history.back();
      }

      return {
        goToPage,
        backPage
      }
    }
}
</script>
