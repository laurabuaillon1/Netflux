import { describe, it, expect, beforeEach } from "vitest";
import { mount, flushPromises } from "@vue/test-utils";
import { createPinia, setActivePinia } from "pinia";
import { createRouter, createMemoryHistory } from "vue-router";

//Import des composants
import MovieListView from "@/views/MovieListView.vue";
import { useUserStore } from "@/stores/user";

describe("MovieListView", () => {
  let pinia;
  let router;

  beforeEach(() => {
    pinia = createPinia();
    setActivePinia(pinia);

    // On crée un routeur minimal avec les routes dont le composant a besoin
    router = createRouter({
      history: createMemoryHistory(),
      routes: [{ path: "/movies", component: MovieListView }],
    });

    // Simulation d'un utilisateur connecté avec ses données
    // A ADAPTER : les propriétés de auth.user dépendent de VOTRE backend

    const auth = useUserStore();
    auth.token = "fake-jwt-token";
    auth.user = {
      id: 1,
      email: "user@test.com",
      roles: ["ROLE_USER"],
      movies: [], //liste des favoris
    };
    auth.decoded = { id: 1, roles: ["ROLE_USER"] };
  });

  it('devrait afficher la liste des films après chargement', async () => {
    const wrapper = mount(MovieListView,{
        global:{ plugins: [pinia,router]}
    })
    await flushPromises()

    expect(wrapper.text()).toContain('Inception')
    expect(wrapper.text()).toContain('Breaking Bad')
  })
});
