import { createRouter, createWebHistory } from "vue-router";
import HomeView from "@/views/HomeView.vue";
import LoginView from "@/views/LoginView.vue";
import { useUserStore } from "@/stores/user";
import MovieListView from "@/views/MovieListView.vue";
import MovieDetailView from "@/views/MovieDetailView.vue";
import RegisterView from "@/views/RegisterView.vue";
import MovieCreateView from "@/views/MovieCreateView.vue";
import MovieUpdatedView from "@/views/MovieUpdatedView.vue";
import MovieDeletedView from "@/views/MovieDeletedView.vue";
import GenreDetailView from "@/views/GenreDetailView.vue";
import GenreCreateView from "@/views/GenreCreateView.vue";
import GenreUpdatedView from "@/views/GenreUpdatedView.vue";
import GenreListView from "@/views/GenreListView.vue";
import FavoritesView from "@/views/FavoritesView.vue";



// Routes qui ne sont pas en lien avec ApiPaltform (uen route = une page d'afficher sur mon front)
const routes = [
  { path: "/", name: "home", component: HomeView },

  // Inscription - Connexion
  { path: "/login", name: "login", component: LoginView },
  { path: "/register", name: "register", component: RegisterView },
  { path: "/favorites", name: "favorites", component: FavoritesView, meta: { requiresAuth: true } },

  // Movie
  { path: "/movies", name: "movies", component: MovieListView },
  { path: "/movies/:id", name: "moviesdétail", component: MovieDetailView },
  { path: "/movies/new", name: "moviesnew", component: MovieCreateView },
  { path: "/movies/updated/:id", name: "moviesupdated", component: MovieUpdatedView },
  { path: "/movies/delete/:id", name: "moviesdeleted", component: MovieDeletedView },
  
  //Genres
  
  { path: "/genres", name: "genre", component: GenreListView },
  { path: "/genres/:id", name: "genredétail", component: GenreDetailView },
  { path: "/genres/new", name: "genresnew", component: GenreCreateView },
  { path: "/genres/updated/:id", name: "genresupdated", component: GenreUpdatedView },
  
  //Users
  { path: "/users/{id}/favorites", name: "moviesfavoris", component: FavoritesView },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach((to) => {
  const store = useUserStore();
  if (to.meta.requiresAuth && !store.token) {
    return { name: "login" };
  }
});

export default router;