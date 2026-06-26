import { describe, it, expect, beforeEach } from "vitest";
import { setActivePinia, createPinia } from "pinia";
import { useMovies } from "@/composables/useMovies";
import { user, useUserStore } from "@/stores/user";

const API_URL = "http://localhost:8080/api";

describe("useMovie", () => {
  beforeEach(() => {
    setActivePinia(createPinia());
    const auth = useUserStore();
    auth.token = "fake-jwt-token";

    //si erreur 401 stocker dans localstorage
    localStorage.setItem("token", "fake-jwt-token");
  });
  //--------------------//
  //--Liste des films--//
  //------------------//
  describe("fetchMovies", () => {
    it("devrait récupérer la liste des films", async () => {
      const { movies, loading, error, fetchMovies } = useMovies();

      expect(movies.value).toEqual([]);
      expect(loading.value).toBe(false);

      await fetchMovies();

      expect(loading.value).toBe(false);
      expect(error.value).toBeNull();
      expect(movies.value).toHaveLength(2);

      expect(movies.value[0].title).toBe("Inception");
      expect(movies.value[1].title).toBe("Breaking Bad");
    });

    it("devrait activer le chargement pendant le requete", async () => {
      const { loading, fetchMovies } = useMovies();

      const promise = fetchMovies();

      expect(loading.value).toBe(true);

      await promise;

      expect(loading.value).toBe(false);
    });

    it("devrait refuser sans authentification", async () => {
      const { updateMovie } = useMovies();

      localStorage.removeItem("token"); // pour ne plus etre authentifié

      await expect(updateMovie(1, { title: "test" })).rejects.toThrow();
    });
  });

  //---------------------//
  //--Detail d'un film--//
  //-------------------//
  describe("fetchMovie", () => {
    it("devrait pouvoir afficher le détail d'un film", async () => {
      const { movie, loading, error, fetchMovie } = useMovies();

      expect(movie.value).toBeNull();
      expect(loading.value).toBe(false);

      await fetchMovie(1);

      expect(loading.value).toBe(false);
      expect(error.value).toBeNull();
      expect(movie.value.title).toBe('Inception');
    });

    it("devrait activer le chargement pendant la requetes", async () => {
      const { loading, fetchMovie } = useMovies();
      const promise = fetchMovie();

      expect(loading.value).toBe(false);

      await promise;

      expect(loading.value).toBe(false);
    });

    it("devrait refuser sans authentification", async () => {
      const { fetchMovie } = useMovies();
      await expect(fetchMovie(1, { title: "Inception" })).rejects.toThrow;
    });
  });

  //------------------//
  //--Créer un film--//
  //----------------//
  describe("createMovie", () => {
    it("devrait pouvoir créer un film", async () => {
      const { movies, loading, error, createMovie } = useMovies();

      expect(movies.value).toEqual([]);
      expect(loading.value).toBe(false);

      await createMovie({ title: "New Movie" });

      expect(loading.value).toBe(false);
      expect(error.value).toBeNull();
      expect(movies.value[0].title).toBe("New Movie");
    });

    it("devrait activer le chargement pendant la requetes", async () => {
      const { loading, createMovie } = useMovies();
      const promise = createMovie();

      expect(loading.value).toBe(true);

      await promise;

      expect(loading.value).toBe(false);
    });

    it("devrait refuser sans authentification", async () => {
      const { createMovie } = useMovies();
      await expect(createMovie(1, { title: "test" })).rejects.toThrow;
    });
  });

  //---------------------//
  //--Modifier un film--//
  //-------------------//
  describe("updateMovie", () => {
    it("devrait pouvoir modifier un film", async () => {
      const { movies, loading, error, updateMovie } = useMovies();

      expect(movies.value).toEqual([]);
      expect(loading.value).toBe(false);

      await updateMovie(1, { title: "Updated Movie" });

      expect(loading.value).toBe(false);
      expect(error.value).toBeNull();
      expect(movies.value.title).toBe("Updated Movie");
    });

    it("devrait activer le chargement pendant la requetes", async () => {
      const { loading, updateMovie } = useMovies();
      const promise = updateMovie();

      expect(loading.value).toBe(true);

      await promise;

      expect(loading.value).toBe(false);
    });

    it("devrait refuser sans authentification", async () => {
      const { updateMovie } = useMovies();
      await expect(updateMovie(1, { title: "test" })).rejects.toThrow;
    });
  });

  //----------------------//
  //--Supprimer un film--//
  //----------------------//
  describe("deleteMovie", () => {
    it("devrait pouvoir supprimer un film", async () => {
      const { movies, loading, error, deleteMovie } = useMovies();

      // On préremplit la liste avec un film
      movies.value[{ id: 1, title: "Inception" }];

      expect(movies.value).toEqual([]);
      expect(loading.value).toBe(false);

      await deleteMovie(1);

      expect(loading.value).toBe(false);
      expect(error.value).toBeNull();
      expect(movies.value).toHaveLength(0);
    });

    it("devrait activer le chargement pendant la requetes", async () => {
      const { loading, deleteMovie } = useMovies();
      const promise = deleteMovie();

      expect(loading.value).toBe(true);

      await promise;

      expect(loading.value).toBe(false);
    });

    it("devrait refuser sans authentification", async () => {
      const { deleteMovie } = useMovies();
      await expect(deleteMovie(1, { title: "Inception" })).rejects.toThrow;
    });
  });
});
