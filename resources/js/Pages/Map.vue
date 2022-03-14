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
import { onMounted } from '@vue/runtime-core';
import { ref, reactive } from 'vue';

import useCanvas from '../composables/canvas';

export default {
  setup() {

    let { canvas, layers, ctx, canvasSize } = useCanvas();

    //canvas
    // let canvas = ref(null);
    // let ctx = ref(null);
    // let canvasSize = reactive({
    //   height: 480,
    //   width: 960
    // });

    //tileset
    let tilesetImg = reactive(null);
    let tilesetWrapper = ref(null);
    let tilesetSelection = reactive(null);
    let tilesetSource = ref('');

    //menu tile
    let selection = reactive([0, 0]);

    //mouse
    let isMouseDown = ref(false);

    //layers
    let currentLayer = ref(0);
    //bottom->middle->top
    //structure: 'x-y': ['tilesetX', 'tilesetY']
    //example: '1-1': [3, 4]
    // let layers = reactive([{},{},{}]);

    function colorRect(topLeftX,topLeftY, boxWidth,boxHeight, fillColor) {
      ctx.fillStyle = fillColor;
      ctx.fillRect(topLeftX, topLeftY, boxWidth, boxHeight);
    }

    function setLayer(layer) {
      currentLayer.value = layer;
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

    function getCoordinates(e) {
      const {x, y} = e.target.getBoundingClientRect();
      const mouseX = e.clientX - x;
      const mouseY = e.clientY - y;
      return [Math.floor(mouseX / 32), Math.floor(mouseY / 32)];
    }

    //Handler for placing new tiles on the map
    function addTile(mouseEvent) {
      const clicked = getCoordinates(event);
      const key = clicked[0] + "-" + clicked[1];

      if (mouseEvent.shiftKey) {
          delete layers[currentLayer.value][key];
      } else {
          layers[currentLayer.value][key] = [selection[0], selection[1]];
      }
      draw();
    }

    function clearCanvas() {
      layers = [{},{},{}];
      draw();
    }

    onMounted(() => {
      //canvas
      canvas = document.querySelector('canvas');
      ctx = canvas.getContext('2d');
      // colorRect(0, 0, canvas.width,canvas.height, 'black');
      //Bind mouse events for painting (or removing) tiles on click/drag
      canvas.addEventListener("mousedown", () => {
        isMouseDown.value = true;
      });
      canvas.addEventListener("mouseup", () => {
        isMouseDown.value = false;
      });
      canvas.addEventListener("mouseleave", () => {
        isMouseDown.value = false;
      });
      canvas.addEventListener("mousedown", addTile);
      canvas.addEventListener("mousemove", (event) => {
        if (isMouseDown.value) {
            addTile(event);
        }
      });

      //tileset
      tilesetSelection = document.querySelector('.tile-selection');
      tilesetWrapper = document.querySelector('.tileset-wrapper');
      //tileset mouse click
      tilesetWrapper.addEventListener('mousedown', event => {
        selection = getCoordinates(event);
        tilesetSelection.style.left = selection[0] * 32 + 'px';
        tilesetSelection.style.top = selection[1] * 32 + 'px';
      });
      // tilesetSource = document.querySelector('.tileset-source');

      //set tileset source
      tilesetSource.value = 'https://assets.codepen.io/21542/TileEditorSpritesheet.2x_2.png';

      //get tilesetImg
      tilesetImg = document.querySelector('#tilesetSource');
    })

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
