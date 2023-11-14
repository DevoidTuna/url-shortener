import { RouteRecordRaw } from 'vue-router';
// import Login from '../views/auth/login.vue';

const routes:Readonly<RouteRecordRaw[]> = [
  {
    path: '/',
    name: 'home',
    component: () => import('./pages/Home.vue'),
  },
  {
    path: '/user/:id',
    name: 'user',
    component: () => import('./pages/User.vue'),
  },
  {
    path: '/not-found',
    name: 'notFound',
    component: () => import('./pages/NotFound.vue'),
  },
  {
    path: '/password/new/:token',
    name: 'newPassword',
    component: () => import('./pages/NewPassword.vue'),
  },
];

export default routes.map((route) => {
  const meta = { requiresAuth: false }
  return { ...route, meta }
})
