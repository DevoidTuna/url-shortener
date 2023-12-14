<template>
  <v-card elevation="10" rounded="lg" :loading="load" :disabled="load">
    <v-card-title class="d-flex align-center">
      <v-icon icon="mdi-lock-reset" color="primary" class="mr-2"></v-icon>
      Redefinir de senha</v-card-title>
    <v-card-text>
      <v-text-field v-model="form.email" label="E-mail" type="email" color="primary" placeholder="email@exemplo.com"
        :error-messages="v$.form.email.$errors.map((e: any) => e.$message)" required>
      </v-text-field>

      <v-slide-y-transition>
        <v-alert v-if="message" :color="success === false ? 'error' : 'success'" class="text-lg-center">{{
          message }}</v-alert>
      </v-slide-y-transition>
      <v-card-actions>
        <v-col>
          <v-row class="justify-center">
            <v-btn :loading="load" variant="elevated" size="large" color="primary" :disabled="success"
              @click="handleResetPassword()">Redefinir senha</v-btn>
          </v-row>
        </v-col>
      </v-card-actions>
    </v-card-text>
  </v-card>
</template>

<script lang="ts">
import { useAuthStore } from "@/store/Auth";
import useVuelidate from '@vuelidate/core';
import { email, required, helpers } from '@vuelidate/validators'
import { defineComponent } from "vue";

export default defineComponent({
  name: 'CardFormResetPassword',
  setup() {
    return { auth: useAuthStore(), v$: useVuelidate() }
  },

  data() {
    return {
      form: {
        email: "",
      },
      success: false,
      message: "",
      load: false,

    };
  },

  validations() {
    return {
      form: {
        email: {
          required: helpers.withMessage('Seu e-mail é obrigatório', required),
          email: helpers.withMessage('Insira um e-mail válido', email),
        },
      }
    };
  },

  methods: {
    async handleResetPassword() {
      if (await this.v$.v$alidate()) {
        try {
          this.load = true
          this.message = ""
          await this.auth.resetPassword(this.form)
          this.message = "Sucesso! Cheque a caixa de entrada de seu e-mail."
          this.success = true
        } catch (e: any) {
          this.success = false
          this.message = e
        } finally {
          this.load = false
        }
      }
    },
  },
})
</script>

<style scoped>
.v-card-title {
  font-size: 25px;
  padding: 20px 0px 20px 14px;
}
</style>
