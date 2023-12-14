<template>
  <v-form @submit.prevent>
    <t-email-input :disabled="load" :submitted="submit" v-model="form.email" @validation="(n) => validation.email = n" />

    <v-col class="d-flex px-0 justify-space-between align-center">
      <t-button
        color="secondary"
        size="small"
        variant="text"
        :to="{ name: 'login' }"
      >Login</t-button>

      <t-button
        :loader="load"
        type="submit"
        @submit.prevent size="large" @click="handleResetpassword"
      >Reset Password</t-button>
    </v-col>
  </v-form>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

import { useAuthStore } from "@/store/Auth";

import TEmailInput from '@/components/core/TEmailInput.vue';
import TButton from '@/components/core/TButton.vue';

import { formValidation } from '@/components/validators/validation';

export default defineComponent({
  name: 'TResetPasswordForm',
  components: {
    TEmailInput,
    TButton,
  },
  setup() {
    return { auth: useAuthStore() }
  },
  data() {
    return {
      load: false,
      submit: false,
      validation: {
        email: false,
      },
      form: {
        email: "",
      },
    };
  },
  methods: {
    async handleResetpassword() {
      this.submit = true
      if (formValidation(this.validation)) {
        try {
          this.load = true
          await this.auth.resetPassword(this.form)
          .then(() => {
            this.snackbar.show("Success! Check your email inbox.", "success")
          })
          .catch((error) => {
            this.snackbar.fromAxiosResponse(error)
          })
        } catch (e: any) {
          this.snackbar.show("There was an error trying to recover your password.", "error")
        } finally {
          this.load = false
        }
      }
    },
  },
})
</script>
