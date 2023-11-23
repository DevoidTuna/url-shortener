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
import { axios } from '@/services/axios';

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
      submitted: true,
      modelValue: "",
      uniqueNickname: true,
    }
  },
  validations() {
    return {
      modelValue: {
        required: helpers.withMessage('Your Nickname is required', required),
        minLength: helpers.withMessage('Your Nickname must have more than 2 digits', minLength(3)),
        checkUnique(value: string) {
          if (value === '' || value.length < 3) return new Promise((resolve) => resolve(true))

          const result = new Promise((resolve, reject) => {
            try {
              axios.get(`/api/user/check/nickname/${value}`)
              resolve(result.data.avaliable)
            } catch (error) {
              reject(false)
            }
          })
        }
      },
    }
  },
  methods: {
    isValid() {
      this.$emit('validation', !this.v$.modelValue.$pending)
    },
  }
})
</script>
