<script setup>
import { ref } from 'vue'

// 1. On définit les "props" pour savoir si le film est déjà en favori au départ
const props = defineProps({
  isInitiallyFavorite: {
    type: Boolean,
    default: false
  }
})

// 2. On définit l'événement que le bouton va envoyer au parent
const emit = defineEmits(['toggle-favorite'])


// 3. État local pour gérer l'affichage réactif
const isFavorite = ref(props.isInitiallyFavorite)

// 4. Fonction au clic
const toggleFavorite = () => {
  console.log('toggleFavorite appelé');
  isFavorite.value = !isFavorite.value
  // On prévient le parent et on lui passe le nouvel état (true/false)
  emit('toggle-favorite', isFavorite.value)
}
</script>
<template>
  <button @click="toggleFavorite" :class="['fav-btn', { 'is-fav': isFavorite }]"
    :aria-label="isFavorite ? 'Retirer des favoris' : 'Ajouter aux favoris'">
    <span class="heart-icon">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="heart-svg"
        :class="{ 'is-favorite': isFavorite }">
        <path d="M0 0h24v24H0z" fill="none" />
        <path
          d="m12 21.35l-1.45-1.32C5.4 15.36 2 12.27 2 8.5C2 5.41 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.08C13.09 3.81 14.76 3 16.5 3C19.58 3 22 5.41 22 8.5c0 3.77-3.4 6.86-8.55 11.53z" />
      </svg>
    </span>

    <span class="btn-text">
      {{ isFavorite ? 'Favori !' : 'Ajouter aux favoris' }}
    </span>
  </button>
</template>

<style scoped>
.fav-btn {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 10px 16px;
  border-radius: 10px;
  background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
  color: #ffffff;
  /* Le !important évite que le style des liens classiques prenne le dessus */
  text-decoration: none;
  color: #ffffff;
  font-weight: bold;
  cursor: pointer;
  transition: all 0.3s ease;
}

.fav-btn:hover {
  transform: scale(1.05);
}

/* Styles quand le film est en favori */
.fav-btn.is-fav {
  color: #ffffff;
}

/* .heart-icon {
  font-size: 1.2rem;

} */

 .heart-icon {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
}

.heart-svg {
  width: 24px;
  height: 24px;
  transition: all 0.2s ease-in-out;
  display: inline-block;
}

/* On applique la bordure UNIQUEMENT au cœur (le 2ème path) */
.heart-svg path:nth-child(2) {
  fill: transparent;
  stroke: #b3b3b3; /* Votre bordure grise */
  stroke-width: 2px;
  transition: all 0.2s ease-in-out;
}

/* Effet au survol */
.heart-svg:hover {
  transform: scale(1.15);
}


/* Style actif : Favori (Cœur rouge plein sans bordure parasite) */
.heart-svg.is-favorite path:nth-child(2) {
  fill: #e61e1e;
  stroke: #e61e1e;
}
</style>