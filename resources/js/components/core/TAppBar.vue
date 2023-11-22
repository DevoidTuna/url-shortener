<template>
  <nav>
    <v-app-bar v-if="!isMobile" app color="primary" height="86">
      <v-row no-gutters justify="center">
        <v-col cols="12" lg="8" class="v-toolbar__content d-flex justify-space-between" style="height: 44px">
          <v-toolbar-title>
            <router-link :to="{ name: 'home' }">
              <v-img width="165px" :src="logo"></v-img>
            </router-link>
          </v-toolbar-title>

          <v-spacer />

          <v-toolbar-items class="d-flex align-center">
            <v-btn v-for="menu in menus" :key="menu.label" @click="menu.callback">
              <div>
                <v-icon :icon="menu.icon"></v-icon>
                {{ menu.label }}
              </div>
            </v-btn>
          </v-toolbar-items>
        </v-col>
      </v-row>
    </v-app-bar>
    <div v-else>
      <v-app-bar app color="primary" elevation="3">
        <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>

        <v-spacer />

        <v-app-bar-title>
          <router-link :to="{name: 'home'}">
            <v-img height="42px" :src="logo"></v-img>
          </router-link>
        </v-app-bar-title>

        <v-spacer />

        <v-btn v-if="!logged" icon @click="() => $router.push({name: 'login'})">
          <v-icon icon="mdi-account"></v-icon>
        </v-btn>
        <v-btn v-else icon @click="$router.push({name: 'profile'})">
          <v-icon icon="mdi-account"></v-icon>
        </v-btn>
      </v-app-bar>

      <v-navigation-drawer v-model="drawer" app left>
        <v-toolbar flat dense color="tertiary">
          <v-toolbar-title v-if="auth.nickname">Hi,
            {{ auth.nickname }}!
          </v-toolbar-title>
          <v-toolbar-title v-else> </v-toolbar-title>
        </v-toolbar>
        <v-list nav dense>
          <v-list-item v-model="menu">
            <v-list-item v-for="{ label, icon, callback } in menus" :key="label" @click="
              drawer = false;
            callback();
            ">
              <v-list-item-title>
                <v-icon size="x-large" :icon="icon"></v-icon>
                {{ label }}
              </v-list-item-title>
            </v-list-item>
          </v-list-item>
        </v-list>
      </v-navigation-drawer>
    </div>
  </nav>
</template>

<script lang="ts">
import { defineComponent } from "vue";

import { AppBarItem } from "@/types/AppBarItem";
import { useAuthStore } from "@/store/Auth.js";
import logo from "@/assets/logo/logo-white.png"

export default defineComponent({
  name: "TAppBar",
  data() {
    return {
      menu: null,
      drawer: false,
      modal: false,
      logo: logo,
    };
  },
  setup() {
    return { auth: useAuthStore() };
  },
  computed: {
    isMobile(): boolean {
      return this.$vuetify.display.smAndDown;
    },
    logged(): boolean {
      return !!this.auth.id;
    },
    menus(): AppBarItem[] {
      if (this.isMobile) {
        return [
          {
            label: "My / Create Url's",
            icon: "mdi-link",
            callback: () => this.$router.push({name: 'profile'}),
            condition: !!this.auth.id,
          },
          {
            label: "Login",
            icon: "mdi-account",
            callback: () => this.$router.push({name: 'login'}),
            condition: !this.auth.id,
          },
          {
            label: "Register",
            icon: "mdi-account-plus",
            callback: () => this.$router.push({name: 'register'}),
            condition: !this.auth.id,
          },
          {
            label: `Hi, ${this.auth.nickname}!`,
            icon: "mdi-account",
            callback: () => this.$router.push({name: 'profile'}),
            condition: !!this.auth.id,
          },
          {
            label: `Logout`,
            icon: "mdi-logout-variant",
            callback: () => {
              this.auth.logout();
              this.$router.push({name: 'home'});
            },
            condition: !!this.auth.id,
          },
        ].filter((item: AppBarItem) => item.condition);
      }
      else {
        return [
          {
            label: "My / Create Url's",
            icon: "mdi-link-variant",
            callback: () => this.$router.push({name: 'profile'}),
            condition: !!this.auth.id,
          },
          {
            label: "Register",
            icon: "mdi-account-plus",
            callback: () => this.$router.push({name: 'register'}),
            condition: !this.auth.id,
          },
          {
            label: "Login",
            icon: "mdi-account",
            callback: () => this.$router.push({name: 'login'}),
            condition: !this.auth.id,
          },
          {
            label: `Hi, ${this.auth.nickname}!`,
            icon: "mdi-account",
            callback: () => this.$router.push({name: 'profile'}),
            condition: !!this.auth.id,
          },
          {
            label: `Logout`,
            icon: "mdi-logout-variant",
            callback: () => {
              this.auth.logout();
              this.$router.push({name: 'home'});
            },
            condition: !!this.auth.id,
          },
        ].filter((item: AppBarItem) => item.condition);
      }
    },
  },
});
</script>
