<template>
  <title>Login - Dev.ly</title>

  <v-row class="d-flex justify-center">
    <v-col class="pb-0" cols="12" md="6" lg="4">
      <t-alert color="primary" :show="true">
        You need to be logged in to create URL's!
      </t-alert>
    </v-col>
  </v-row>
  <v-row class="d-flex justify-center">
    <v-col cols="12" md="6" lg="4">
      <t-card icon="mdi-account" title="Login">
        <t-login-form />
      </t-card>
    </v-col>
  </v-row>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import TAlert from '@/components/core/TAlert.vue'
import TCard from '@/components/core/TCard.vue';
import TLoginForm from '@/components/form/LoginForm.vue'

export default defineComponent({
  name: "LoginPage",
  components: {
    TAlert,
    TCard,
    TLoginForm,
  },
})
</script>

<style scoped>
.cont-dad {
  min-width: 370px;
  max-width: 500px;
}
</style>
