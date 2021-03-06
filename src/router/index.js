import { createWebHashHistory, createRouter } from "vue-router";
import Home from "../pages/Home.vue";
import ContactManager from "../pages/ContactManager.vue";
import AddContact from "../pages/AddContact.vue";
import EditContact from "../pages/EditContact.vue";
import ViewContact from "../pages/ViewContact.vue";
import PageNotFound from "../pages/PageNotFound.vue";
import CustomShortcode from "../pages/CustomShortcode.vue";

const routes = [
  {
    path: "/",
    name: "Home",
    redirect: "/contacts",
    component: Home,
  },
  {
    path: "/settings",
    name: "CustomShortcode",

    component: CustomShortcode,
  },
  {
    path: "/contacts/",
    name: "ContactManager",
    component: ContactManager,
  },
  {
    path: "/contacts/add",
    name: "AddContact",
    component: AddContact,
  },
  {
    path: "/contacts/edit/:contactId",
    name: "EditContact",
    component: EditContact,
  },
  {
    path: "/contacts/view/:contactId",
    name: "ViewContact",
    component: ViewContact,
  },
  {
    path: "/:pathMatch(.*)*",
    name: "PageNotFound",
    component: PageNotFound,
  },
];

const router = createRouter({
  history: createWebHashHistory(),
  routes,
});

export default router;
