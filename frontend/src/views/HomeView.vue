<script setup>
import FAQ from '@/components/FAQ.vue';
import MovieItem from '@/components/MovieItem.vue';
import ReasonsSection from '@/components/ReasonsSection.vue';
import { useMovies } from '@/composables/useMovies';
import { useUserStore } from '@/stores/user';
import { onMounted } from 'vue';
import { ref } from 'vue';
const stores = useUserStore();

const { onlyMovies, onlySeries, recentMovies, bestRateMovies, loading, error, fetchMovies } = useMovies();
const slider = ref(null)

const scroll = (direction) => {
    if (slider.value) {
        const scroolAmount = slider.value.clientWidth * 0.8

        slider.value.scrollBy({
            left: direction === 'left' ? -scroolAmount : scroolAmount,
            behavior: 'smooth'
        })
    }
}

onMounted(() => {
    fetchMovies()
})




</script>
<template>
    <div class="hero">
        <img class="hero-bg"
            src="https://assets.nflxext.com/ffe/siteui/vlv3/8027eb3f-343a-499d-9892-e683c12e3cb1/web/FR-fr-20260608-TRIFECTA-perspective_01cce5ee-f30f-4479-9c42-43ab6f600d95_medium.jpg"
            alt="Films Netflux">
        <div class="hero-overlay"></div>

        <div class="hero-content">
            <h1>Films et séries en illimité, et bien plus</h1>
            <p class="hero-price">À partir de {{ stores.price }} €. Annulable à tout moment.</p>
            <p class="hero-cta-text">Prêt à regarder Netflux ? Saisissez votre adresse e-mail pour commencer.</p>
            <div class="form-group">
                <RouterLink to="/register" class="btn-submit">S'inscrire</RouterLink>
            </div>
        </div>
    </div>
    <div class="home-view">
        <h2 class="section-title">Découvrez nos films</h2>
        <div v-if="loading">Chargement...</div>
        <div v-else-if="error" class="error-message">{{ error }}</div>
        <div v-else class="carousel-wrapper">
            <button class="nav-btn prev" @click="scroll('left')">‹</button>
            <div ref="slider" class="movies-slider">
                <MovieItem v-for="movie in onlyMovies" :key="movie.id" :movie="movie" class="slider-item" />
            </div>
            <button class="nav-btn next" @click="scroll('right')">›</button>
        </div>
    </div>
    <div class="home-view">
        <h2 class="section-title">Découvrez nos séries</h2>
        <div v-if="loading">Chargement...</div>
        <div v-else-if="error" class="error-message">{{ error }}</div>
        <div v-else class="carousel-wrapper">
            <button class="nav-btn prev" @click="scroll('left')">‹</button>
            <div ref="slider" class="movies-slider">
                <MovieItem v-for="movie in onlySeries" :key="movie.id" :movie="movie" class="slider-item" />
            </div>
            <button class="nav-btn next" @click="scroll('right')">›</button>
        </div>
    </div>
    <div class="home-view">
        <h2 class="section-title">Les mieux noté</h2>
        <div v-if="loading">Chargement...</div>
        <div v-else-if="error" class="error-message">{{ error }}</div>
        <div v-else class="carousel-wrapper">
            <button class="nav-btn prev" @click="scroll('left')">‹</button>
            <div ref="slider" class="movies-slider">
                <MovieItem v-for="movie in bestRateMovies" :key="movie.id" :movie="movie" class="slider-item" />
            </div>
            <button class="nav-btn next" @click="scroll('right')">›</button>
        </div>
    </div>
    <div class="home-view">
        <h2 class="section-title">Nouveaux Films/Séries</h2>
        <div v-if="loading">Chargement...</div>
        <div v-else-if="error" class="error-message">{{ error }}</div>
        <div v-else class="carousel-wrapper">
            <button class="nav-btn prev" @click="scroll('left')">‹</button>
            <div ref="slider" class="movies-slider">
                <MovieItem v-for="movie in recentMovies" :key="movie.id" :movie="movie" class="slider-item" />
            </div>
            <button class="nav-btn next" @click="scroll('right')">›</button>
        </div>
    </div>
    <ReasonsSection/>
    <FAQ/>
    

</template>

<style scoped>
.hero {
    position: relative;
    width: 100%;
    height: 80vh;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    overflow: hidden;
}

