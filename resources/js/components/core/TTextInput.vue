<template>
  <v-text-field
  :v-model="modelValue"
  @input="$emit('update:modelValue', $event.target.value)"
  :label="label"
  :variant="variant"
  :color="color"
  class="mb-1"
  density="comfortable"
  ></v-text-field>
</template>

<script lang="ts">
import { defineComponent, PropType } from 'vue';
import VariantProp from '@/types/vuetify/variant';

export default defineComponent({
  props: {
    modelValue: {
      type: String,
      default: "",
    },
    label: {
      type: String,
      default: "",
    },
    variant: {
      type: String as PropType<VariantProp>,
      default: "solo-filled"
    },
    color: {
      type: String,
      default: 'primary'
    },
  },
  emits: ['update:modelValue'],
})
</script>
