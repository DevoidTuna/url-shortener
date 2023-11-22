<template>
  <v-btn
    :variant="variant"
    :rounded="rounded"
    v-bind="$attrs"
    :type="type"
    :loading="loader"
  >
    <slot />
  </v-btn>
</template>

<script lang="ts">
import { defineComponent, PropType } from 'vue'

export default defineComponent({
  name: 'TButton',
  props: {
    variant: {
      type: String as PropType<"elevated" | "flat" | "text" | "tonal" | "outlined" | "plain">,
      default: 'elevated' as "elevated",
    },
    rounded: {
      type: String,
      default: 'md'
    },
    type: {
      type: String,
    },
    loader: {
      type: Boolean,
      default: false,
    }
  }
})
</script>
