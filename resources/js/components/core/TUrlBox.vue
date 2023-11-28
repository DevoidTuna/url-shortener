<template>
  <div>
    <v-slide-y-transition>
      <v-row class="row-dad" v-show="visibility">

      </v-row>
    </v-slide-y-transition>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue'

import { useLinkStore } from '@/store/Link'
import { useAuthStore } from '@/store/Auth'

import { Link } from '@/types/Link'
import { PropType } from 'vue'

export default defineComponent({
  name: 'TUrlBox',
  props: {
    link: {
      required: true,
      type: Object as PropType<Link>
    },
    userProfile: {
      required: true,
      type: Boolean as PropType<boolean>,
      default: true,
    }
  },
  setup() {
    return {
      link: useLinkStore(),
      auth: useAuthStore(),
    }
  },
  data() {
    return {
      destroy: {
        load: false,
      },

      visibility: true,
      copyText: 'COPY',
      site: "",
      editUrl: false,
      newUrlEdited: {
        id: this.$props.link.id,
        user_id: this.$props.link.user_id,
        shortened_link: this.$props.link.shortened_link,
        message: "",
        error: false,
        load: false,
      },

    }
  },
  created() {
    this.site = window.location.origin.split('://')[1]
  },
  methods: {
    copyUrl() {
      try {
        navigator.clipboard.writeText(this.site + '/r/' + this.link.shortened_link)
        this.copyText = 'COPIED!'
        window.setTimeout(() => {
          this.copyText = 'COPY'
        }, 1500)
      } catch (e) {
        console.log("cant copy de link.")
      }
    },

    async handleDestroy() {
      try {
        this.destroy.load = true
        await this.link.destroy(this.link)
        this.visibility = false
        this.$emit('delete', 1)
      } catch (e: any) {
        console.log(e)
        if (e.response.data.message) {
          throw e.response.data.message
        } else {
          throw 'Something went wrong. Try again later'
        }
      } finally {
        this.destroy.load = false
      }
    },

    async handleCheckCustomUrl() {
      if (this.link.shortened_link && this.newUrlEdited.shortened_link !== this.link.shortened_link) {
        try {
          await this.link.checkCustomUrl(this.newUrlEdited.shortened_link)
          this.newUrlEdited.message = ''
          this.newUrlEdited.error = false
          return true
        } catch (e) {
          this.newUrlEdited.message = 'This URL is aready in use'
          this.newUrlEdited.error = true
          return false
        }
      } else {
        this.newUrlEdited.message = ''
        this.newUrlEdited.error = false
        return true
      }
    },

    async handleEditUrl() {
      this.newUrlEdited.load = true
      if ((await this.handleCheckCustomUrl()) && !this.newUrlEdited.error) {
        if (this.newUrlEdited.shortened_link != this.$props.link.shortened_link) {
          try {
            const response = await this.link.edit(this.newUrlEdited)
            console.log(response)
            this.$props.link.shortened_link = response.shortened_link
            this.newUrlEdited.shortened_link = response.shortened_link
          } catch (e) {
            this.newUrlEdited.message = 'Something went wrong. Try again later'
            this.newUrlEdited.error = true
          }
        }
      }
      this.editUrl = false
      this.newUrlEdited.load = false
    }
  },
})
</script>

<style scoped>
</style>
