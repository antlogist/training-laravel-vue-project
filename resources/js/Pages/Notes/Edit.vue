<template>
    <BreezeAuthenticatedLayout>

        <Head :title="title" />

        <v-container>
            <v-row class="mt-5 mb-5" justify-md="center" no-gutters>

                <v-col md="8">

                  <h1>{{ title }}</h1>

                  <v-form @submit.prevent="submit">

                    <v-text-field
                      class="mt-5"
                      label="Note title"
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

                    <v-autocomplete
                      v-model="subcategoryValue"
                      :items="subcategoryInputItems"
                      density="compact"
                      label="Subcategory"
                      solo
                    ></v-autocomplete>

                    <v-textarea
                      name="content"
                      label="Note Content"
                      v-model.lazy="form.content"
                    ></v-textarea>

                    <div class="mt-5 text-right">
                      <v-btn
                        class="mr-3"
                        icon="mdi-arrow-left"
                        size="small"
                        color="grey"
                        @click="backPage">
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
    note: Object,
    category: Object,
    subcategory: Object,
    categories: Object,
    subcategories: Object,
    errors: Object
  },
  components: {
      BreezeAuthenticatedLayout,
      Head,
  },
  setup(props) {

    const categories = JSON.parse(JSON.stringify(props.categories)).data;
    const categoryInputItems = [];

    const subcategories = JSON.parse(JSON.stringify(props.subcategories)).data;
    let subcategoryInputItems = ref([]);

    const form = reactive({
      id: props.note.data.id,
      title: props.note.data.title,
      content: props.note.data.content,
      category_id: props.category ? props.category.data.id : '',
      subcategory_id: props.subcategory ? props.subcategory.data.id : '',
    });

    let categoryTitleSelect = ref('');
    let subcategoryTitleSelect = ref('');

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

        subcategoryTitleSelect.value = '';
        form.subcategory_id = null;

        subcategoryInputItems.value = [];

        subcategories.map((item) => {
          if(item.category_id === category.id) {
            subcategoryInputItems.value.push(item.title);
          }
        })

      }
    })

    const subcategoryValue = computed({
      get() {
        return subcategoryTitleSelect.value;
      },
      set(value) {
        subcategoryTitleSelect.value = value;

        const subcategory = subcategories.find(item =>
          item.title === subcategoryTitleSelect.value
        );
        form.subcategory_id = subcategory.id;

      }
    })

    const categoryOnMounted = function() {
      categories.map((item) => {
        categoryInputItems.push(item.title);
        if(props.category && item.id === props.category.data.id) {
          categoryTitleSelect.value = props.category.data.title;
        }
      });
    }

    const subcategoryOnMounted = function() {

      subcategories.map((item) => {
        if(item.category_id === props.category.data.id) {
          subcategoryInputItems.value.push(item.title);
        }
        if(props.subcategory && item.id === props.subcategory.data.id) {
          subcategoryTitleSelect.value = props.subcategory.data.title;
        }
      })
    }

    onMounted(()=>{
      categoryOnMounted();
      subcategoryOnMounted();
    })

    const submit = (() => {
      Inertia.put(`/notes/${props.note.data.slug}`, form)
    })

    const goToPage = ((page)=>{
      Inertia.visit(page, {
          method: 'get',
          replace: false,
          preserveState: true
      });
    })

    const backPage = (()=>{
      window.history.back();
    })

    return {
      form,

      categoryTitleSelect,
      categoryInputItems,
      categoryValue,

      subcategoryTitleSelect,
      subcategoryInputItems,
      subcategoryValue,

      submit,
      goToPage,
      backPage
    }
  }
}
</script>
