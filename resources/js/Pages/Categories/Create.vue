<template>

    <BreezeAuthenticatedLayout>

        <Head :title="title" />

        <v-container>

            <v-row class="mt-5 mb-5" justify-md="center" no-gutters>

                <v-col md="8">

                  <h1>Create Category</h1>

                  <v-form @submit.prevent="submit">
                    <v-text-field
                        class="mt-5"
                        label="Category"
                        density="compact"
                        v-model="form.title"
                        :error-messages="errors.title"
                    ></v-text-field>

                    <div class="mt-5 text-right">
                      <v-btn
                        class="mr-3"
                        icon="mdi-format-list-bulleted"
                        size="small"
                        color="grey"
                        @click="goToPage('/categories')">
                      </v-btn>

                      <v-btn
                        icon="mdi-content-save"
                        size="small"
                        color="grey"
                        type="submit">
                      </v-btn>
                    </div>
                  </v-form>
                </v-col>

            </v-row>

        </v-container>
    </BreezeAuthenticatedLayout>

</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { reactive } from 'vue';
import { Head } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';

export default {
    props: {
        title: String,
        errors: Object
    },
    components: {
        BreezeAuthenticatedLayout,
        Head,
    },
    setup() {

      const form = reactive({
        title: null,
      });

      function submit() {
        Inertia.post('/categories', form)
      }

      function goToPage(page) {
        Inertia.visit(page, {
            method: 'get',
            replace: false,
            preserveState: true
        });
      }

      return {
        form,
        submit,
        goToPage
      }
    }
}
</script>
