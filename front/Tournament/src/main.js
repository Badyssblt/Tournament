import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import titleMixins from "./mixins/titleMixins";
const app = createApp(App);

import './index.css'


app.use(router);
app.mixin(titleMixins);

app.mount("#app");
