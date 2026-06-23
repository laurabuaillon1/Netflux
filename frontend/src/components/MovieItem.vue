<script setup>
import { onMounted } from 'vue';
// console.log('MovieItem chargé');
import FavoriteButton from './FavoriteButton.vue';
import { useUsers } from '@/composables/useUsers.js';


const { user, getMe, toggleFavorite } = useUsers();


const props = defineProps({
    movie: {
        type: Object,
        required: true
    },
});

onMounted(async () => {
    await getMe();

})

const handleFavorite = async (isFavorite) => {
    await toggleFavorite(props.movie.id);
    // console.log('isFavorite:', isFavorite);
    // console.log('user:', user.value);

}
</script>
<template>
    <div class="movie-card">
        <div class="card-image-wrapper">
            <img :src="movie.imageUrl" alt="image_film" class="movie-image">
            <div class="card-overlay">
                <!-- <router-link :to="`/movies/${film.id}`" class="info-btn">
                    Informations
                </router-link> -->
                <div class="action">
                    <router-link :to="`/movies/${movie.id}`" class="info-btn">Informations</router-link>
                    <!-- <router-link :to="`/edit/`" -->
                </div>
            </div>
        </div>

        <div class="movie-details">
            <div class="movie-detail_container">
                <h1 class="movie-title">{{ movie.title }}</h1>
                <div class="movie-meta">
                    <span>{{ movie.releaseDate }}</span>
                    <span class="separator">•</span>
                    <span>{{ movie.duration }} min</span>
                </div>
                <div class="movie-genres">
                    <span v-for="genre in movie.belong" class="genre-badge">
                        {{ genre.name }}
                    </span>
                </div>
            </div>
            <FavoriteButton @toggle-favorite="handleFavorite" />

            <!-- <h2>{{ movie.title }}</h2>
        <p>{{ movie.release_date }}</p>
        <p>{{ movie.duration }}</p>
        <p v-for="genre in movie.belong">{{ genre.name }}</p> -->
        </div>
    </div>
</template>

<style scoped></style>