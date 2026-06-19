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

  // Lister tous les utilisateurs
const fetchUsers = async () => {
  loading.value = true;
  error.value = null;
  try {
    const res = await api.get("/users");
    users.value = res.data.member;
  } catch (err) {
    error.value = err?.message || "Erreur lors de la récupération des utilisateurs.";
  } finally {
    loading.value = false;
  }
};

// Création d'un utilisateur
const createUser = async (payload) => {
  loading.value = true;
  error.value = null;
  try {
    const res = await api.post("/users", payload);
    users.value.unshift(res.data);
    return res.data;
  } catch (err) {
    error.value = err?.message || "Erreur lors de la création de l'utilisateur.";
    throw err;
  } finally {
    loading.value = false;
  }
};

// Modifier un utilisateur
const updateUser = async (id, payload) => {
  console.log(payload);
  loading.value = true;
  error.value = null;
  try {
    const res = await api.patch(`/users/${id}`, payload, {
      headers: {
        'Content-Type': 'application/merge-patch+json'
      }
    });
    // Mise à jour de la liste locale en mémoire
    const idx = users.value.findIndex(u => u.id === res.data.id);
    if (idx !== -1) {
      users.value[idx] = res.data;
    }
    return res.data;
  } catch (err) {
    // Récupération du message d'erreur d'API Platform si disponible
    error.value = err.response?.data?.['hydra:description'] || err?.message || "Erreur lors de la mise à jour de l'utilisateur.";
    throw err;
  } finally {
    loading.value = false;
  }
};

// Supprimer un utilisateur
const deleteUser = async (id) => {
  loading.value = true;
  error.value = null;
  try {
    await api.delete(`/users/${id}`);
    users.value = users.value.filter(u => u.id !== parseInt(id));
  } catch (err) {
    error.value = err?.message || "Erreur lors de la suppression de l'utilisateur.";
    throw err;
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
    fetchUsers,
    updateUser,
    deleteUser,
    createUser,
  };
}
