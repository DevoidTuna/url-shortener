<template>
  <div>
    <v-slide-y-transition>
			<v-row class="row-dad" v-show="visibility">
				<!--
					<div class="icon-clock">
						<v-tooltip activator="parent" color="accent" location="start">{{ url.expired_at ? 'Expires ' +
							url.expired_at : 'Always available' }}</v-tooltip>
						<v-icon size="25" icon="mdi-clock" color="white">
						</v-icon>
					</div>
				-->
				<v-fade-transition hide-on-leave>
					<v-btn v-show="!editUrl" variant="elevated" icon color="white" @click="copyUrl()">
						<v-icon icon="mdi-content-copy" color="primary"></v-icon>
						<v-tooltip activator="parent" color="accent" location="start">{{ copyText }}</v-tooltip>
					</v-btn>
				</v-fade-transition>

				<v-card variant="elevated">
					<v-card-text>
						<v-fade-transition hide-on-leave>
							<div v-show="!editUrl">
								<div class="justify-space-between">
									<div class="d-flex align-center">
										<v-icon v-show="userProfile" class="icon-url-card" size="25" color="white"
											:icon="url.public ? 'mdi-earth' : 'mdi-lock'"></v-icon>
										<a :href="'/r/' + url.shortened_link" target="_blank" class="shortened-link">
											<h3>{{ site + '/r/' + url.shortened_link }}</h3>
										</a>
									</div>
								</div>
								<h5><a class="recipient-link" target="_blank" :href="url.recipient_link">
										{{ url.recipient_link }}
									</a></h5>
							</div>

						</v-fade-transition>
						<v-fade-transition hide-on-leave>
							<div v-show="editUrl">
								<v-text-field clearable counter active @blur="handleCheckCustomUrl()"
									:error-messages="newUrlEdited.error ? newUrlEdited.message : ''" maxlength="50" prefix="dev.ly/"
									v-model="newUrlEdited.shortened_link" persistent-hint hint="Unable to edit destination url, visibility and its expiry time" color="primary" :disabled="newUrlEdited.load"
									:loading="newUrlEdited.load" placeholder="(optional)" label="Title" required>
								</v-text-field>
							</div>
						</v-fade-transition>
					</v-card-text>
				</v-card>

				<div class="cont-btn-actions" v-show="userProfile">
					<v-btn :disabled="newUrlEdited.load || destroy.load" @click="editUrl ? handleEditUrl() : editUrl = true" icon color="white"><v-icon :icon="editUrl ?  'mdi-check-bold' : 'mdi-pencil'"
							color="primary"></v-icon></v-btn>
					<v-spacer></v-spacer>
					<v-btn :disabled="newUrlEdited.load" @click="editUrl ? editUrl = false : handleDestroy()" :loading="destroy.load" variant="outlined" :icon="editUrl ? 'mdi-close' : 'mdi-delete'"
						color="red"></v-btn>
				</div>
			</v-row>
		</v-slide-y-transition>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue'

import { useLinkStore } from '@/store/Link'
import { useAuthStore } from '@/store/Auth'

export default defineComponent({
  name: 'TUrlBoxOld',
  props: [
		'url',
		'userProfile',
	],
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
			site: "dev.ly",
			editUrl: false,
			newUrlEdited: {
				id: this.$props.url.id,
				user_id: this.$props.url.user_id,
				shortened_link: this.$props.url.shortened_link,
				message: "",
				error: false,
				load: false,
			},

		}
	},
	created() {
		// this.site = window.location.origin.split('://')[1]
	},
	methods: {
		copyUrl() {
			try {
				navigator.clipboard.writeText(this.site + '/r/' + this.url.shortened_link)
				this.copyText = 'COPIED!'
				window.setTimeout(() => {
					this.copyText = 'COPY'
				}, 1500)
			} catch (e) {
				console.log("cant copy de URL.")
			}
		},

		async handleDestroy() {
			try {
				this.destroy.load = true
				await this.link.destroy(this.url)
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
			if (this.url.shortened_link && this.newUrlEdited.shortened_link !== this.url.shortened_link) {
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
				if(this.newUrlEdited.shortened_link != this.$props.url.shortened_link) {
					try {
						const response = await this.link.edit(this.newUrlEdited)
						console.log(response)
						this.$props.url.shortened_link = response.shortened_link
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
