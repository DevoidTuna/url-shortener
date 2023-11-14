import "./bootstrap";
import "../sass/main.scss";

import { createApp } from "vue";
import App from "./App.vue";
import { useSnackBar } from "./store/Snackbar";
import vuetify from "./plugins/vuetify";
import piniaPluginPersistedstate from "pinia-plugin-persistedstate";
import { axios, VueAxios } from "./services/axios";
import router from "./router/router";
import { createPinia } from "pinia";

const pinia = createPinia();
pinia.use(piniaPluginPersistedstate);

const app = createApp(App);
app.use(pinia);

const snackbar = useSnackBar();

app.config.globalProperties.snackbar = snackbar;

app.use(router).use(vuetify).use(VueAxios, axios).mount("#app");
