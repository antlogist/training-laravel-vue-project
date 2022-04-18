import { ref, reactive, onMounted } from 'vue';

export default function useCanvas(tiles) {
  //Canvas
  let canvas = reactive({});
  let ctx = reactive({});
  let canvasSize = reactive({ height: 960, width: 960 });

  //Tileset
  let tilesetImg = reactive({});
  let tilesetSource = ref('');

  //mouse
  let isMouseDown = ref(false);

  //layers
  let layers = reactive(tiles);
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
  function tileEvent() {
    const clicked = getCoordinates(event);
    const key = clicked[0] + "-" + clicked[1];

    for(let i=0; i < layers.length; i++) {
      if(i === 0) {
        console.log('bottom layer', layers[i][key]);
      }  else if (i === 1) {
        console.log('middle layer', layers[i][key]);
      } else {
        console.log('top layer', layers[i][key]);
      }
    }
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

    //set tileset source
    tilesetSource.value = 'https://assets.codepen.io/21542/TileEditorSpritesheet.2x_2.png';

    //get tilesetImg
    tilesetImg = document.querySelector('#tilesetSource');

  });

  setTimeout(()=>{
    draw();
  }, 1000);

  return {
    canvasSize,
    tilesetSource,
    currentLayer,
    layers,
    ctx,
    draw,
    setLayer,
    clearCanvas
  }
}
