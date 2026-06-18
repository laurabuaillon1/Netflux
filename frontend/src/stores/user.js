import { defineStore } from "pinia";
import { ref } from "vue";
import api from "@/api/axios";

export const useUserStore = defineStore("user", () => {
  const token = ref(localStorage.getItem("token") || null);
  const user = ref(null);

  const price=ref(7.99);

  async function login(email, password) {
    const { data } = await api.post("/login", { email, password });
    token.value = data.token;
    localStorage.setItem("token", token.value);
    console.log('Tu es connecté')
  }

  function logout() {
    token.value = null;
    user.value = null;
    localStorage.removeItem("token");
    console.log('Tu es déconnecté')
  }

  //paramètres = champs du formulaire
  async function register(email,password,pseudo){
    //Post /users ->La route API
    const {data} =await api.post("/users", {email,password,pseudo});
    //appel de login pour connecté automatiquement
    await login(email,password);
    console.log('Le compte est crée')
  }

  return { token, user, login, logout,register,price };
  
});
