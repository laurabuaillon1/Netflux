<script setup>
import MovieItem from './MovieItem.vue';
import { ref } from 'vue';


const movieList= ref(['']);


</script>
<template>
    <div>
        <h1>Liste des films</h1>
        <p>{{ film.title }}</p>
        <p>{{ film.release_date }}</p>
        <p>{{ film.duration }}</p>
        <p>{{ genre.name }}</p>
        <router-link :to="`/movies/${film.id}`">Informations</router-link>
    </div>
</template>

<style scoped>
    
</style>