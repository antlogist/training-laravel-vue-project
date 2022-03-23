<template>

    <BreezeAuthenticatedLayout>

        <Head :title="title" />

        <v-container>

            <v-row class="mt-5 mb-5" justify-md="center" no-gutters>

                <v-col md="8">

                  <h1>Category: {{ category.data.title }}</h1>
                  <small>{{ category.data.slug }}</small>

                    <div class="mt-5 text-right">

                      <v-btn
                        icon="mdi-format-list-bulleted"
                        size="small"
                        color="grey"
                        @click="goToPage('/categories')">
                      </v-btn>

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
