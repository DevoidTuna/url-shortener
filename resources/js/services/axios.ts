import axios from "axios";
import VueAxios from "vue-axios";
import { useAuthStore } from "../store/Auth";
import router from "../router/router";

axios.defaults.headers.common['Content-Type'] = "application/json";

axios.interceptors.request.use((config) => {
  const authStore = useAuthStore();

  config.headers.Authorization = `Bearer ${authStore.accessToken ?? ''}`;

  return config;
});

axios.interceptors.response.use(function (response) {
  return response;
}, function (error) {
  if(error.response.status === 401 && error.response.data.message === 'Unauthenticated.') {
    const authStore = useAuthStore();

    authStore.$patch({ accessToken: null });
    router.push('/login');
  }
  return Promise.reject(error);
});

export {axios, VueAxios};
