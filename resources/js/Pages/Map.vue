<template>
    <BreezeAuthenticatedLayout>
        <v-container>
          <v-row no-gutters>

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
              <v-card class="pa-2 text-center" outlined tile>
                <canvas :width="canvasSize.width" :height="canvasSize.height"></canvas>
              </v-card>
            </v-col>

          </v-row>
        </v-container>
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import useCanvas from '../composables/canvas';

export default {
  setup() {

    let {
      canvasSize,
      tilesetSource,
      currentLayer,
      setLayer,
      clearCanvas
    } = useCanvas();

    return {
      canvasSize,
      tilesetSource,
      currentLayer,
      setLayer,
      clearCanvas
    }

  },
  components: {
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
</style>
