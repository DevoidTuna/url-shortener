<template>
  <t-text-input
    v-model="modelValue"
    @input="[$emit('update:modelValue', $event.target.value), isValid()]"
    type="text"
    :error-messages="submitted ? v$.modelValue.$silentErrors.map((e: any) => e.$message) : ''"
    prepend-inner-icon="mdi-email"
    label="E-mail"
    placeholder="email@example.com" />
</template>

<script lang="ts">
import TTextInput from './TTextInput.vue';
import { defineComponent } from 'vue';

import { useVuelidate } from '@vuelidate/core';
import { required, helpers, email } from '@vuelidate/validators';

export default defineComponent({
  name: 'TEmailInput',
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
      modelValue: "",
    }
  },
  validations() {
    return {
      modelValue: {
        required: helpers.withMessage('Your email is required', required),
        email: helpers.withMessage('Enter a valid e-mail', email),
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
