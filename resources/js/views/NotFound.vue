<template>
  <div>
    <v-container>
      <v-alert type="info" prominent>
        This page does not currently exist. <br>
        You can return to the home page by clicking
        <router-link :to="{ name: 'login' }" class="link-router">here</router-link>.
      </v-alert>
    </v-container>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
  name: 'notFound',
})
</script>

<style scoped>
.link-router {
  text-decoration: none;
  color: #fff;
  font-weight: bold;
}

.v-container {
  max-width: max-content;
}
</style>
