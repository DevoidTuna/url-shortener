<template>
  <head>
    <title>{{ auth.nickname }} - Dev.ly</title>
  </head>
  <div>
    <v-row class="d-flex justify-center">
      <v-col class="pb-0" cols="12" md="6" lg="4">
        <v-scroll-y-transition group>
          <h2 v-if="links" :key="0"><v-icon icon="mdi-link-variant"></v-icon>
            {{ auth.nickname + ' URLs' }}
          </h2>
          <t-url-box :userProfile="true" :link="link" v-for="(link, index) in links" :key="index" />
        </v-scroll-y-transition>
      </v-col>
    </v-row>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

import { useAuthStore } from '../../store/Auth';
import { useLinkStore } from '../../store/Link';
import TUrlBox from '@/components/core/TUrlBox.vue'
import TUrlBoxOld from '@/components/core/TUrlBoxOld.vue'
import { User } from '@/types/User';
import { Link } from '@/types/Link';

export default defineComponent({
  name: 'Profile',
  components: {
    TUrlBox,
    TUrlBoxOld,
  },
  setup() {
    return {
      auth: useAuthStore(),
      link: useLinkStore(),
    }
  },
  data() {
    return {
      links: [] as Link[],
      loadingUrls: true,

      user: {} as User,
    }
  },
  async mounted() {
    await this.getUrls()
  },
  methods: {
    async getUrls() {
      this.loadingUrls = true
      try {
        const response = await this.link.index()
        this.links = response
      } catch (e) {
        // throw this.error = e
      } finally {
        this.loadingUrls = false
      }
    },
  }
})
</script>

<style scoped>
</style>
