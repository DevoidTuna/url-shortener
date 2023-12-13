import { axios } from "@/services/axios";
import { defineStore } from "pinia";

import { User } from "../types/User";

export const useAuthStore = defineStore("auth", {
  persist: true,
  state() {
    return {
      accessToken: null,
      id: 0,
      nickname: "",
      email: "",
    } as User;
  },
  actions: {
    async checkUser(): Promise<void> {
      try {
        const response = await axios.get("/api/user");
        this.$state = {
          id: response.data.data.id,
          nickname: response.data.data.nickname,
          email: response.data.data.email,
        };
      } catch (e: any) {
        if (e.data.data.response) {
          throw e.data.data.response;
        }
        this.$state = {
          accessToken: null,
          id: 0,
          nickname: "",
          email: "",
        };
        throw "An error has occurred. Please try again later.";
      }
    },

    async login(email: string, password: string): Promise<boolean> {
      try {
        const response = await axios.post("/oauth/token", {
          username: email,
          password: password,
          grant_type: "password",
          client_id: 2,
          client_secret: "bLIHdI0DMQ0wlxeDfMNXLl5qjvkatmwiES8KJXgR",
          scopes: "",
        });

        this.accessToken = response.data.access_token;

        await this.checkUser();
        return true;
      } catch (e: any) {
        if (e.response.data.message) {
          throw e.response.data.message;
        }
        console.log(e);
        throw "An error has occurred. Please try again later.";
      }
    },

    async logout(): Promise<void> {
      try {
        await axios.get("/api/logout");
      } catch (e: any) {
        // console.log(e)
      } finally {
        this.accessToken = null;
        this.$state = {
          accessToken: null,
          id: 0,
          nickname: "",
          email: "",
        };
      }
    },

    async register(form: { [key: string]: string }): Promise<boolean> {
      try {
        await axios.post("/api/register", {
          nickname: form.nickname,
          email: form.email,
          password: form.password,
          password_confirmation: form.password_confirmation,
        });
        await this.login(form.email, form.password);
        return true;
      } catch (e: any) {
        if (e.response.data.message) {
          throw e.response.data.message;
        }
        throw "An error has occurred. Please try again later.";
      }
    },

    async updateUser(form: object): Promise<boolean> {
      try {
        const response = await axios.post("/profile/edit", form);
        this.$state.nickname = response.data.user.nickname;
        this.$state.email = response.data.user.email;

        return true;
      } catch (e: any) {
        if (e.response.data.message) {
          // console.log(e.response.data.message)
        }
        throw "An error has occurred. Please try again later.";
      }
    },

    async updatePassword(form: object): Promise<boolean> {
      try {
        await axios.post("/api/password/update", form);
        return true;
      } catch (e: any) {
        if (e.response.data.message) {
          // console.log(e.response.data.message)
        }
        throw "An error has occurred. Please try again later.";
      }
    },

    async resetPassword(form: object): Promise<boolean> {
      try {
        await axios.post("/api/password/reset", form);
        return true;
      } catch (e: any) {
        if (e.response.data.message) {
          // console.log(e.response.data.message)
        }
        throw "An error has occurred. Please try again later.";
      }
    },

    async newPassword(form: object): Promise<boolean> {
      try {
        await axios.post("/api/password/new", form);
        return true;
      } catch (e: any) {
        if (e.response.data.message) {
          // console.log(e.response.data.message)
        }
        throw "An error has occurred. Please try again later.";
      }
    },
  },
});
