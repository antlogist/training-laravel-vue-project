import { ref, reactive, onMounted } from 'vue';

export default function useCanvas(tiles) {

  //Context menu
  let isDialogFormOpen = ref(false);

  //Canvas
  let canvas = reactive({});
  let ctx = reactive({});
  let canvasSize = reactive({ height: 960, width: 960 });

  //Tileset
  let tilesetImg = reactive({});
  let tilesetWrapper = ref(null);
  let tilesetSelection = reactive({});
  let tilesetSource = ref('');

  //menu tile
  let selection = reactive([0, 0]);

  //mouse
  let isMouseDown = ref(false);

  //layers
  let layers = reactive(tiles);
  let currentLayer = ref(0);

  //dialog
  let dialogMode = ref(null);
  let dialogNoteId = ref(null);
  let dialogExtraMapId = ref(null);

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

        function drawImage() {
          ctx.drawImage(
            tilesetImg,
            tilesheetX * 32, tilesheetY * 32, //top left corner of the grab
            sizeOfCrop, sizeOfCrop, //how big of a grab
            positionX * 32, positionY * 32, //where the crop to be placed
            sizeOfCrop, sizeOfCrop //size of placement what was grabbed
          );
        }

        if(tilesetImg.complete) {
          drawImage();
        } else {
          tilesetImg.onload = function() {
            drawImage();
          }
        }
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
  function tileEvent(mouseEvent, noteId = '', extraMapId = '') {
    const clicked = getCoordinates(event);
    const key = clicked[0] + "-" + clicked[1];

    function getDialogMode() {
      for(let i=layers.length - 1; i >= 0; i--) {
        if (layers[i][key]) {
          dialogMode.value = i;
          dialogNoteId.value = layers[i][key][2];
          dialogExtraMapId.value = layers[i][key][3];
          return;
        }
        dialogMode.value = null;
      }
    }

    if (mouseEvent.shiftKey) {
        delete layers[currentLayer.value][key];
    } else if(mouseEvent.ctrlKey) {
        layers[currentLayer.value][key] = [selection[0], selection[1], noteId, extraMapId];
    } else {
      //Open dialog
      getDialogMode();
      if (dialogMode.value === null) {
        return;
      }
      isDialogFormOpen.value = true;
    }
    draw();
  }

  function clearCanvas() {
    layers.map((el, i) => {
      layers[i] = {};
    });
    draw();
  }

  onMounted(() => {

    //canvas
    canvas = document.querySelector('canvas');
    const getCtx = new Promise((resolve, reject) => {
      resolve(canvas.getContext('2d'));
    });

    getCtx.then((value) => {
      ctx = value;
      // draw();
    });

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
    canvas.addEventListener("mousedown", tileEvent);
    canvas.addEventListener("mousemove", (event) => {
      if (isMouseDown.value) {
          tileEvent(event);
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
    tilesetSource.value = document.location.origin + '/images/tiles.png';

    //get tilesetImg
    tilesetImg = document.querySelector('#tilesetSource');

  });

  setTimeout(() => {
    draw();
  },1000)

  return {
    canvasSize,
    tilesetSource,
    currentLayer,
    layers,
    ctx,
    isDialogFormOpen,
    dialogMode,
    dialogNoteId,
    dialogExtraMapId,
    draw,
    setLayer,
    clearCanvas
  }
}
