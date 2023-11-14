import { RouteRecordRaw } from 'vue-router';

const routes: Readonly<RouteRecordRaw[]> = [
  {
    path: '/login',
    name: 'login',
    component: () => import('../views/auth/Login.vue'),
  },
  {
    path: '/register',
    name: 'register',
    component: () => import('../views/auth/Register.vue'),
  },
  {
    path: '/password/reset',
    name: 'resetPassword',
    component: () => import('../views/auth/ResetPassword.vue'),
  }
];

export default routes.map((route) => {
  const meta = { requiresNoAuth: true }
  return { ...route, meta }
})
