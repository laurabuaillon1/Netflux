import { ref } from "vue";
import api from "@/api/axios";

export function useGenres() {
  const genres = ref([]);
  const genre = ref(null);
  const loading = ref(false);
  const error = ref(null);

  // tout les posts = lister
  const fetchGenres = async () => {
    loading.value = true;
    error.value = null;
    try {
      const res = await axios.get("/genres");
      genres.value = res.data;
    } catch (error) {
      error.value =
        error?.message || "Erreur lors de la récupération des genres.";
    } finally {
      loading.value = false;
    }
  };

  // Un seul genre par id =detail
  const fetchGenre = async (id) => {
    if (!id) {
      genre.value = null;
      return;
    }
    loading.value = true;
    error.value = null;
    try {
      const rest = await axios.get("/genres/:id");
      genre.value = rest.data;
    } catch (error) {
      error.value = error?.message || "Erreur lors de la récupération du genre";
    } finally {
      loading.value = false;
    }
  };

  // Create (POST)
  const createGenre = async (payload) => {
    loading.value = true;
    error.value = null;
    try {
      const res = await axios.post("/genres/new", payload);
      genre.value.unshift(res.data);
      return res.data;
    } catch (error) {
      error.value = error?.message || "Erreur lors de la création du genre";
    } finally {
      loading.value = false;
    }
  };

  // Update (PUT)
  const updateGenre = async (id, payload) => {
    loading.value = true;
    error.value = null;
    try {
      const res = await axios.put("/genres/updated/:id", payload);
      // Mettre à jour la lsite locale si présente
      const idx = genres.value.findIndex((movie) => genre.id === res.data.id);
      if (idx !== -1) genres.value[idx] = res.data;
      genres.value = res.data;
      return res.data;
    } catch (error) {
      error.value = error?.message || "Erreur lors de la mise à jour du genre.";
      throw error;
    } finally {
      loading.value = false;
    }
  };

  //Delete
  const deleteGenre = async (id) => {
    loading.value = true;
    error.value = null;
    try {
      await axios.delete("/genres/delete/:id");
      genres.value = genres.value.filter((genre) => genre.id !== id);
    } catch (error) {
      error.value = error?.message || "Erreur lors de la suppression du genre.";
      throw error;
    } finally {
      loading.value = false;
    }
  };

  return {
    genres,
    genre,
    loading,
    error,
    fetchGenres,
    fetchGenre,
    createGenre,
    updateGenre,
    deleteGenre,
  };
}
