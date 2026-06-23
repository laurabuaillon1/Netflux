<script setup>
import { ref } from 'vue';
import MovieItem from './MovieItem.vue';


const movieList= ref([]);


</script>
<template>
    <div>
        <h1>Liste des films</h1>
        <MovieItem 
            v-for="movie in movieList" 
            :key="movie.id"
            :movie="movie"
            :genre="movie.genre"
        />
    </div>
</template>

<style scoped>
    
</style>