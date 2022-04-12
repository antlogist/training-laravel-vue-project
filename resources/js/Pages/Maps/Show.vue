<template>
    <BreezeAuthenticatedLayout>

        <Head :title="title" />

        <v-container>
          <v-row>
            <div style="display: none;">
              <img :src="tilesetSource" id="tilesetSource" alt="tile">
            </div>

            <v-col cols="12" sm="12">

              <v-card class="pa-2 text-center canvas-wrapper" outlined tile>
                <canvas :width="canvasSize.width" :height="canvasSize.height"></canvas>
              </v-card>

              <v-card class="pa-2 my-5">

                <v-btn
                  class="mr-1"
                  icon="mdi-arrow-left"
                  size="small"
                  color="grey"
                  @click="backPage()">
                </v-btn>

                <v-btn
                  @click="openMapItemDialog">Open Dialog
                </v-btn>

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
import useCanvas from '../../composables/canvasShow';
import DialogMapItemForm from '../../Components/DialogMapItemForm.vue';

export default {
  props: {
    title: String,
    map: Object
  },
  setup(props) {

    let tiles = JSON.parse(props.map.data.tiles);

    let isDialogFormOpen = ref(false);

    let {
      canvasSize,
      tilesetSource,
      currentLayer,
      layers,
    } = useCanvas(tiles);

    const openMapItemDialog = function() {
      isDialogFormOpen.value = true;
    }

    const closeMapItemDialog = function() {
      isDialogFormOpen.value = false;
    }

    const saveMap = function() {
      alert('!!!');
    }

    const backPage = function () {
      window.history.back();
    }

    return {
      canvasSize,
      tilesetSource,
      currentLayer,
      layers,
      isDialogFormOpen,
      openMapItemDialog,
      closeMapItemDialog,
      backPage
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
canvas {
  border: 1px solid black;
}

.canvas-wrapper {
  overflow: scroll;
  width: 100%;
  height: 500px;
}
</style>
