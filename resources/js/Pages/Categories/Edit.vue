<template>

    <BreezeAuthenticatedLayout>

        <Head :title="title" />

        <v-container>

            <h1>Edit Category</h1>

            <v-row class="mt-5 mb-5" justify-md="center" no-gutters>

                <v-col md="8">
                  <v-form @submit.prevent="submit">
                    <v-text-field
                        class="mt-5"
                        label="Category"
                        density="compact"
                        v-model="form.title"
                        :error-messages="errors.title"
                    ></v-text-field>

                    <v-btn type="submit" class="mr-1">Update</v-btn>
                    <v-btn @click="goToPage('/categories')">Back</v-btn>
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
        errors: Object,
        category: Object
    },
    components: {
        BreezeAuthenticatedLayout,
        Head,
    },
    setup(props) {

      const form = reactive({
        title: props.category.title,
        id: props.category.id
      });

      function submit() {
        Inertia.put(`/categories/${props.category.id}`, form)
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
