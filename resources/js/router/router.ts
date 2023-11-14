import { RouteRecordRaw, createRouter, createWebHistory } from "vue-router";
import publicRoutes from './public';
import privateRoutes from './private';
import guestRoutes from './guest';
import { useAuthStore } from "../store/Auth";

const routes: Readonly<RouteRecordRaw[]> = publicRoutes.concat(privateRoutes).concat(guestRoutes);

const router = createRouter({
  history: createWebHistory('/'),
  routes,
});

router.beforeEach((to, _from, next) => {
  const requiresAuth = to.matched.some(record => record.meta.requiresAuth);
  const requiresNoAuth = to.matched.some(record => record.meta.requiresNoAuth);
  const authStore = useAuthStore();

  if(requiresAuth && (!authStore.accessToken || authStore.accessToken === '')) {
    next('/login');
  } else {
    if(requiresNoAuth && (!authStore.accessToken || authStore.accessToken === '')) {
      next('/');
    } else {
      next();
    }
  }
});

export default router;
