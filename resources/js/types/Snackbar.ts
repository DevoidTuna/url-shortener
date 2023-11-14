type SnackbarTypes = {
  visible?: boolean;
  message: string;
  timeout: number;
  type: 'success' | 'info' | 'warning' | 'error';
}
declare module '@vue/runtime-core' {
  interface ComponentCustomProperties {
    snackbar: {
      show(message: string, type: "success" | "info" | "warning" | "error", timeout?: number): void;
      fromAxiosResponse(response: any): void;
    };
  }
}

export default SnackbarTypes;
