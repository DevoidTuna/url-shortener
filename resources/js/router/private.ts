import { RouteRecordRaw } from 'vue-router';

const routes: Readonly<RouteRecordRaw[]> = [
  {
    path: '/profile',
    name: 'profile',
    component: () => import('../views/auth/Profile.vue')
  },
  {
    path: '/profile/edit',
    name: 'editProfile',
    component: () => import('../views/auth/EditProfile.vue')
  },
];

export default routes.map((route) => {
  const meta = { requiresAuth: true }
  return { ...route, meta }
})
