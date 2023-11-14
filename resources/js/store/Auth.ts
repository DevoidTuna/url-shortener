import axios, { AxiosError } from "axios";
import { defineStore } from "pinia";

import { User } from "../types/User";

export const useAuthStore = defineStore("auth", {
  persist: true,
  state() {
    return {
      accessToken: null,
      id: 0,
      name: "",
      email: "",
      cellphone: "",
    } as User;
  },
  actions: {
    async checkUser(): Promise<void> {
      await axios
        .get("/user")
        .then((response) => {
          this.$state = {
            id: response.data.data.id,
            name: response.data.data.name,
            email: response.data.data.email,
            cellphone: response.data.data.cellphone,
          };
        })
        .catch((error: AxiosError) => {
          console.error("Error: ", error.response);
          this.$state = {};
          return error;
        });
    },

    async login(email: string, password: string): Promise<boolean> {
      try {
        const result = await axios.post("/oauth/token", {
          username: email,
          password: password,
          grant_type: "password",
          client_id: 2,
          client_secret: "DvA8GBRuLslbbw6VIGLjWtP9i8lJQY4V5hyPZICk",
          scopes: "",
        });

        this.accessToken = result.data.access_token;

        await this.checkUser();
        return true;
      } catch (e: any) {
        if (e.response.data.message) {
          throw e.response.data.message;
        }
        console.log(e);
        throw "Ocorreu um erro. Por favor, tente novamente mais tarde.";
      }
    },

    async logout(): Promise<void> {
      try {
        await axios.get("/logout");
      } catch (e: any) {
        // console.log(e)
      } finally {
        this.accessToken = null;
        this.$state = {
          id: 0,
          name: "",
          email: "",
          cellphone: "",
        };
      }
    },

    async register(form: { [key: string]: string }): Promise<boolean> {
      try {
        await axios.post("/register", {
          name: form.name,
          email: form.email,
          password: form.password,
          password_confirmation: form.password_confirmation,
        });
        await this.login(form.email, form.password);
        return true;
      } catch (e: any) {
        if (e.response.data.message) {
          console.log(e.response.data.message);
        }
        throw "Ocorreu um erro. Por favor, tente novamente mais tarde.";
      }
    },

    async updateUser(form: object): Promise<boolean> {
      try {
        const response = await axios.post("/profile/edit", form);
        this.$state.name = response.data.user.name;
        this.$state.email = response.data.user.email;

        return true;
      } catch (e: any) {
        if (e.response.data.message) {
          // console.log(e.response.data.message)
        }
        throw "Ocorreu um erro. Por favor, tente novamente mais tarde.";
      }
    },

    async updatePassword(form: object): Promise<boolean> {
      try {
        await axios.post("/password/update", form);
        return true;
      } catch (e: any) {
        if (e.response.data.message) {
          // console.log(e.response.data.message)
        }
        throw "Ocorreu um erro. Por favor, tente novamente mais tarde.";
      }
    },

    async resetPassword(form: object): Promise<boolean> {
      try {
        await axios.post("/password/reset", form);
        return true;
      } catch (e: any) {
        if (e.response.data.message) {
          // console.log(e.response.data.message)
        }
        throw "Ocorreu um erro. Por favor, tente novamente mais tarde.";
      }
    },

    async newPassword(form: object): Promise<boolean> {
      try {
        await axios.post("/password/new", form);
        return true;
      } catch (e: any) {
        if (e.response.data.message) {
          // console.log(e.response.data.message)
        }
        throw "Ocorreu um erro. Por favor, tente novamente mais tarde.";
      }
    },
  },
});
