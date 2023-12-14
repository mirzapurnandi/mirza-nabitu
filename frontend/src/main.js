import { createApp } from "vue";
import App from "./App.vue";
import router from "./router.js";
import store from "./store.js";

const app = createApp(App).use(router).use(store);
app.mount("#purnand");
