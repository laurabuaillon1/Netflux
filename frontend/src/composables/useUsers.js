import { ref } from "vue";
import api from "@/api/axios";

export function useUsers() {
  const users = ref([]);
  const user = ref(null);
  const loading = ref(false);
  const error = ref(null);

  // tous les favoris
  const getFavorites = async () => {
    loading.value = true;
    error.value = null;
    try {
      const res = await api.get(`/users/${user.value.id}/favorites`,);
      users.value = res.data["member"];
    } catch (err) {
      error.value = err?.message || "Erreur lors de la récupération des films.";
    } finally {
      loading.value = false;
    }
  };

  const getMe = async () => {
    loading.value = true;
    error.value = null;
    try {
      const res = await api.get("/users/me");
      user.value = res.data;
    } catch (err) {
      error.value = err?.message || "Erreur lors de la récupération des films.";
    } finally {
      loading.value = false;
    }
  };

  const toggleFavorite = async (movieId) => {
    loading.value = true;
    error.value = null;
    try {
      console.log(user.value.id)
      console.log(movieId)
      const res = await api.post(`/users/${user.value.id}/favorites`,{favoris:[`/api/movies/${movieId}`]});
      user.value = res.data["member"];
      console.log(user.value)
    } catch (err) {
      error.value = err?.message || "Erreur lors de la mise à jour des favoris";
    } finally {
      loading.value = false;
    }
  };

  return {
    users,
    user,
    loading,
    error,
    getFavorites,
    getMe,
    toggleFavorite,
  };
}
