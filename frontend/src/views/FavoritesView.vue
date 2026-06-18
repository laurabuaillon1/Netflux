<script setup>
import { onMounted } from 'vue';
import api from '@/api/axios';
import MovieItem from '@/components/MovieItem.vue';
import { useUsers } from '@/composables/useUsers';


const { user, users, getMe, getFavorites } = useUsers();

onMounted(async () => {
    await getMe();
    await getFavorites();
})

</script>
<template>
    <div class="favorites-container">
        <h1 class="logo-accent">Mes favoris</h1>
        
        <div class="movies-grid">
            <MovieItem 
                v-for="movie in users" 
                :key="movie.id" 
                :movie="movie" 
            />
        </div>
    </div>
</template>

<style scoped>
.favorites-container {
    padding: 20px;
    max-width: 1200px;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    gap: 16px;
}

h1 {
    color: var(--accent-color);
    background: linear-gradient(45deg, #6366f1, #a855f7);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    font-size: 3rem;
    text-align: center;
    font-weight: 800;
    letter-spacing: -0.5px;
    
}

/* La grille magique qui rend le tout responsive */
.movies-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 24px; /* Espace entre les cartes */
}

</style>