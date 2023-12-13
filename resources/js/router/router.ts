import { RouteRecordRaw, createRouter, createWebHistory } from "vue-router";
import publicRoutes from './public';
import privateRoutes from './private';
import guestRoutes from './guest';
import { useAuthStore } from "../store/Auth";

let routes: Readonly<RouteRecordRaw[]> = publicRoutes.concat(privateRoutes);
routes = routes.concat(guestRoutes);
const router = createRouter({
  history: createWebHistory('/'),
  routes,
});

router.beforeEach((to, _from, next) => {
  const privateRoute = to.matched.some(record => record.meta.requiresAuth);
  const guestRoute = to.matched.some(record => record.meta.requiresNoAuth);
  const authStore = useAuthStore();

  if (privateRoute) {
    if (!authStore.accessToken || authStore.accessToken === '') {
      next('/login');
    } else {
      next();
    }
  } else if ((guestRoute && !authStore.accessToken) || (!guestRoute && !privateRoute)) {
    next();
  } else {
    next('/profile');
  }
});

export default router;
