<template>
  <t-text-input
    v-model="modelValue"
    @input="[$emit('update:modelValue', $event.target.value), checkUnique(), isValid()]"
    type="text"
    :error-messages="submitted ? v$.modelValue.$silentErrors.map((e: any) => e.$message) : ''"
    prepend-inner-icon="mdi-alpha-n-box-outline"
    label="Nickname"
  />
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
        async: helpers.withMessage('Nickname aready in use', helpers.withAsync(() => {return this.checkUnique})),
      },
    }
  },
  methods: {
    isValid() {
      this.$emit('validation', !this.v$.modelValue.$invalid)
    },
    async checkUnique(): Promise<boolean> {
      try {
        const response = await this.axios.get(`/api/user/check/nickname/${this.modelValue}`)
        return this.uniqueNickname = response.data.avaliable
      } catch (error) {
        return this.uniqueNickname = false
      }
    }
  }
})
</script>
