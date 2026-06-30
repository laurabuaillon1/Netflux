import { createRouter, createWebHistory } from "vue-router";
import { useUserStore } from "@/stores/user";
import HomeView from "@/views/HomeView.vue";
import LoginView from "@/views/LoginView.vue";
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
import AdminView from "@/views/AdminView.vue";
import AddUserView from "@/views/AddUserView.vue";
import UpdatedUserView from "@/views/UpdatedUserView.vue";



// Routes qui ne sont pas en lien avec ApiPaltform (uen route = une page d'afficher sur mon front)
const routes = [
  { path: "/", name: "home", component: HomeView },

  // Inscription - Connexion
  { path: "/login", name: "login", component: LoginView },
  { path: "/register", name: "register", component: RegisterView },
  { path: "/favorites", name: "favorites", component: FavoritesView, meta: { requiresAuth: true } },

  // Movie
  { path: "/movies", name: "movies", component: MovieListView },
  { path: "/movies/new", name: "moviesnew", component: MovieCreateView, meta: { requiresAuth: true, requiresAdmin: true } },
  { path: "/movies/updated", name: "moviesupdated", component: MovieUpdatedView , meta: { requiresAuth: true, requiresAdmin: true } },
  { path: "/movies/deleted", name: "moviesdeleted", component: MovieDeletedView, meta: { requiresAuth: true, requiresAdmin: true } },
  { path: "/movies/:id", name: "moviesdétail", component: MovieDetailView },

  //Genres
  
  { path: "/genres", name: "genre", component: GenreListView },
  { path: "/genres/new", name: "genresnew", component: GenreCreateView },
  { path: "/genres/:id", name: "genredétail", component: GenreDetailView },
  { path: "/genres/updated/:id", name: "genresupdated", component: GenreUpdatedView },
  
  //Users
  { path: "/users/{id}/favorites", name: "moviesfavoris", component: FavoritesView },
  { path: "/users/new", name: "usernew", component: AddUserView, meta: { requiresAdmin: true }}, 
  { path: "/users/updated", name: "usersupdated", component: UpdatedUserView, meta: { requiresAdmin: true }},

  //Admin
  { path: "/admin", name: "admin", component: AdminView, meta: { requiresAuth: true, requiresAdmin: true } },

  //route inconnue->404-> nécéssite catch-all,
  { path: '/:pathMatch(.*)*', name: 'notFound', redirect: '/' }

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

   if (to.meta.requiresAdmin && !store.user?.roles?.includes("ROLE_ADMIN")) {
    return { name: "home" };
  }
});

export default router;