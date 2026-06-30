import { defineStore } from "pinia";
import { computed, ref } from "vue";
import api from "@/api/axios";

export const useUserStore = defineStore("user", () => {

  //State
  const token = ref(localStorage.getItem("token") || null);
  const user = ref(JSON.parse(localStorage.getItem("user")) || null);
  const error = ref(null);
  const price = ref(7.99);

  //Getter
  const isLoggedIn = computed(() => !!token.value) //!!convertit valeur du token en booléen 


  //Actions
  async function login(email, password) {

    try{
      const { data } = await api.post("/login", { email, password });
      token.value = data.token;
      localStorage.setItem("token", token.value);
      
      const { data: userData } = await api.get("/users/me");
      user.value = userData;
      localStorage.setItem("user", JSON.stringify(userData));
      
      console.log("Tu es connecté");
      return true;
    }catch(e){
      error.value = 'Identifiants Incorrects';
      throw e;
      
    }
  }

  function logout() {
    token.value = null;
    user.value = null;
    localStorage.removeItem("token");
    localStorage.removeItem("user");
    console.log("Tu es déconnecté");
  }

  //paramètres = champs du formulaire
  async function register(email, password, pseudo) {
    //Post /users ->La route API
    const { data } = await api.post("/users", { email, password, pseudo });
    //appel de login pour connecté automatiquement
    await login(email, password);
    console.log("Le compte est crée");
    return true;
  }

  return { token, user,error,isLoggedIn, login, logout, register, price };
});
