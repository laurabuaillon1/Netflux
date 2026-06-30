import { describe, it, expect, beforeEach } from "vitest";
import { createMemoryHistory, createRouter } from "vue-router";
import { setActivePinia, createPinia } from "pinia";
import { useUserStore } from "@/stores/user";
import HomeView from "@/views/HomeView.vue";
import LoginView from "@/views/LoginView.vue";
import MovieListView from "@/views/MovieListView.vue";
import MovieDetailView from "@/views/MovieDetailView.vue";
import RegisterView from "@/views/RegisterView.vue";
import MovieCreateView from "@/views/MovieCreateView.vue";
import MovieUpdatedView from "@/views/MovieUpdatedView.vue";
import MovieDeletedView from "@/views/MovieDeletedView.vue";
import FavoritesView from "@/views/FavoritesView.vue";
import AdminView from "@/views/AdminView.vue";
import AddUserView from "@/views/AddUserView.vue";
import UpdatedUserView from "@/views/UpdatedUserView.vue";

describe("Router guards", () => {
  let router;
  let pinia;

  beforeEach(() => {
    pinia = createPinia();
    setActivePinia(pinia);

    router = createRouter({
      history: createMemoryHistory(),
      routes: [
        { path: "/", name: "home", component: HomeView },

        // Inscription - Connexion
        { path: "/login", name: "login", component: LoginView },
        { path: "/register", name: "register", component: RegisterView },
        {
          path: "/favorites",
          name: "favorites",
          component: FavoritesView,
          meta: { requiresAuth: true },
        },

        // Movie
        { path: "/movies", name: "movies", component: MovieListView },
        {
          path: "/movies/new",
          name: "moviesnew",
          component: MovieCreateView,
          meta: { requiresAuth: true, requiresAdmin: true },
        },
        {
          path: "/movies/updated",
          name: "moviesupdated",
          component: MovieUpdatedView,
          meta: { requiresAuth: true, requiresAdmin: true },
        },
        {
          path: "/movies/deleted",
          name: "moviesdeleted",
          component: MovieDeletedView,
          meta: { requiresAuth: true, requiresAdmin: true },
        },
        {
          path: "/movies/:id",
          name: "moviesdétail",
          component: MovieDetailView,
        },

        //Users
        {
          path: "/users/{id}/favorites",
          name: "moviesfavoris",
          component: FavoritesView,
          meta: { requiresAuth: true },
        },
        {
          path: "/users/new",
          name: "usernew",
          component: AddUserView,
          meta: { requiresAdmin: true },
        },
        {
          path: "/users/updated",
          name: "usersupdated",
          component: UpdatedUserView,
          meta: { requiresAdmin: true },
        },

        //Admin
        {
          path: "/admin",
          name: "admin",
          component: AdminView,
          meta: { requiresAuth: true, requiresAdmin: true },
        },

        //route inconnue->404-> nécéssite catch-all,
        { path: "/:pathMatch(.*)*", name: "notFound", redirect: "/" },
      ],
    });

    // Le guard global : s'exécute avant CHAQUE navigation
    // to : la route de destination
    // from : la route d'origine
    // next : fonction à appeler pour autoriser ou rediriger
    router.beforeEach((to, from, next) => {
      const auth = useUserStore(pinia);

      if (to.meta.requiresAuth && !auth.isLoggedIn) {
        next("/login"); //redirection vers la page login
      } else if (to.meta.requiresAdmin && !auth.isAdmin) {
        next("/"); //redirection vers la page d'accueil
      } else {
        next(); //on laisse passer
      }
    });
  });

  it("devrait rediriger un utilisateur non connecté vers le /login", async () => {
    await router.push("/favorites"); //route ou l'utilisateur n'a pas accès
    await router.isReady();

    expect(router.currentRoute.value.path).toBe("/login");
  });

  it("devrait autoriser l'accès à u utilisateur connecté", async () => {
    const auth = useUserStore();
    auth.token =
      "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6MSwiZW1haWwiOiJ1c2VyQGV4YW1wbGUuY29tIiwicm9sZXMiOlsiUk9MRV9VU0VSIl0sImV4cCI6OTk5OTk5OTk5OX0.test";
    await router.push("/movies");
    await router.isReady();
  });

  it("devrait bloquer un non-admin sur une route admin", async () => {
    const auth = useUserStore();

    auth.token =
      "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6MSwiZW1haWwiOiJ1c2VyQGV4YW1wbGUuY29tIiwicm9sZXMiOlsiUk9MRV9VU0VSIl0sImV4cCI6OTk5OTk5OTk5OX0.test";

    await router.push("/movies/new");
    await router.isReady();
  });

  it("devrait autoriser un admin sur une route admin", async () => {
    const auth = useUserStore(pinia);
    auth.token =
      "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6MSwiZW1haWwiOiJ1c2VyQGV4YW1wbGUuY29tIiwicm9sZXMiOlsiUk9MRV9VU0VSIl0sImV4cCI6OTk5OTk5OTk5OX0.test";

    auth.decoded = {
      id: 1,
      email: "admin@example.com",
      roles: ["ROLE_USER", "ROLE_ADMIN"],
      exp: 999999,
    };

    await router.push("/movies/create");
    await router.isReady();

    expect(router.currentRoute.value.path).toBe("/movies/create");
  });

  it("devrait autoriser tout les utilisateurs à avoir accès à /register", async () => {
    await router.push("/register"); //route ou l'utilisateur n'a pas accès
    // await router.push('/movies')
    await router.isReady();

    expect(router.currentRoute.value.path).toBe("/register");
  });

  it("devrait autoriser l'accès à /register sans être connecté", async () => {
    await router.push("/movies");
    await router.isReady();

    expect(router.currentRoute.value.path).toBe("/movies");
  });

  it("devrait rediriger vers 404 ou la page accueil /", async () => {
    await router.push("/une-route-inconnue");
    await router.isReady();

    expect(router.currentRoute.value.path).toBe("/");
  });
});
