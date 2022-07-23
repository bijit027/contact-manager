import { createApp } from "vue";
import Settings from "./Settings.vue";
import customRouter from "./customRouter";
createApp(Settings).use(customRouter).mount("#cm-custom-app");
