<template>
    <BreezeAuthenticatedLayout>

        <Head :title="title" />
        <v-container>
            {{ layers }}
          <v-row>
            <v-col cols="12" sm="4">
              <v-card class="pa-2" outlined tile>
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

                <v-text-field
                  class="mt-5"
                  label="Map title"
                  density="compact"
                  v-model.lazy="mapTitle"
                  :error-messages="errors.title"
                ></v-text-field>

              <v-card class="pa-2 text-center canvas-wrapper" outlined tile>
                <canvas :width="canvasSize.width" :height="canvasSize.height"></canvas>
              </v-card>

              <v-card class="pa-2 my-5">
                <v-btn @click="openMapItemDialog">Open Dialog</v-btn>
                <v-btn @click="saveMap">Save Map</v-btn>
              </v-card>
            </v-col>

          </v-row>

          <DialogMapNote
            :dialog='isDialogNoteOpen'
            :mode='dialogMode'
            @closeDialog='closeMapItemDialog'/>

        </v-container>
    </BreezeAuthenticatedLayout>
</template>

<script>
import { ref } from 'vue';
import { Head } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import useCanvas from '../../composables/canvasEdit';
import DialogMapNote from '../../Components/DialogMapNote.vue';

export default {
  props: {
    title: String,
    map: Object,
    errors: Object
  },
  setup(props) {

    let mapTitle = ref('');
    let tiles = [{}, {}, {}];

    let {
      canvasSize,
      tilesetSource,
      currentLayer,
      layers,
      isDialogNoteOpen,
      dialogMode,
      setLayer,
      clearCanvas
    } = useCanvas(tiles);

    const openMapItemDialog = function() {
      isDialogNoteOpen.value = true;
    }

    const closeMapItemDialog = function() {
      dialogMode.value = null;
      isDialogNoteOpen.value = false;
    }

    const saveMap = function() {
      const form = {
        title: mapTitle.value,
        tiles: JSON.stringify(layers)
      }
      Inertia.post(`/maps`, form);
    }

    return {
      mapTitle,
      canvasSize,
      tilesetSource,
      currentLayer,
      layers,
      isDialogNoteOpen,
      dialogMode,
      openMapItemDialog,
      closeMapItemDialog,
      setLayer,
      clearCanvas,
      saveMap
    }

  },
  components: {
      Head,
      BreezeAuthenticatedLayout,
      DialogMapNote
  },
}
</script>

<style scoped>
.tileset-wrapper {
  display: inline-block;
  position: relative;
  overflow: scroll;
  width: 100%;
  height: 1024px;
  text-align: left;
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
  height: 800px;
}
</style>
