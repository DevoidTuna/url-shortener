<template>
  <head>
    <title>{{ auth.nickname }} - Dev.ly</title>
  </head>
  <div>
    <v-row class="d-flex justify-center">
      <v-col class="mb-5" cols="12" md="6" lg="5">
        <v-scroll-y-transition group>
          <t-create-url :key="0" class="mt-2 mb-5" v-show="auth.id" />
            <h2 :key="1" class="mb-2">
              <v-icon icon="mdi-link-variant" />
              {{ auth.nickname + (urls ? ' URLs' : 'has no URLs avaliable') }}
            </h2>
          <t-url-box :userProfile="true" :url="url" v-for="url in urls" :key="url.id" />
        </v-scroll-y-transition>
      </v-col>
    </v-row>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

import { useAuthStore } from '@/store/Auth';
import { useLinkStore } from '@/store/Link';
import TUrlBox from '@/components/core/TUrlBox.vue';
import TUrlBoxOld from '@/components/core/TUrlBoxOld.vue';
import { User } from '@/types/User';
import { Url } from '@/types/Url';
import TCreateUrl from '@/components/core/TCreateUrl.vue';

export default defineComponent({
  name: 'Profile',
  components: {
    TUrlBox,
    TUrlBoxOld,
    TCreateUrl
},
  setup() {
    return {
      auth: useAuthStore(),
      link: useLinkStore(),
    }
  },
  data() {
    return {
      urls: [] as Url[],
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
        this.urls = response
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
