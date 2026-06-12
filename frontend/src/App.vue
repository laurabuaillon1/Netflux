<script setup>
import { RouterView } from 'vue-router';
import MovieItem from './components/MovieItem.vue';
import MovieListView from './views/MovieListView.vue';
import HomeView from './views/HomeView.vue';
import NavBar from './components/NavBar.vue';


</script>

<template>
  <div class="layout-container">
    <NavBar/>
  </div>

  <body>
    <RouterView/>
  </body>
</template>

<style scoped>
</style>
