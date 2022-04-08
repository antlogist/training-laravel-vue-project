<template>
    <BreezeAuthenticatedLayout>

        <Head :title="title" />

        <v-container>
          <v-row>

            <v-col cols="12" sm="4">
              <v-card class="pa-2" outlined tile>
                <!-- {{ layers }} -->
                <div class="buttons-wrapper text-center mb-3">
                  <v-btn :class="{'bg-grey': currentLayer === 2}" variant="outlined" size="x-small" class="mr-1" @click="setLayer(2)">Top</v-btn>
                  <v-btn :class="{'bg-grey': currentLayer === 1}" variant="outlined" size="x-small" @click="setLayer(1)">Middle</v-btn>
                  <v-btn :class="{'bg-grey': currentLayer === 0}" variant="outlined" size="x-small" class="ml-1" @click="setLayer(0)">Bottom</v-btn>

                  <v-btn class="bg-error ml-5" variant="outlined" size="x-small" @click="clearCanvas()">Clear</v-btn>
                </div>

                <div class="text-center">
                  <div class="tileset-wrapper">
                    <img :src="tilesetSource" id="tilesetSource" alt="tile">
                    <div class="tile-selection"></div>
                  </div>
                </div>
              </v-card>
            </v-col>

            <v-col cols="12" sm="8">
              <v-card class="pa-2 text-center canvas-wrapper" outlined tile>
                <canvas :width="canvasSize.width" :height="canvasSize.height"></canvas>
              </v-card>


              <v-card class="pa-2 my-5">

                <v-form @submit.prevent="submit">

                  <v-text-field
                    class="mt-5"
                    label="Note title"
                    density="compact"
                    v-model.lazy="form.note.title"
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
                    v-model.lazy="form.note.content"
                  ></v-textarea>

                  <div class="text-right">
                    <v-btn
                      icon="mdi-content-save"
                      size="small"
                      color="grey"
                      type="submit">
                    </v-btn>
                  </div>

                </v-form>

              </v-card>
            </v-col>

          </v-row>
        </v-container>
    </BreezeAuthenticatedLayout>
</template>

<script>
import { reactive, ref, computed } from 'vue';
import { Head } from '@inertiajs/inertia-vue3';
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import useCanvas from '../../composables/canvas';

export default {
  props: {
    title: String,
    categories: Object,
    subcategories: Object,
    errors: Object
  },
  setup() {

    let {
      canvasSize,
      tilesetSource,
      currentLayer,
      layers,
      setLayer,
      clearCanvas
    } = useCanvas();

    const categoryInputItems = [];

    const subcategoryInputItems = ref([]);

    const form = reactive({
      title: '',
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
      canvasSize,
      tilesetSource,
      currentLayer,
      layers,
      form,
      categoryValue,
      categoryInputItems,
      subcategoryValue,
      subcategoryInputItems,
      submit,
      setLayer,
      clearCanvas
    }

  },
  components: {
      Head,
      BreezeAuthenticatedLayout,
  },
}
</script>

<style scoped>
.tileset-wrapper {
  display: inline-block;
  position: relative;
}
.tile-selection {
  position: absolute;
  outline: 3px solid black;
  left: 0;
  top: 0;
  width: 32px;
  height: 32px;
}

canvas {
  border: 1px solid black;
}

.canvas-wrapper {
  overflow: scroll;
  width: 100%;
  height: 500px;
}
</style>
