import { ref, reactive, onMounted } from 'vue';

export default function useCanvas() {

  //Canvas
  let canvas = ref(null);
  let ctx = ref(null);
  let canvasSize = reactive({ height: 480, width: 960 });

  //Tileset
  let tilesetImg = reactive(null);
  let tilesetWrapper = ref(null);
  let tilesetSelection = reactive(null);
  let tilesetSource = ref('');

  //menu tile
  let selection = reactive([0, 0]);

  //mouse
  let isMouseDown = ref(false);

  //layers
  let layers = reactive([{},{},{}]);
  let currentLayer = ref(0);

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
    layers.map((el, i) => {
      layers[i] = {};
    });
    draw();
  }

  onMounted(() => {
    //canvas
    canvas = document.querySelector('canvas');
    ctx = canvas.getContext('2d');

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

  });

  return {
    canvasSize,
    tilesetSource,
    currentLayer,
    layers,
    setLayer,
    clearCanvas
  }
}
