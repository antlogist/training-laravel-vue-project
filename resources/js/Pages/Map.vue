<template>
    <BreezeAuthenticatedLayout>
        <v-container>
          <v-row no-gutters>

            <v-col cols="12" sm="4">
              <v-card class="pa-2" outlined tile>
                <div class="buttons-wrapper text-center mb-3">
                  <v-btn variant="outlined" class="mr-1">Layer 1</v-btn>
                  <v-btn variant="outlined">Layer 2</v-btn>
                  <v-btn variant="outlined" class="ml-1">Layer 3</v-btn>
                </div>

                <div class="tileset-wrapper">
                  <img id="tileset-source" alt="tile">
                  <div class="tile-selection"></div>
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
import { onMounted } from '@vue/runtime-core';
import { ref, reactive } from 'vue';

export default {
  setup() {

    //canvas
    let canvas = ref(null);
    let canvasContext = ref(null);
    let canvasSize = reactive({
      height: 450,
      width: 450
    });

    //tileset
    let tilesetWrapper = ref(null);
    let tilesetSelection = ref(null);
    let tilesetSource = ref(null);

    //menu tile
    let selection = ref([0, 0]);

    //mouse
    let isMouseDown = ref(false);

    //layers
    let currentLayer = ref(0);
    //structure: 'x-y': ['tilesetX', 'tilesetY']
    //example: '1-1': [3, 4]
    let layers = reactive([{},{},{}]);

    function colorRect(topLeftX,topLeftY, boxWidth,boxHeight, fillColor) {
      canvasContext.fillStyle = fillColor;
      canvasContext.fillRect(topLeftX, topLeftY, boxWidth, boxHeight);
    }

    onMounted(() => {
      //canvas
      canvas = document.querySelector('canvas');
      canvasContext = canvas.getContext('2d');
      colorRect(0, 0, canvas.width,canvas.height, 'black');

      //tileset
      tilesetWrapper = document.querySelector('.tileset-wrapper');
      tilesetSelection = document.querySelector('.tileset-selection');
      tilesetSource = document.querySelector('.tileset-source');
    })

    return {
      canvasSize
    }

  },
  components: {
      BreezeAuthenticatedLayout,
  },
}
</script>