.hero-bg {
    position: absolute;
    width: 100%;
    height: 80vh;
    object-fit: cover;
    z-index: 0;
}

.hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to bottom,
            rgba(0, 0, 0, 0.4) 0%,
            rgba(0, 0, 0, 0.6) 50%,
            rgba(0, 0, 0, 0.8) 100%);
    z-index: 1;
}

.hero-content {
    position: relative;
    z-index: 2;
    max-width: 650px;
    padding: 0 1.5rem;
    color: #ffffff;
}

.hero-content h1 {
    font-size: 3rem;
    font-weight: 700;
    line-height: 1.2;
    margin-bottom: 1rem;
}

.hero-price {
    font-size: 1.1rem;
    margin-bottom: 0.5rem;
}

.hero-cta-text {
    font-size: 1.1rem;
    margin-bottom: 1.5rem;
}

/* .hero-form {
    display: flex;
    gap: 0.5rem;
    justify-content: center;
} */

.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.6rem;
    /* Espace entre le label et l'input */
}

/* --- LES INPUTS --- */
.form-input {
    width: 100%;
    background-color: #1f222f;
    /* Fond nettement plus clair que la carte */
    color: #ffffff;
    border: 2px solid rgba(255, 255, 255, 0.1);
    /* Bordure visible par défaut */
    border-radius: 10px;
    padding: 1rem 1.2rem;
    /* Plus grand pour cliquer facilement */
    font-size: 1rem;
    outline: none;
    box-sizing: border-box;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Couleur du texte d'exemple (placeholder) */
.form-input::placeholder {
    color: #6b7280;
}

/* Effet de Focus (Quand on clique dedans) */
.form-input:focus {
    border-color: #6366f1;
    /* Devient violet électrique */
    background-color: #242837;
    /* S'éclaircit un poil */
    box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.15);
    /* Halo lumineux subtil */
}

.btn-submit {
    background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
    color: #ffffff;
    border: none;
    border-radius: 10px;
    padding: 1rem;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    margin-top: 0.5rem;
    /* Espace bonus avant le bouton */
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(99, 102, 241, 0.2);
}

/* Carroussel */

.home-view {
    
    /* Fond noir style Netflix */
    color: #fff;
    padding: 40px 20px;
    overflow: hidden;
}

.section-title {
    font-size: 1.4rem;
    font-weight: bold;
    margin-bottom: 10px;
}

/* Conteneur global pour positionner les flèches */
.carousel-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

/* Le slider horizontal */
.movies-slider {
    display: flex;
    gap: 16px;
    /* Petit espace entre les affiches */
    overflow-x: auto;
    /* Permet le défilement en arrière-plan */
    scroll-behavior: smooth;
    width: 100%;
    padding: 10px 0;
}

/* Masquer les barres de défilement */
.movies-slider::-webkit-scrollbar {
    display: none;
}

.movies-slider {
    -ms-overflow-style: none;
    scrollbar-width: none;
}

/* Style de chaque affiche de film */
.slider-item {
    flex: 0 0 auto;
    width: 20%;
    height: 40vh;
    /* Ajuste la largeur selon tes besoins */
    /*aspect-ratio: 2 / 3;   Ratio standard des affiches de film verticales*/
    border-radius: 16px;
    overflow: hidden;
    transition: transform 0.3s ease;
}

/* Optionnel : Léger effet zoom au survol comme sur Netflix */
.slider-item:hover {
    transform: scale(1.05);
    z-index: 10;
}

/* Style commun des flèches de navigation */
.nav-btn {
    position: absolute;
    top: 10px;
    bottom: 10px;
    width: 45px;
    background: rgba(0, 0, 0, 0.5);
    color: white;
    border: none;
    font-size: 2.5rem;
    cursor: pointer;
    z-index: 5;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.2s, opacity 0.2s;
    opacity: 0;
    /* Cachées par défaut */
}

/* On affiche les flèches uniquement quand on survole le carrousel */
.carousel-wrapper:hover .nav-btn {
    opacity: 1;
}

.nav-btn:hover {
    background: rgba(0, 0, 0, 0.8);
}

/* Positionnement des boutons */
.prev {
    left: 0;
    border-top-right-radius: 4px;
    border-bottom-right-radius: 4px;
}

.next {
    right: 0;
    border-top-left-radius: 4px;
    border-bottom-left-radius: 4px;
}


</style>