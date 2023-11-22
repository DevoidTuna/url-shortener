<template>
    <v-card
      :elevation="isMobile ? 0 : elevation"
      :loading="load"
      :disabled="load || disabled"
      :rounded="rounded"
      width="100%"
      height="100%"
      class="px-4"
    >
    <v-card-title class="d-flex align-center">
      <v-icon v-if="icon"
      :icon="icon"
      :color="iconColor"
      class="mr-2"></v-icon>
      {{ $props.title }}</v-card-title>

    <slot />
    </v-card>
</template>

<script lang="ts">
import { defineComponent } from "vue";

export default defineComponent({
  name: "TCard",
  props: {
    icon: {
      type: String,
      default: undefined,
    },
    iconColor: {
      type: String,
      default: 'primary',
    },
    title: {
      type: String,
    },
    load: {
      type: Boolean,
      default: false,
    },
    rounded: {
      type: String,
      default: 'lg',
    },
    disabled: {
      type: Boolean,
      default: false,
    },
    elevation: {
      type: String,
      default: '5',
    },
  },
  computed: {
    isMobile(): boolean {
      return this.$vuetify.display.smAndDown;
    },
  }
})
</script>

<style scoped>
.v-card-title {
  font-size: 25px;
  padding: 18px 0px;
}
</style>
