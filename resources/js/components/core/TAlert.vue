<template>
  <v-slide-y-transition>
    <v-alert v-if="show" :color="color" class="text-center mb-2">
      <slot />
    </v-alert>
  </v-slide-y-transition>
</template>

<script lang="ts">
import { defineComponent } from 'vue'

export default defineComponent({
  props: {
    show: {},
    color: {
      type: String,
      required: true,
    },
  },
})
</script>

<style scoped>
</style>
