<template>
  <v-form @submit.prevent>
    <t-email-input
      :submitted="submit"
      v-model="form.email"
      @validation="(n) => validation.email = n"
    />
    <t-password-input
      :submitted="submit"
      v-model="form.password"
      @validation="(n) => validation.password = n"
    />
    <v-col>
      <v-row class="justify-space-between">
        <v-col class="pa-0 align-start d-flex flex-column">
          <t-button class="mb-1" color="secondary" size="small" variant="text" :to="{ name: 'register' }">
            Register
          </t-button>
          <t-button class="mb-3" color="secondary" size="small" variant="text" :to="{ name: 'resetPassword' }">
            Forgot your password?
          </t-button>
        </v-col>
        <v-col class="pa-0 justify-end align-end d-flex flex-column">
          <t-button class="mb-4" :loader="load" type="submit" @submit.prevent size="large" @click="handleLogin()">
            Login
          </t-button>
        </v-col>
      </v-row>
    </v-col>
  </v-form>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

import TEmailInput from '../core/TEmailInput.vue';
import TPasswordInput from '../core/TPasswordInput.vue';
import TButton from '../core/TButton.vue';

import { useAuthStore } from "../../store/Auth";
import { formValidation } from '../validators/validation';

export default defineComponent({
  name: 'LoginForm',
  components: {
    TEmailInput,
    TPasswordInput,
    TButton,
  },
  setup() {
    return { auth: useAuthStore() }
  },
  data() {
    return {
      submit: false,
      form: {
        email: "",
        password: "",
      },
      validation: {
        email: false,
        password: false,
      },
      load: false,
    };
  },
  methods: {
    async handleLogin(): Promise<void> {
      this.submit = true
      if (formValidation(this.validation)) {
        try {
          this.load = true
          await this.auth.login(this.form.email, this.form.password)
          this.snackbar.show('Login successfully', 'success')
          await this.$router.push({ name: 'home' })
        } catch (e: unknown) {
          this.snackbar.show("There was an error while logging in.", "error")
          console.log(e)
        } finally {
          this.load = false
        }
      } else {
        this.snackbar.show('Check all fields!', 'warning')
      }
    },
  },
})
</script>
