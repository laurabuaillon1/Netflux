<script setup>
import api from '@/api/axios';
import { computed, onMounted, ref, watch } from 'vue';
import { useMovies } from '@/composables/useMovies';
import FavoriteButton from '@/components/FavoriteButton.vue';
import MovieList from '@/components/MovieList.vue';
import MovieItem from '@/components/MovieItem.vue';

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
    

})


//////////////FILTRES////////////////////

// Variables réactives pour les filtres
const selectedCategory = ref('')

//watcher pour surveiller les changements de filtres
watch([selectedCategory], () => {
    console.log(`Filtres appliqués - ${filteredMovies.value.length} produits trouvés`)
}, { deep: true })


// // Afficher la liste des genres dans le dropdown
// const genre = computed(() =>
//     selectedGenre.value.filter(movie => movie.genre === 'action')
// )

const filteredMovies = computed(() => {
    let filtered = movies.value

    if (selectedGenre.value) {
        filtered = filtered.filter(movie => movie.belong.some(genre => genre.name === selectedGenre.value))
    }

    return filtered
})


</script>
<template>
    <div class="app-container">
        <div class="filter-container">
            <select v-model="selectedGenre" class="custom-select" id="genre">
                <option value="">Tout les genres</option>
                <option v-for="genre in genres" :key="genre.id" :value="genre.name">
                    {{ genre.name }}
                </option>
            </select>
        </div>

        <!-- <MovieList/> -->
        <div class="movies-grid">
            <MovieItem v-for="film in filteredMovies" :key="film.id" class="movie-card" :movie="film">
            </MovieItem>
        </div>
    </div>
</template>
<style scoped></style>