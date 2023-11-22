import { RouteRecordRaw } from 'vue-router';
// import Login from '../views/auth/login.vue';

const routes:Readonly<RouteRecordRaw[]> = [
  {
    path: '/',
    name: 'home',
    component: () => import('../views/Home.vue'),
  },
  // {
  //   path: '/user/:id',
  //   name: 'user',
  //   component: () => import('../views/auth/User.vue'),
  // },
  {
    path: '/not-found',
    name: 'notFound',
    component: () => import('../views/NotFound.vue'),
  },
  {
    path: '/password/new/:token',
    name: 'newPassword',
    component: () => import('../views/auth/NewPassword.vue'),
  },
];

export default routes.map((route) => {
  const meta = { requiresAuth: false }
  return { ...route, meta }
})
