<script setup>
import { RouterView } from 'vue-router';
import MovieItem from './components/MovieItem.vue';
import MovieListView from './views/MovieListView.vue';
import HomeView from './views/HomeView.vue';
import NavBar from './components/NavBar.vue';
import Footer from './components/Footer.vue';
import Alert from './components/Alert.vue';


</script>

<template>
  <div class="layout-container">
    <NavBar/>
  </div>
  <RouterView/>
  <Alert/>
  <Footer/>
  

</template>

<style scoped>
</style>
