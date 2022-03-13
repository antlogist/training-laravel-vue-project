<template>
    <BreezeAuthenticatedLayout>
        <v-container>
          <v-row no-gutters>

            <v-col cols="12" sm="4">
              <v-card class="pa-2" outlined tile>
                <div class="buttons-wrapper text-center mb-3">
                  <v-btn variant="outlined" size="x-small" class="mr-1" @click="draw()">Layer 1</v-btn>
                  <v-btn variant="outlined" size="x-small">Layer 2</v-btn>
                  <v-btn variant="outlined" size="x-small" class="ml-1">Layer 3</v-btn>
                </div>

                <div class="tileset-wrapper text-center">
                  <img :src="tilesetSource" id="tilesetSource" alt="tile">
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
    let ctx = ref(null);
    let canvasSize = reactive({
      height: 480,
      width: 480
    });

    //tileset
    let tilesetImg = reactive(null);
    let tilesetWrapper = ref(null);
    let tilesetSelection = ref(null);
    let tilesetSource = ref('');

    //menu tile
    let selection = ref([0, 0]);

    //mouse
    let isMouseDown = ref(false);

    //layers
    let currentLayer = ref(0);
    //bottom->middle->top
    //structure: 'x-y': ['tilesetX', 'tilesetY']
    //example: '1-1': [3, 4]
    let layers = reactive([{
      '0-0': [1,1]
    },{},{}]);

    function colorRect(topLeftX,topLeftY, boxWidth,boxHeight, fillColor) {
      ctx.fillStyle = fillColor;
      ctx.fillRect(topLeftX, topLeftY, boxWidth, boxHeight);
    }

    function draw() {
      ctx.clearRect(0, 0, canvas.width,canvas.height);

      const sizeOfCrop = 32;

      layers.map((layer)=>{
        Object.keys(layer).map((key) => {
          const positionX = Number(key.split("-")[0]); // where cropping ends * 32
          const positionY = Number(key.split("-")[1]); // where cropping ends * 32

          const [tilesheetX, tilesheetY] = layer[key]; //deconstruction. * 32 - where cropping starts

          ctx.drawImage(
            tilesetImg,
            tilesheetX * 32, tilesheetY * 32, //top left corner of the grab
            sizeOfCrop, sizeOfCrop, //how big of a grab
            positionX * 32, positionY * 32, //where the crop to be placed
            sizeOfCrop, sizeOfCrop //size of placement what was grabbed
          );
        })
      })
    }

    onMounted(() => {
      //canvas
      canvas = document.querySelector('canvas');
      ctx = canvas.getContext('2d');
      // colorRect(0, 0, canvas.width,canvas.height, 'black');

      //tileset
      tilesetWrapper = document.querySelector('.tileset-wrapper');
      tilesetSelection = document.querySelector('.tileset-selection');
      // tilesetSource = document.querySelector('.tileset-source');

      //set tileset source
      tilesetSource.value = 'https://assets.codepen.io/21542/TileEditorSpritesheet.2x_2.png';

      //get tilesetImg
      tilesetImg = document.querySelector('#tilesetSource');
    })

    return {
      canvasSize,
      tilesetSource,
      draw
    }

  },
  components: {
      BreezeAuthenticatedLayout,
  },
}
</script>
