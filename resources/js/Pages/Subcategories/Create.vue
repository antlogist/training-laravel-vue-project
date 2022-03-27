<template>

    <BreezeAuthenticatedLayout>

        <Head :title="title" />

        <v-container>
            <v-row class="mt-5 mb-5" justify-md="center" no-gutters>

                <v-col md="8">

                  <h1>Create Subcategory</h1>

                  <v-form @submit.prevent="submit">
                    <v-text-field
                      class="mt-5"
                      label="Subcategory"
                      density="compact"
                      v-model="form.title"
                      :error-messages="errors.title"
                    ></v-text-field>

                    <v-autocomplete
                      v-model="categoryInput"
                      :items="categories.data"
                      item-text="title"
                      density="compact"
                      label="Category"
                      solo
                    ></v-autocomplete>

                    <div class="mt-5 text-right">

                      <v-btn
                        class="mr-3"
                        icon="mdi-format-list-bulleted"
                        size="small"
                        color="grey"
                        @click="goToPage('/subcategories')">
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
import { reactive, computed } from 'vue';
import { Head } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';

export default {
    props: {
        title: String,
        categories: Object,
        errors: Object
    },
    components: {
        BreezeAuthenticatedLayout,
        Head,
    },
    setup() {

      const form = reactive({
        title: null,
        category_id: null
      });

      const categoryInput = computed({
        get() {
          return {
            title: 'test'
          };
        },
        set(value) {
          console.log(value);
        }
      });

      const submit = (()=>{
        Inertia.post('/subcategories', form)
      })

      const goToPage = ((page)=>{
        Inertia.visit(page, {
            method: 'get',
            replace: false,
            preserveState: true
        });
      })

      return {
        form,
        submit,
        categoryInput,
        goToPage
      }
    }
}
</script>
