import { ref } from "vue";
import api from "@/api/axios";

export function useMovies() {
  const movies = ref([]);
  const movie = ref(null);
  const loading = ref(false);
  const error = ref(null);

  // tout les posts = lister
  const fetchMovies = async () => {
    loading.value = true;
    error.value = null;
    try {
      const res = await api.get("/movies");
      movies.value = res.data.member;
      console.log(movies.value);
    } catch (err) {
      error.value = err?.message || "Erreur lors de la récupération des films.";
    } finally {
      loading.value = false;
    }
  };

  // Un seul post par id =detail
  const fetchMovie = async (id) => {
    console.log('fetchMovie appelé avec id:', id);
    if (!id) {
      movie.value = null;
      return;
    }
    loading.value = true;
    error.value = null;
    try {
      const rest = await api.get(`/movies/${id}`);
      movie.value = rest.data;
    } catch (error) {
      error.value =
        error?.message || "Erreur lors de la récupération de l'article";
    } finally {
      loading.value = false;
    }
  };

  

  // Create (POST)
  const createMovie = async (payload) => {
    loading.value = true;
    error.value = null;
    try {
      const res = await api.post("/movie/new", payload);
      movie.value.unshift(res.data);
      return res.data;
    } catch (error) {
      error.value = error?.message || "Erreur lors de la création de l'article";
    } finally {
      loading.value = false;
    }
  };

  // Update (PUT)
  const updateMovie = async (id, payload) => {
    loading.value = true;
    error.value = null;
    try {
      const res = await api.put("/movie/updated/:id", payload);
      // Mettre à jour la lsite locale si présente
      const idx = movies.value.findIndex((movie) => movie.id === res.data.id);
      if (idx !== -1) movies.value[idx] = res.data;
      movies.value = res.data;
      return res.data;
    } catch (error) {
      error.value = error?.message || "Erreur lors de la mise à jour du film.";
      throw error;
    } finally {
      loading.value = false;
    }
  };

  //Delete
  const deleteMovie = async (id) => {
    loading.value = true;
    error.value = null;
    try {
      await api.delete("/movies/delete/:id");
      movies.value = movies.value.filter((movie) => movie.id !== id);
    } catch (error) {
      error.value =
        error?.message || "Erreur lors de la suppression du film.";
      throw error;
    } finally {
      loading.value = false;
    }
  };

  return {
    movies,
    movie,
    loading,
    error,
    fetchMovies,
    fetchMovie,
    createMovie,
    updateMovie,
    deleteMovie
  };
}
