<template>
  <v-card elevation="10" rounded="md" :loading="load" :disabled="load">
    <v-card-title class="d-flex align-center">
      <v-icon icon="mdi-lock-reset" color="primary" class="mr-1"></v-icon>
      Nova senha</v-card-title>
    <v-card-text>
      <v-text-field v-model="form.password" color="primary"
        :error-messages="v$.form.password.$errors.map((e: any) => e.$message)" label="Insira sua nova senha"
        :type="showPassword ? 'text' : 'password'" :append-inner-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
        @click:append-inner="showPassword = !showPassword" required>
      </v-text-field>

      <v-text-field v-model="form.password_confirmation"
        :error-messages="v$.form.password_confirmation.$errors.map((e: any) => e.$message)" color="primary"
        label="Repita a nova senha" type="password" required>
      </v-text-field>

      <v-slide-y-transition>
        <v-alert v-if="message" :color="success === false ? 'error' : 'success'" class="text-lg-center">{{
          message }}</v-alert>
      </v-slide-y-transition>
      <v-card-actions>
        <v-col>
          <v-row class="justify-center">
            <v-btn :loading="load" variant="elevated" size="large" color="primary" :disabled="success"
              @click="handleNewPassword()">Atualizar senha</v-btn>
          </v-row>
        </v-col>
      </v-card-actions>
    </v-card-text>
  </v-card>
</template>

<script lang="ts">
import axios from "axios";
import { defineComponent } from "vue";
import useVuelidate from '@vuelidate/core';
import { minLength, required, helpers, sameAs } from '@vuelidate/validators'

import { useAuthStore } from "../../store/Auth";

export default defineComponent({
  name: 'CardFormNewPassword',
  setup() {
    return { auth: useAuthStore(), v$: useVuelidate() }
  },

  data(): {
    form: {
      token: string | string[];
      email: string;
      password: string;
      password_confirmation: string;
    };
    showPassword: boolean;
    success: boolean;
    message: string;
    load: boolean;
  } {
    return {
      form: {
        token: "",
        email: "",
        password: "",
        password_confirmation: "",
      },
      showPassword: false,
      success: false,
      message: "",
      load: false,
    };
  },


  async mounted() {
    this.form.token = this.$route.params.token
    await axios.get('/api/password/reset/' + this.$route.params.token)
      .then((response: { data: { email: string; } }) => {
        this.form.email = response.data.email
      })
      .catch((e: any) => {
        this.message = e.response.data.message
        this.success = false
      })
  },

  validations() {
    return {
      form: {
        password: {
          required: helpers.withMessage('Sua nova senha é necessária', required),
          minLength: helpers.withMessage('Sua nova senha precisa ter 6 ou mais caracteres', minLength(6)),
        },
        password_confirmation: {
          required: helpers.withMessage('É necessário repetir sua nova senha', required),
          sameAsPassword: helpers.withMessage('As senhas são diferentes', sameAs(this.form.password)),
        },
      }
    };
  },

  methods: {
    async handleNewPassword() {
      if (await this.v$.v$alidate()) {
        try {
          this.load = true
          this.message = ""
          await this.auth.newPassword(this.form)
          this.message = "Sucesso! Redirecionando para a tela de login.."
          this.success = true
          setTimeout(() => {
            this.$router.push({ name: 'login' })
          }, 2000)

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
