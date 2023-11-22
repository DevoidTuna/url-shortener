<template>
  <t-text-input
    v-model:model-value="modelValue"
    @input="[$emit('update:modelValue', $event.target.value), isValid()]"
    :type="showPassword ? 'text' : 'password'"
    :error-messages="submitted ? v$.modelValue.$silentErrors.map((e: any) => e.$message) : ''"
    :append-inner-icon="showPassword ? 'mdi-eye-off' : 'mdi-eye'"
    @click:append-inner="showPassword = !showPassword"
    prepend-inner-icon="mdi-key-variant"
    label="Password"
  />
</template>

<script lang="ts">
import TTextInput from './TTextInput.vue';
import { defineComponent } from 'vue';

import { useVuelidate } from '@vuelidate/core';
import { required, minLength, helpers } from '@vuelidate/validators';

export default defineComponent({
  name: 'TPasswordInput',
  components: {
    TTextInput
  },
  props: {
    submitted: {
      type: Boolean,
      default: false,
    },
  },
  setup() {
    return { v$: useVuelidate() }
  },
  data() {
    return {
      showPassword: false,
      modelValue: "",
    }
  },
  validations() {
    return {
      modelValue: {
        required: helpers.withMessage('Your password is required', required),
        minLength: helpers.withMessage('Your password must contain at least 6 characters', minLength(6))
      },
    }
  },
  methods: {
    isValid() {
      this.$emit('validation', !this.v$.modelValue.$invalid)
    }
  }
})
</script>
