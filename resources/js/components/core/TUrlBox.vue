<template>
  <div>
    <v-slide-y-transition>
      <v-row v-show="visibility">
        <v-col class="d-flex align-center">
          <v-fade-transition hide-on-leave>
            <t-button elevation="0" v-if="!editUrl" variant="elevated" icon color="white" @click="copyUrl()">
              <v-icon icon="mdi-content-copy" color="primary"></v-icon>
              <v-tooltip activator="parent" location="start">{{ copyText }}</v-tooltip>
            </t-button>
          </v-fade-transition>

          <v-fade-transition hide-on-leave>
            <v-sheet v-if="!editUrl" class="w-75 mx-2 py-1 px-2 d-flex justify-space-between" rounded="xl">
              <div class="d-flex align-center">
                <v-icon v-show="userProfile" class="icon-url-card" size="25"
                  :icon="url.public === 1 ? 'mdi-earth' : 'mdi-lock'" />

                <div class="ml-2 d-flex flex-column">
                  <a :href="'/r/' + url.shortened_link" target="_blank" class="text-decoration-none text-black whitespace-nowrap overflow-hidden">
                    <h3>{{ site + '/r/' + url.shortened_link }}</h3>
                  </a>
                  <small class="recipient-link">{{ url.recipient_link }}</small>
                </div>
              </div>

              <div class="d-flex align-center">
                <v-tooltip activator="parent" color="accent" location="start">{{ url.expired_at ? 'Expires ' +
                  url.expired_at : 'Always available' }}</v-tooltip>
                <v-icon size="25" icon="mdi-clock" color="black">
                </v-icon>
              </div>
            </v-sheet>
          </v-fade-transition>

          <v-fade-transition hide-on-leave>
            <div v-if="editUrl" class="w-100 mx-2" rounded="xl">
                <v-text-field variant="plain" class="bg-white rounded-xl px-4 py-1" clearable counter active
                  @blur="handleCheckCustomUrl()" :error-messages="newUrlEdited.error ? newUrlEdited.message : ''"
                  maxlength="50" prefix="dev.ly/" v-model="newUrlEdited.shortened_link" persistent-hint
                  hint="Unable to edit destination url, visibility and its expiry time" color="primary"
                  :disabled="newUrlEdited.load" :loading="newUrlEdited.load" placeholder="(optional)" label="Title"
                  required />
            </div>
          </v-fade-transition>

          <div class="d-flex" v-show="userProfile">
            <t-button elevation="0" :disabled="newUrlEdited.load || destroy.load" @click="editUrl ? handleEditUrl() : editUrl = true"
              icon color="white"><v-icon :icon="editUrl ? 'mdi-check-bold' : 'mdi-pencil'"
                color="primary"></v-icon></t-button>
            <v-spacer></v-spacer>
            <v-btn :disabled="newUrlEdited.load" @click="editUrl ? editUrl = false : handleDestroy()" class="ml-1"
              :loading="destroy.load" variant="outlined" :icon="editUrl ? 'mdi-close' : 'mdi-delete'" color="red"></v-btn>
          </div>
        </v-col>
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
import TTextInput from '@/components/core/TTextInput.vue'
import TButton from '@/components/core/TButton.vue'

export default defineComponent({
  name: 'TUrlBox',
  components: { TTextInput, TButton },
  props: {
    url: {
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
    };
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
        id: this.$props.url.id,
        user_id: this.$props.url.user_id,
        shortened_link: this.$props.url.shortened_link,
        message: "",
        error: false,
        load: false,
      },
    };
  },
  created() {
    // this.site = window.location.origin.split('://')[1];
    this.site = 'dev.ly'
  },
  methods: {
    copyUrl() {
      try {
        navigator.clipboard.writeText(this.site + '/r/' + this.url.shortened_link);
        this.copyText = 'COPIED!';
        window.setTimeout(() => {
          this.copyText = 'COPY';
        }, 1500);
      }
      catch (e) {
        console.log("cant copy de link.");
      }
    },
    async handleDestroy() {
      try {
        this.destroy.load = true;
        await this.link.destroy(this.url);
        this.visibility = false;
        this.$emit('delete', 1);
      }
      catch (e: any) {
        console.log(e);
        if (e.response.data.message) {
          throw e.response.data.message;
        }
        else {
          throw 'Something went wrong. Try again later';
        }
      }
      finally {
        this.destroy.load = false;
      }
    },
    async handleCheckCustomUrl() {
      if (this.url.shortened_link && this.newUrlEdited.shortened_link !== this.url.shortened_link) {
        try {
          await this.link.checkCustomUrl(this.newUrlEdited.shortened_link);
          this.newUrlEdited.message = '';
          this.newUrlEdited.error = false;
          return true;
        }
        catch (e) {
          this.newUrlEdited.message = 'This URL is aready in use';
          this.newUrlEdited.error = true;
          return false;
        }
      }
      else {
        this.newUrlEdited.message = '';
        this.newUrlEdited.error = false;
        return true;
      }
    },
    async handleEditUrl() {
      this.newUrlEdited.load = true;
      if ((await this.handleCheckCustomUrl()) && !this.newUrlEdited.error) {
        if (this.newUrlEdited.shortened_link != this.$props.url.shortened_link) {
          try {
            const response = await this.link.edit(this.newUrlEdited);
            console.log(response);
            this.$props.url.shortened_link = response.shortened_link;
            this.newUrlEdited.shortened_link = response.shortened_link;
          }
          catch (e) {
            this.newUrlEdited.message = 'Something went wrong. Try again later';
            this.newUrlEdited.error = true;
          }
        }
      }
      this.editUrl = false;
      this.newUrlEdited.load = false;
    }
  },
})
</script>

<style scoped>
.recipient-link {
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
</style>
