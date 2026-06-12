<script setup>
import Button from './Button.vue';



</script>
<template>
    <div>
        <div class="navbar">
            <div class="nav-left">
                <h1 class="logo">Net<span class="logo-accent">Flux</span></h1>
                <div class="nav-links">
                    <router-link to="/" class="nav-item">Home</router-link>
                    <router-link to="/movies" class="nav-item">Films</router-link>
                    <router-link to="/favorites" class="nav-item">Favoris</router-link>
                </div>
            </div>

            <div class="nav-right">
                <div class="route-badge">
                    <span class="pulse-dot"></span>
                    {{ $route.fullPath }}
                </div>
            </div>

            <Button />
            <!-- <router-link to="/login" class="btn-login">
        <span>Connexion</span>
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="btn-icon">
          <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
          <polyline points="10 17 15 12 10 7"></polyline>
          <line x1="15" y1="12" x2="3" y2="12"></line>
        </svg>
      </router-link> -->


        </div>
    </div>
</template>

<style scoped>
/* Variables globales (à garder si vous ne les avez pas déjà mises ailleurs) */
:root {
    --bg-color: #0d0e12;
    --card-bg: #161820;
    --accent-color: #6366f1;
    /* Violet/Indigo électrique */
    --accent-hover: #4f46e5;
    --text-main: #ffffff;
    --text-muted: #9ca3af;
    --radius: 12px;
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Structure globale pour éviter les sauts de page */
.layout-container {
    background-color: var(--bg-color);
    min-height: 100vh;
    color: var(--text-main);
    font-family: 'Segoe UI', Roboto, sans-serif;
}

/* --- Barre de Navigation --- */
.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    background-color: rgba(13, 14, 18, 0.93);
    /* Effet transparent */
    backdrop-filter: blur(12px);
    /* Flou de fond style Apple/Netflix moderne */
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    position: sticky;
    top: 0;
    z-index: 100;
}

/* Partie gauche : Logo + Liens */
.nav-left {
    display: flex;
    align-items: center;
    gap: 3rem;
}

/* Remplacement du vieux titre rouge par un logo moderne */
.logo {
    font-size: 1.6rem;
    font-weight: 800;
    letter-spacing: -0.5px;
    margin: 0;
    color: var(--text-main);
}

.logo-accent {
    color: var(--accent-color);
    background: linear-gradient(45deg, #6366f1, #a855f7);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

/* Liens de navigation */
.nav-links {
    display: flex;
    gap: 1.5rem;
}

.nav-item {
    color: var(--text-muted);
    text-decoration: none;
    font-weight: 500;
    font-size: 0.95rem;
    transition: var(--transition);
    position: relative;
    padding: 0.5rem 0;
}

/* Effet de survol et classe active de Vue Router */
.nav-item:hover,
.router-link-active.nav-item {
    color: var(--text-main);
}

/* Petite barre violette sous le lien actif (très Netflix) */
.nav-item::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    width: 0;
    height: 2px;
    background-color: var(--accent-color);
    transition: var(--transition);
    transform: translateX(-50%);
}

.router-link-active.nav-item::after {
    width: 100%;
}

/* --- Partie droite : Badge de Route --- */
.nav-right {
    display: flex;
    align-items: center;
}

.route-badge {
    background-color: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
    padding: 0.4rem 0.8rem;
    border-radius: 20px;
    font-size: 0.8rem;
    color: var(--text-muted);
    font-family: monospace;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

/* Petit point clignotant "Live" à côté de la route */
.pulse-dot {
    width: 6px;
    height: 6px;
    background-color: #10b981;
    /* Vert connecté */
    border-radius: 50%;
    box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% {
        transform: scale(0.95);
        box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
    }

    70% {
        transform: scale(1);
        box-shadow: 0 0 0 6px rgba(16, 185, 129, 0);
    }

    100% {
        transform: scale(0.95);
        box-shadow: 0 0 0 0 rgba(16, 185, 129, 0);
    }
}

/* Zone de contenu sous la navbar */
.main-content {
    padding: 2rem;
}
</style>