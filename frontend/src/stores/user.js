import { defineStore } from "pinia";
import { ref } from "vue";
import api from "@/api/axios";

export const useUserStore = defineStore("user", () => {
  const token = ref(localStorage.getItem("token") || null);
  const user = ref(null);

  async function login(email, password) {
    const { data } = await api.post("/login", { email, password });
    token.value = data.token;
    localStorage.setItem("token", token.value);
  }

  function logout() {
    token.value = null;
    user.value = null;
    localStorage.removeItem("token");
  }

  return { token, user, login, logout };
});