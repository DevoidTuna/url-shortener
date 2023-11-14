<template>
  <v-app>
    <t-snackbar />
    <!-- <the-drawer />
    <the-app-bar/>
    <the-dialog ref="dialog" />
    <v-main>
      <v-container fluid>
        <router-view v-slot="{ Component }">
          <v-fade-transition>
            <component :is="Component" />
          </v-fade-transition>
        </router-view>
      </v-container>
    </v-main> -->
  </v-app>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import TSnackbar from './components/core/TSnackbar.vue';

export default defineComponent({
  components: {
    TSnackbar,
}
})
</script>

<style scoped>
.logo {
  height: 6em;
  padding: 1.5em;
  will-change: filter;
  transition: filter 300ms;
}
.logo:hover {
  filter: drop-shadow(0 0 2em #646cffaa);
}
.logo.vue:hover {
  filter: drop-shadow(0 0 2em #42b883aa);
}
</style>
