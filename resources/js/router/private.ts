import { RouteRecordRaw } from 'vue-router';

const routes: Readonly<RouteRecordRaw[]> = [
  {
    path: '/profile',
    name: 'profile',
    component: () => import('./pages/Profile.vue')
  },
  {
    path: '/profile/edit',
    name: 'editProfile',
    component: () => import('./pages/EditProfile.vue')
  },
];

export default routes.map((route) => {
  const meta = { requiresAuth: true }
  return { ...route, meta }
})
