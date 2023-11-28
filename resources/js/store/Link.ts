import { axios } from "@/services/axios";
import { defineStore } from "pinia";

export const useLinkStore = defineStore("link", {
  actions: {
		async index() {
			try {
				const response = await axios.get('/api/profile/links')
				if (response.data.urls.length > 0) {
					return response.data.urls
				} else {
					return null
				}
			} catch (e: any) {
				if (e.response.data.message) {
					throw e.response.data.message
				} else {
					console.log(e)
					throw 'Something went wrong. Try again later'
				}
			}
		},

		async show(id: string | string[]) {
			try {
				const response = await axios.get(`/api/user/links/${id}`)
				return response.data
			} catch (e: any) {
				if (e.response.data.message) {
					throw e.response.data.message
				} else {
					console.log(e)
					throw 'Something went wrong. Try again later'
				}
			}
		},

		async destroy(url: object) {
			try {
				await axios.put('/api/profile/delete-url', url)
				return true
			} catch (e: any) {
				if (e.response.data.message) {
					throw e.response.data.message
				} else {
					console.log(e)
					throw 'Something went wrong. Try again later'
				}
			}
		},

		async store(url: object) {
			try {
				await axios.post('/api/create-url', url)
				return true
			} catch (e: any) {
				if (e.response.data.message) {
				  throw e.response.data.message
				} else {
				  console.log(e)
				  throw 'Something went wrong. Try again later'
				}
			}
		},

		async checkCustomUrl(name: string) {
			try {
				const response = await axios.get(`/api/url/check/${name}`)
				return response.data
			} catch (e: any) {
				if (e.response.data.message) {
					throw e.response.data.message
				} else {
					console.log(e)
					throw 'Something went wrong. Try again later'
				}
			}
		},

		async edit(url: object) {
			try {
				const response = await axios.put('/api/profile/edit-url', url)
				return response.data
			} catch (e: any) {
				if (e.response.data.message) {
					throw e.response.data.message
				} else {
					console.log(e)
					throw 'Something went wrong. Try again later'
				}
			}
		},
	}
});
