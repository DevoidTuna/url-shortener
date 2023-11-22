<template>
  <v-col class="d-flex justify-center v-col-12 v-col-md-5 v-col-lg-4">
    <v-card elevation="10" :loading="load" :disabled="load" class="v-col-12 v-col-md-5 v-col-lg-4" rounded="lg">
      <v-card-title class="d-flex align-center">
        <v-icon icon="mdi-account-edit" color="primary" class="mr-6"></v-icon>
        Editar minhas informações</v-card-title>
      <v-card-text>

        <v-text-field class="mb-6" v-model="form.name" color="primary"
          :error-messages="v$.form.name.$errors.map((e: any) => e.$message)" label="Nome" type="text" maxlength="50"
          required>
        </v-text-field>

        <v-text-field class="mb-6" v-model="form.email" color="primary"
          :error-messages="v$.form.email.$errors.map((e: any) => e.$message)" label="E-mail" type="email"
          placeholder="email@exemplo.com" hint="Seu melhor e-mail" disabled required>
        </v-text-field>

        <v-slide-y-transition>
          <v-alert v-if="message" :color="success ? 'success' : 'error'" class="text-lg-center">{{ message
          }}</v-alert>
        </v-slide-y-transition>
        <v-card-actions>
          <v-col>
            <v-row class="align-center justify-center">
              <v-btn :loading="load" variant="elevated" width="29%" size="large" color="primary"
                @click="handleUpdateUser()">Atualizar</v-btn>
            </v-row>
          </v-col>
        </v-card-actions>
      </v-card-text>
    </v-card>
  </v-col>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import { useVuelidate } from '@vuelidate/core'
import { email, required, minLength, helpers } from '@vuelidate/validators'

import { useAuthStore } from "../../store/Auth";

export default defineComponent({
  name: "CardFormEditProfile",
  setup() {

    return { auth: useAuthStore(), v$: useVuelidate() }
  },
  computed: {
    userName() {
      return this.auth.user.name
    },
    userEmail() {
      return this.auth.user.email
    }
  },
  data() {
    return {
      form: {
        name: '',
        email: '',
      },
      load: false,
      success: false,
      message: "",
    }
  },
  watch: {
    userName(newValue) {
      this.form.name = newValue;
    },
    userEmail(newValue) {
      this.form.email = newValue;
    }
  },
  validations() {
    return {
      form: {
        name: {
          required: helpers.withMessage('Seu nome é necessário', required),
          minLength: helpers.withMessage('Seu nome precisar ter no mínimo 3 letras', minLength(3))
        },
        email: {
          required: helpers.withMessage('Seu e-mail é necessário', required),
          email: helpers.withMessage('Insira um e-mail válido', email),
        },
      }
    }
  },
  methods: {
    async handleUpdateUser() {
      if (await this.v$.v$alidate()) {
        if (
          this.form.name === this.auth.user.name &&
          this.form.email === this.auth.user.email
        ) {
          return this.success = true, this.message = 'Já atualizado!'
        } else {
          try {
            this.message = ""
            this.load = true
            await this.auth.updateUser(this.form)
            this.form.name = this.auth.user.name
            this.form.email = this.auth.user.email
            this.message = "Dados atualizados!"
            this.success = true
          } catch (e: any) {
            this.message = e
          } finally {
            this.load = false
          }
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
