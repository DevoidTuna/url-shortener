<template>
 <head>
    <title>Reset Password - Dev.ly</title>
  </head>
  <div class="d-flex justify-center">
    <v-col cols="12" md="6" lg="4">
      <t-card icon="mdi-lock-reset" title="Reset Password">
        <t-reset-password-form/>
      </t-card>
    </v-col>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import TResetPasswordForm from '@/components/form/ResetPasswordForm.vue'
import TCard from '@/components/core/TCard.vue';

export default defineComponent({
  name: "ResetPassword",
  components: {
    TResetPasswordForm,
    TCard,
  },
})
</script>

<style scoped>
</style>
