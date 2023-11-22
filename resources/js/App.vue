<template>
  <v-app>
    <t-snackbar />
    <!-- <the-drawer /> -->
    <t-app-bar app />
    <!-- <the-dialog ref="dialog" />  -->
    <v-main>
      <v-fade-transition hide-on-leave>
        <v-container fluid>
          <router-view v-slot="{ Component }">
            <component :is="Component" />
          </router-view>
        </v-container>
      </v-fade-transition>
    </v-main>
    <t-footer />
  </v-app>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import TSnackbar from './components/core/TSnackbar.vue';
import TFooter from './components/core/TFooter.vue';
import TAppBar from './components/core/TAppBar.vue';

export default defineComponent({
  components: {
    TSnackbar,
    TFooter,
    TAppBar,
  }
})
</script>

<style scoped>
</style>
