<template>
  <head>
    <title>Meu perfil</title>
  </head>
  <div>
    Meu perfil
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

import { useAuthStore } from '../../store/Auth';
// import LoadingGrid from '../../components/loadings/LoadingGrid.vue'

export default defineComponent({
  name: 'Profile',
  setup() {
    return {
      auth: useAuthStore(),
    }
  },

  components: {
    // LoadingGrid,
  },
})
</script>

<style scoped>
</style>
