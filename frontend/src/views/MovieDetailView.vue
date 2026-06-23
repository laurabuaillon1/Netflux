<script setup>
import { useMovies } from '@/composables/useMovies';
import { onMounted } from 'vue';
import { useRoute } from 'vue-router';


const { movie, loading, error, fetchMovie } = useMovies()
const route = useRoute();
const id = route.params.id;

//Appeler endpoint depuis index.js
onMounted(async () => {
    fetchMovie(route.params.id)

})
console.log(route.params.id)


</script>
<template lang="">
    <div v-if="movie" class="movie-details">
        <img :src="movie.imageUrl" alt="image_film" class="movie-image">
                    <h3 class="movie-title">{{ movie.title }}</h3>
                    <div class="movie-genres">
                        <span v-for="genre in movie.belong" :key="genre.id" class="genre-badge">
                            {{ genre.name }}
                        </span>
                    </div>
                    <p class="movie-synopsis">{{movie.synopsis}}</p>
                    <div class="movie-meta">
                        <span>{{movie.rating}}</span>
                        <span>{{ movie.releaseDate }}</span>
                        <span class="separator">•</span>
                        <span>{{ movie.duration }} min</span>
                        <span>{{movie.type}}</span>
                        <video controls >
  <source :src="movie.videoUrl" type="video/webm" /></video>
                    </div>
                    
    </div>
            
</template>

<style scoped>
/* Conteneur principal immersif (prend toute la page)
.movie-details {
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  justify-content: center; /* Centre verticalement le contenu si la page est grande */

/* box-sizing: border-box;
  gap: 2rem;
  max-width: 1400px; /* Limite la largeur sur les écrans ultra-larges pour rester lisible */
/* margin: 0 auto; */
/* } */

/* Image / Banner du film */
.movie-image {
    width: 100%;
    max-height: 50vh;
    /* Prend la moitié de la hauteur de l'écran maximum */
    object-fit: cover;
    border-radius: var(--radius);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.6);
}

/* Titre XXL style Blockbuster */
.movie-title {
    font-size: clamp(2.5rem, 6vw, 4rem);
    /* S'adapte dynamiquement à la taille de l'écran */
    font-weight: 900;
    letter-spacing: -1.5px;
    margin: 0;
    line-height: 1.1;
    background: linear-gradient(135deg, var(--text-main) 50%, var(--accent-color));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

/* Métadonnées (Aligne tout sur une ligne propre) */
.movie-meta {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 1.5rem;
    font-size: 1rem;
    color: var(--text-muted);
    justify-content: center;
}

/* Badge de note vert fluo moderne */
.movie-meta span:first-child {
    color: #10b981;
    font-weight: 700;
    background: rgba(16, 185, 129, 0.15);
    padding: 4px 10px;
    border-radius: 6px;
}

.separator {
    color: var(--accent-color);
    opacity: 0.7;
}

/* Lecteur Vidéo (Style intégration invisible) */
.movie-meta video {
    width: 100%;
    height: 40vh;
    border-radius: var(--radius);
    border: 1px solid rgba(255, 255, 255, 0.1);
    background-color: #000;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
}

/* Synopsis aéré */
.movie-synopsis {
    font-size: 1.15rem;
    line-height: 1.7;
    color: var(--text-muted);
    max-width: 800px;
    /* Évite que le texte soit trop long à lire sur grand écran */
    margin: 0;
}

/* Badges de genres */
.movie-genres {
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
}

.genre-badge {
    background: rgba(99, 102, 241, 0.08);
    color: var(--accent-color);
    padding: 0.5rem 1.2rem;
    border-radius: 50px;
    font-size: 0.9rem;
    font-weight: 600;
    border: 1px solid rgba(99, 102, 241, 0.2);
    transition: var(--transition);
}

.genre-badge:hover {
    background: var(--accent-color);
    color: var(--text-main);
    box-shadow: 0 0 15px rgba(99, 102, 241, 0.5);
}

/* --- Mise en page pour grands écrans (PC / TV) --- */
@media (min-width: 992px) {
    .movie-details {
        display: flex;
        flex-direction: column;
        text-align: center;
        align-items: center;
        gap: 4rem;
        padding: 4rem;
    }

    .movie-image {
        max-height: 80vh;
        /* L'image peut être beaucoup plus grande et immersive */
        height: 100%;
    }

    /* Structure de la colonne de droite */
    .movie-title,
    .movie-meta,
    .movie-synopsis,
    .movie-genres {
        grid-column: 2;
    }
}
</style>