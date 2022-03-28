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
                      v-model.lazy="form.title"
                      :error-messages="errors.title"
                    ></v-text-field>

                    <v-autocomplete
                      v-model="categoryValue"
                      :items="categoryInputItems"
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
import { ref, reactive, onMounted, computed } from 'vue';
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
    setup(props) {

      const categories = JSON.parse(JSON.stringify(props.categories)).data;
      const categoryInputItems = [];

      const form = reactive({
        title: null,
        category_id: null
      });

      let categoryTitleSelect = ref('');

      const categoryValue = computed({
        get() {
          return categoryTitleSelect.value;
        },
        set(value) {
          categoryTitleSelect.value = value;

          const category = categories.find(item =>
            item.title === categoryTitleSelect.value
          );
          form.category_id = category.id;

        }
      })

      onMounted(()=>{
        categories.map((item) => {
          categoryInputItems.push(item.title);
        })
      })

      const submit = (() => {
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
        categoryInputItems,
        categoryValue,
        submit,
        goToPage
      }
    }
}
</script>
