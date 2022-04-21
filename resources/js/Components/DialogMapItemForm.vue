<template>
  <v-row justify="center">
    <v-dialog
      v-model="dialog"
      fullscreen
      persistent
    >

      <v-card>
        <v-toolbar
          dark
          color="red"
        >
          <v-toolbar-title>Dialog</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-toolbar-items>
            <v-btn
              icon
              dark
              @click="close"
            >
              <v-icon>mdi-close</v-icon>
            </v-btn>
          </v-toolbar-items>
        </v-toolbar>
        <v-card-subtitle>
          Mode: {{ mode }}
        </v-card-subtitle>

        <v-card-text>
          <v-container>
            <v-form @submit.prevent="submit">
              <v-row>
                <v-col cols="12">

                  <v-text-field
                    class="mt-5"
                    label="Note title"
                    density="compact"
                    v-model.lazy="form.note.title"
                  ></v-text-field>
                </v-col>

                <v-col cols="12">
                  <v-autocomplete
                    v-model="categoryValue"
                    :items="categoryInputItems"
                    density="compact"
                    label="Category"
                    solo
                  ></v-autocomplete>
                </v-col>

                <v-col cols="12">
                  <v-autocomplete
                    v-model="subcategoryValue"
                    :items="subcategoryInputItems"
                    density="compact"
                    label="Subcategory"
                    solo
                  ></v-autocomplete>
                </v-col>

                <v-col cols="12">
                  <v-textarea
                    name="content"
                    label="Note Content"
                    v-model.lazy="form.note.content"
                  ></v-textarea>
                </v-col>

                <v-col cols="12">
                  <div class="text-right">
                    <v-btn
                      color="grey"
                      type="submit">
                      Submit
                    </v-btn>
                  </div>
                </v-col>

              </v-row>
            </v-form>
          </v-container>
        </v-card-text>

        <v-card-actions>
          <v-btn @click="close">Close</v-btn>
        </v-card-actions>
      </v-card>

    </v-dialog>
  </v-row>
</template>

<script>

import { reactive, ref, computed } from 'vue';

export default {
  props: {
    dialog: Boolean,
    categories: Object,
    subcategories: Object,
    errors: Object,
    mode: Number
  },

  emits: ['closeDialog'],

  setup(props, { emit }) {

    const close = function() {
      emit('closeDialog');
    }

    const categoryInputItems = [];

    const subcategoryInputItems = ref([]);

    const form = reactive({
      note: {
        id: '',
        title: '',
        content: '',
        category_id: '',
        subcategory_id: '',
      }
    })

    const categoryValue = computed({
      get() {
        return '';
      },
      set(value) {
        form.note.category_id = value
      }
    })

    const subcategoryValue = computed({
      get() {
        return '';
      },
      set(value) {
        form.note.subcategory_id = value
      }
    })

    const submit = function() {
      alert('!!!');
    }

    return {
      form,
      categoryValue,
      categoryInputItems,
      subcategoryValue,
      subcategoryInputItems,
      submit,
      close
    }
  }
}
</script>
