<template>
  <title>Login - Dev.ly</title>

  <div class="d-flex justify-center">
    <v-col cols="12" md="6" lg="4">
      <t-card icon="mdi-account-plus" title="Register" :load="load" :disabled="load || disabled">
        <t-register-form />
      </t-card>
    </v-col>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import TCard from '@/components/core/TCard.vue';
import TRegisterForm from '@/components/form/RegisterForm.vue'

export default defineComponent({
  name: 'Register',
  components: {
    TRegisterForm,
    TCard,
  },
  data() {
    return {
      load: false,
      disabled: false,
    }
  }
})
</script>

<style scoped>
</style>
