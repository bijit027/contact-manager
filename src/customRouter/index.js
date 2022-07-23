import { createWebHashHistory, createRouter } from "vue-router";
import CustomHome from "../customPages/CustomHome.vue";
import CustomShortcode from "../customPages/CustomShortcode.vue";

const routes = [
  {
    path: "/",
    name: "CustomHome",
    redirect: "/settings",
    component: CustomHome,
  },
  {
    path: "/settings",
    name: "CustomShortcode",
    component: CustomShortcode,
  },
];

const router = createRouter({
  history: createWebHashHistory(),
  routes,
});

export default router;
