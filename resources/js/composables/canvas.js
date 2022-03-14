import { ref, reactive } from 'vue';

export default function useCanvas() {

  let canvas = ref(null);
  let layers = reactive([{},{},{}]);
  let ctx = ref(null);
  let canvasSize = reactive({ height: 480, width: 960 });

  return { canvas, layers, ctx, canvasSize }
}
