<template>
  <v-form @submit.prevent>
    <t-nickname-input :disabled="load" v-model="form.nickname" @validation="(n) => validation.nickname = n" ref="input" />
    <t-email-input :disabled="load" :submitted="submit" v-model="form.email" @validation="(n) => validation.email = n"
      ref="input" />
    <t-password-input :disabled="load" :submitted="submit" v-model="form.password"
      @validation="(n) => validation.password = n" ref="input" />
    <t-text-input :disabled="load" label="Confirm your password" v-model="form.password_confirmation"
      prepend-inner-icon="mdi-key-variant" :type="showPassword ? 'text' : 'password'"
      :append-inner-icon="showPassword ? 'mdi-eye-off' : 'mdi-eye'" @click:append-inner="showPassword = !showPassword"
      :error-messages="submit ? v$.form.password_confirmation.$silentErrors.map((e: any) => e.$message) : ''" />

    <v-col class="d-flex px-0 justify-space-between align-center">
      <t-button color="secondary" size="small" variant="text" :to="{ name: 'login' }">Login</t-button>

      <t-button :loader="load" type="submit" @submit.prevent size="large" @click="handleRegister">Register</t-button>
    </v-col>
  </v-form>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

import { useAuthStore } from "@/store/Auth";

import TEmailInput from '@/components/core/TEmailInput.vue';
import TPasswordInput from '@/components/core/TPasswordInput.vue';
import TButton from '@/components/core/TButton.vue';
import TNicknameInput from '@/components/core/TNicknameInput.vue';
import TTextInput from '@/components/core/TTextInput.vue';

import { formValidation } from '@/components/validators/validation';
import useVuelidate from '@vuelidate/core';
import { sameAs, helpers } from '@vuelidate/validators';

export default defineComponent({
  name: 'TRegisterForm',
  components: {
    TNicknameInput,
    TEmailInput,
    TPasswordInput,
    TTextInput,
    TButton,
  },
  setup() {
    return { auth: useAuthStore(), v$: useVuelidate() }
  },
  data() {
    return {
      load: false,
      submit: false,
      showPassword: false,
      validation: {
        nickname: false,
        email: false,
        password: false,
      },
      form: {
        nickname: "",
        email: "",
        password: "",
        password_confirmation: "",
      },
    }
  },
  methods: {
    async handleRegister() {
      this.submit = true
      if (formValidation(this.validation) && this.form.password === this.form.password_confirmation) {
        try {
          this.load = true
          await this.auth.register(this.form)
          this.$router.push({ name: 'profile' })
        } catch (e: any) {
          console.log(e)
          this.snackbar.show(e, 'error')
          // this.snackbar.show("There was an error when trying to register", "error")
        } finally {
          this.load = false
        }
      } else {
        this.snackbar.show('Please check all fields!', 'error')
      }
    },
  },
  validations() {
    return {
      form: {
        password_confirmation: {
          sameAs: helpers.withMessage('Passwords do not match', sameAs(this.form.password))
        }
      }
    }
  },
})
</script>
