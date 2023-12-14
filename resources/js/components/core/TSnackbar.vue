<template>
  <v-snackbar
    v-model="snackbar.visible"
    location="top"
    :color="snackbar.type"
    :timeout="snackbar.timeout"
    elevation="24"
  >
    <v-row class="d-flex flex-row align-center">
      <v-col cols="1">
        <v-icon
          size="large"
          :icon="`${icons[snackbar.type]}`"
          density="compact"
        />
      </v-col>
      <v-col>
        {{ snackbar.message }}
      </v-col>
    </v-row>
  </v-snackbar>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { useSnackBar } from '@/store/Snackbar';

export default defineComponent({
  data() {
    return {
      snackbar: useSnackBar(),
      icons: {
        success: 'mdi-check-decagram',
        info: 'mdi-information',
        warning: 'mdi-alert',
        error: 'mdi-alert-circle'
      }
    }
  }
})
</script>
