<template>
  <t-text-input v-model="modelValue" @input="[$emit('update:modelValue', $event.target.value), isValid()]" type="text"
    :error-messages="submitted ? v$.modelValue.$silentErrors.map((e: any) => e.$message) : ''"
    prepend-inner-icon="mdi-alpha-n-box-outline" label="Nickname" />
</template>

<script lang="ts">
import TTextInput from './TTextInput.vue';
import { defineComponent } from 'vue';

import { useVuelidate } from '@vuelidate/core';
import { required, helpers, minLength } from '@vuelidate/validators';

export default defineComponent({
  name: 'TNicknameInput',
  components: {
    TTextInput
  },
  setup() {
    return { v$: useVuelidate() }
  },
  data() {
    return {
      submitted: false,
      modelValue: "",
      unique: true,
    }
  },
  validations() {
    return {
      modelValue: {
        required: helpers.withMessage('Your Nickname is required', required),
        minLength: helpers.withMessage('Your Nickname must have more than 2 digits', minLength(3)),
        unique: helpers.withMessage('Nickname aready in use', () => !!this.unique)
      },
    }
  },
  methods: {
    async isValid() {
      this.unique = await this.checkUnique(this.modelValue)
      this.$emit('validation', (!this.v$.modelValue.$pending && this.unique))
    },
    async checkUnique(value: string) {
      if (value.length > 2) {
        try {
          if (!this.submitted) this.submitted = true
          const result = await this.axios.get(`/api/user/check/nickname/${value}`)
          return result.data.avaliable
        } catch (error) {
          return false
        }
      }
    }
  }
})
</script>
