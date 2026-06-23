import { computed, ref } from "vue";
import api from "@/api/axios";

export function useMovies() {
  const movies = ref([]);
  const movie = ref(null);
  const loading = ref(false);
  const error = ref(null);

  // Propriété calculée pour filtrer uniquement les films
  const onlyMovies = computed(() => {
    return movies.value.filter((item) => item.type === "Film");
  });

  // Propriété calculée pour filtrer uniquement les séries
  const onlySeries = computed(() => {
    return movies.value.filter((item) => item.type === "Série");
  });

  // Propriété calculée pour filtrer les films/série les mieux noté
  const bestRateMovies = computed(() => {
    // console.log("Données brutes reçues pour le filtre de note :", movies.value);
    return movies.value.filter((item) => item.rating >= 4);
  });

  // Propriété calculée pour filtrer les films/série les +recent
  const recentMovies = computed(() => {
    return movies.value.filter((item) => {
      const dateMovie= new Date(item.releaseDate);
      // console.log(dateMovie)
      const year = dateMovie.getFullYear()
      return year >= 2020; // Garde les films de 2020, 2021, 2022...
    });
  });

  // tout les posts = lister
  const fetchMovies = async () => {
    loading.value = true;
    error.value = null;
    try {
      const res = await api.get("/movies");
      movies.value = res.data.member;
      // console.log(movies.value);
    } catch (err) {
      error.value = err?.message || "Erreur lors de la récupération des films.";
    } finally {
      loading.value = false;
    }
  };

  // Un seul post par id =detail
  const fetchMovie = async (id) => {
    console.log("fetchMovie appelé avec id:", id);
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
      const res = await api.post("/movies", payload);
      if (movies.value) movies.value.unshift(res.data);
      return res.data;
    } catch (error) {
      error.value = error?.message || "Erreur lors de la création du film";
      throw error;
    } finally {
      loading.value = false;
    }
  };

  // Update (PUT)
  const updateMovie = async (id, payload) => {
    loading.value = true;
    error.value = null;
    try {
      const res = await api.put(`/movies/${id}`, payload);
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

  const deleteMovie = async (id) => {
  loading.value = true;
  error.value = null;
  try {
    await api.delete(`/movies/${id}`);
    movies.value = movies.value.filter((movie) => movie.id !== parseInt(id));
  } catch (err) {
    error.value = err?.message || "Erreur lors de la suppression du film.";
    throw err;
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
    deleteMovie,
    onlyMovies,
    onlySeries,
    bestRateMovies,
    recentMovies,
  };
}
