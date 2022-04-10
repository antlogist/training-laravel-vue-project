<template>
    <BreezeAuthenticatedLayout>

        <Head :title="title" />

        <v-container>
          <v-row>

            <v-col cols="12" sm="4">
              <v-card class="pa-2" outlined tile>
                {{ layers }}
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
                <v-btn @click="openMapItemDialog">Open Dialog</v-btn>
                <v-btn @click="saveMap">Save Map</v-btn>
              </v-card>

            </v-col>

          </v-row>

          <DialogMapItemForm
            :dialog='isDialogFormOpen'
            @closeDialog='closeMapItemDialog'/>

        </v-container>
    </BreezeAuthenticatedLayout>
</template>

<script>
import { ref } from 'vue';
import { Head } from '@inertiajs/inertia-vue3';
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import useCanvas from '../../composables/canvas';
import DialogMapItemForm from '../../Components/DialogMapItemForm.vue';

export default {
  props: {
    title: String,
  },
  setup() {

    let isDialogFormOpen = ref(false);

    let {
      canvasSize,
      tilesetSource,
      currentLayer,
      layers,
      setLayer,
      clearCanvas
    } = useCanvas();

    const openMapItemDialog = function() {
      isDialogFormOpen.value = true;
    }

    const closeMapItemDialog = function() {
      isDialogFormOpen.value = false;
    }

    const saveMap = function() {
      alert('!!!');
    }

    return {
      canvasSize,
      tilesetSource,
      currentLayer,
      layers,
      isDialogFormOpen,
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
      DialogMapItemForm
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
