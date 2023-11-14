import { defineStore } from 'pinia';
import SnackbarTypes from '../types/Snackbar';

export const useSnackBar = defineStore('snackbar', {
  state: () => ({
    visible: false,
    message: '',
    timeout: 10000,
    type: 'success'
  } as SnackbarTypes),

  getters: {},

  actions: {
    show(message: string, type: 'success' | 'info' | 'warning' | 'error', timeout: number = 4000) {
      this.visible = true;
      this.message = message;
      this.timeout = timeout;
      this.type = type;
    },
    fromAxiosResponse(response: any) {
      const type = response.status < 400 ? 'success' : 'error';
      const message: string = response.data.message;

      this.show(message, type, 3000);
    }
  },
});
