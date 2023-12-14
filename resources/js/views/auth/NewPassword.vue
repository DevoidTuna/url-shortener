<template>
  <head>
    <title>Recuperação de senha</title>
  </head>
  <div>
    <v-container v-if="status === 0" class="form-new-password">
      <LoadingGrid />
    </v-container>
    <v-slide-y-transition>
      <v-container v-if="status === 1" class="form-new-password">
        <v-col cols="5" class="cont-dad">
          <CardFormNewPassword />
        </v-col>
      </v-container>
      <v-container v-if="status === -1" class="form-new-password">
        <v-alert class="font" prominent border="end" elevation="2" icon="mdi-alert-circle">
          Token não encontrado ou recuperação de senha já realizada. Tente acessar seu perfil na
          <router-link class="link-router" :to="{ name: 'login' }">página de login</router-link>
          ou
          <router-link class="link-router" :to="{ name: 'resetPassword' }">redefina sua senha</router-link>.
          Se o problema persistir, entre em contato com o suporte.</v-alert>
      </v-container>
    </v-slide-y-transition>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import axios from 'axios';

// import CardFormNewPassword from '@/components/cards/CardFormNewPassword.vue';
// import LoadingGrid from '@/components/loadings/LoadingGrid.vue';

export default defineComponent({
  name: "NewPassword",
  components: {
    // CardFormNewPassword,
    // LoadingGrid,
  },

  data() {
    return {
      status: 0,
    }
  },

  async created() {
    try {
      await axios.get('/api/password/reset/' + this.$route.params.token)
      this.status = 1
    } catch (e) {
      this.status = -1
    }
  },
})
</script>

<style scoped>
.v-alert {
  max-width: 700px;
}

.form-new-password {
  display: flex;
  justify-content: center;
}

.cont-dad {
  min-width: 370px;
  max-width: 500px;
}

.link-router {
  text-decoration: none;
  color: #1E88E5;
}
</style>
