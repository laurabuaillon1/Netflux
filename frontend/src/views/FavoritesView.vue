<script setup>
import { onMounted } from 'vue';
import MovieItem from '@/components/MovieItem.vue';
import { useUsers } from '@/composables/useUsers';


const { user, users, getMe, getFavorites, toggleFavorite } = useUsers();

onMounted(async () => {
    await getMe();
    await getFavorites();
})

//Fonction pour retirer le film et actualiser la liste instantanément
const handleRemove = async (movieId) => {
    await toggleFavorite(movieId);
    if (!user.value || !user.value.id) {
        await getMe();
    }
    await getFavorites(); // Re-télécharge la liste mise à jour
};

</script>
<template>
    <div class="favorites-container">
        <h1 class="logo-accent">Mes favoris</h1>

        <div class="movies-grid">
            <div v-for="movie in users" :key="movie.id" class="movie-card-wrapper">
                <MovieItem :movie="movie" />
                
                <button @click="handleRemove(movie.id)" class="remove-btn">
                    Retirer des favoris
                </button>
            </div>
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
    gap: 24px;
    /* Espace entre les cartes */
}

.movie-card-wrapper {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.remove-btn {
    background-color: #ef4444; /* Rouge */
    color: white;
    border: none;
    padding: 8px 12px;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 600;
    transition: background 0.2s;
}

.remove-btn:hover {
    background-color: #dc2626;
}
</style>