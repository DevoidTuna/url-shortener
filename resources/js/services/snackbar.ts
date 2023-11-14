import { useSnackBar } from '../store/Snackbar';

const snackbarStore = useSnackBar();

const snackbar = {
  show: (message: string, type: 'success' | 'info' | 'warning' | 'error', timeout: number = 3000) => {
    snackbarStore.show(message, type, timeout );
  },

  fromAxiosResponse(response: any) {
    const type = response.status < 400 ? 'success' : 'error';
    const message: string = response.data.message;

    this.show(message, type, 3000);
  }
}

export default snackbar;
