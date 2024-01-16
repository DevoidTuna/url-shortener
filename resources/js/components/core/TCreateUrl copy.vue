<template>
  <main>
    <v-expansion-panels class="w-100" variant="popout">
      <v-expansion-panel
        bg-color="transparent"
        class="rounded-lg"
        elevation="7"
        :v-model="openPanel"
      >
        <v-expansion-panel-title color="secondary" class="fs-6">
          <v-icon
            icon="mdi-link-variant-plus"
            color="primary"
            class="mr-3"
          ></v-icon>
          New URL
        </v-expansion-panel-title>
        <v-expansion-panel-text class="rounded-lg expansion-text">
          <v-col class="panel-text">
            <v-text-field
              class="mb-1"
              prepend-inner-icon="mdi-link"
              autofocus
              v-model="url.recipient_link"
              color="primary"
              :disabled="load"
              :loading="load"
              :error-messages="v$.url.recipient_link.$errors.map((e: any) => e.$message)"
              type="url"
              label="URL"
              required
            >
            </v-text-field>

            <v-text-field
              class="mb-1"
              prepend-inner-icon="mdi-format-title"
              clearable
              counter
              active
              @blur="handleCheckCustomUrl()"
              :error-messages="errorShort ? 'This URL is aready in use' : ''"
              maxlength="50"
              prefix="dev.ly/"
              v-model="url.shortened_link"
              color="primary"
              :disabled="load"
              :loading="load"
              placeholder="(optional)"
              label="Title"
              required
            >
            </v-text-field>

            <v-col>
              <v-row>
                <v-divider></v-divider>
              </v-row>
            </v-col>

            <v-container>
              <v-row>
                <!-- visibility -->
                <div></div>
                <v-radio-group v-model="url.public" :disabled="load">
                  <h3>
                    <v-icon
                      :icon="
                        url.public ? 'mdi-eye-outline' : 'mdi-eye-off-outline'
                      "
                    ></v-icon>
                    Visibility
                  </h3>
                  <v-radio color="primary" label="Public" :value="1"></v-radio>
                  <v-radio color="primary" label="Private" :value="0"></v-radio>
                </v-radio-group>

                <v-divider vertical class="mx-3 mb-10 d-none d-lg-block"/>

                <!-- expiration -->
                <v-radio-group v-model="url.expired_at" :disabled="load">
                  <h3>
                    <v-icon
                      :icon="
                        url.expired_at == -1
                          ? 'mdi-timer-off-outline'
                          : 'mdi-timer-outline'
                      "
                    ></v-icon>
                    Expiration
                  </h3>
                  <v-row>
                    <v-col>
                      <v-radio
                        color="primary"
                        label="Never"
                        :value="-1"
                      ></v-radio>
                    </v-col>
                    <v-col>
                      <v-radio
                        color="primary"
                        label="45 min"
                        :value="45"
                      ></v-radio>
                    </v-col>
                    <v-col>
                      <v-radio
                        color="primary"
                        label="Custom"
                        :value="'custom'"
                      ></v-radio>
                    </v-col>
                  </v-row>
                  <v-col>
                    <v-row>
                      <v-text-field
                        :disabled="url.expired_at != 'custom'"
                        color="primary"
                        type="datetime-local"
                        :error-messages="
                          errorExpiredCustom
                            ? 'Try using a complete future date'
                            : ''
                        "
                        label="Date"
                        v-model="expiredCustom"
                      ></v-text-field>
                    </v-row>
                  </v-col>
                </v-radio-group>
              </v-row>
            </v-container>

            <v-slide-y-transition>
              <v-alert
                v-if="message"
                class="justify-center"
                :color="success ? 'success' : 'error'"
                >{{ message }}</v-alert
              >
            </v-slide-y-transition>

            <v-row class="d-flex justify-center mt-1">
              <v-btn
                :loading="load"
                class
                variant="elevated"
                size="large"
                color="primary"
                @click="handleCreateUrl()"
                >Shorten URL</v-btn
              >
            </v-row>
          </v-col>
        </v-expansion-panel-text>
      </v-expansion-panel>
    </v-expansion-panels>
  </main>
</template>

<script lang="ts">
import { useLinkStore } from "@/store/Link";
import { useAuthStore } from "@/store/Auth";

import { useVuelidate } from "@vuelidate/core";
import { required, url, helpers } from "@vuelidate/validators";
import { Url } from "@/types/Url";

export default {
  name: "CreateUrlPanel",
  emits: ["urlCreated"],
  setup() {
    return {
      link: useLinkStore(),
      auth: useAuthStore(),
      v$: useVuelidate(),
    };
  },
  data() {
    return {
      url: {
        shortened_link: "",
        recipient_link: "",
        expired_at: -1,
        public: 1,
      } as Url,

      load: false,
      success: false,
      message: "",
      openPanel: false,

      expiredCustom: "",

      errorExpiredCustom: false,
      errorShort: false,
    };
  },
  methods: {
    async handleCreateUrl() {
      this.errorExpiredCustom = false;
      if ((await this.v$.$validate()) && this.errorShort === false) {
        this.load = true;
        await this.handleCheckCustomUrl();

        if (this.errorShort === false) {
          if (this.url.expired_at == "custom") {
            const atualDate = new Date();
            const customDate = new Date(this.expiredCustom);

            if (atualDate > customDate) {
              this.load = false;
              return (this.errorExpiredCustom = true);
            } else if (this.expiredCustom.length < 12) {
              this.load = false;
              return (this.errorExpiredCustom = true);
            }

            this.url.expired_at = this.expiredCustom;
          }
          try {
            await this.link.store(this.url);
            this.$emit("urlCreated", 1);
            this.success = true;
            this.message = "";

            this.openPanel = false;

            this.url = {
              shortened_link: "",
              recipient_link: "",
              expired_at: -1,
              public: 1,
            };
            this.v$.$reset();
          } catch (e) {
            this.success = false;
          }
        }
        this.load = false;
      }
    },
    async handleCheckCustomUrl() {
      if (this.url.shortened_link) {
        try {
          await this.link.checkCustomUrl(this.url.shortened_link);
          this.errorShort = false;
          return true;
        } catch (e) {
          this.errorShort = true;
          return false;
        }
      } else {
        this.errorShort = false;
        return true;
      }
    },
  },
  validations() {
    return {
      url: {
        recipient_link: {
          required: helpers.withMessage("Required", required),
          url: helpers.withMessage("Enter a valid URL", url),
        },
        expired_at: {
          required: helpers.withMessage("Required", required),
        },
        public: {
          required: helpers.withMessage("Required", required),
        },
      },
    };
  },
};
</script>
<style scoped>
.container-card {
  display: flex;
  justify-content: center;
}

h3 {
  margin-bottom: 8px;
}

.col-divider {
  height: 170px;
}

.v-expansion-panel-title {
  font-size: 19px;
}
</style>
