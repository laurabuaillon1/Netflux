<script setup>
import api from '@/api/axios';
import { computed, onMounted, ref, watch } from 'vue';
import { useMovies } from '@/composables/useMovies';

const { movies, loading, error, fetchMovies } = useMovies()


const selectedGenre = ref('');
const genres = ref([]);

//Apeller endpoint 
onMounted(async () => {
    // const moviesResponse = await api.get("/movies");
    // movies.value = moviesResponse.data.member;
    // console.log(moviesResponse.data);
     fetchMovies()
    

    const genresResponse = await api.get("/genres");
    genres.value = genresResponse.data.member;
    console.log(genresResponse.data);

})


//////////////FILTRES////////////////////

// Variables réactives pour les filtres
const selectedCategory=ref('')

//watcher pour surveiller les changements de filtres
watch([selectedCategory],() => {
    console.log(`Filtres appliqués - ${filteredMovies.value.length} produits trouvés`)
}, {deep : true})


// // Afficher la liste des genres dans le dropdown
// const genre = computed(() =>
//     selectedGenre.value.filter(movie => movie.genre === 'action')
// )

const filteredMovies = computed(() => {
    let filtered = movies.value

    if(selectedGenre.value){
        filtered = filtered.filter(movie => movie.belong.some(genre=>genre.name === selectedGenre.value))
    }

    return filtered
})
console.log(filteredMovies)

</script>
<template>
    <div class="app-container">
        <div class="filter-container">
            <select v-model="selectedGenre" class="custom-select">
                <option value="">Tout les genres</option>
                <option v-for="genre in genres" :key="genre.id" :value="genre.name">
                    {{ genre.name }}
                </option>
            </select>
        </div>

        <div class="movies-grid">
            <div v-for="film in filteredMovies" :key="film.id" class="movie-card">
                <div class="card-image-wrapper">
                    <img :src="film.imageUrl" alt="image_film" class="movie-image">
                    <div class="card-overlay">
                        <router-link :to="`/movies/${film.id}`" class="info-btn">
                            Informations
                        </router-link>
                    </div>
                </div>

                <div class="movie-details">
                    <h3 class="movie-title">{{ film.title }}</h3>
                    <div class="movie-meta">
                        <span>{{ film.releaseDate }}</span>
                        <span class="separator">•</span>
                        <span>{{ film.duration }} min</span>
                    </div>
                    <div class="movie-genres">
                        <span v-for="genre in film.belong" :key="genre.id" class="genre-badge">
                            {{ genre.name }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style scoped></style>