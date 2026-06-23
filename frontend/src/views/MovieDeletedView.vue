<script setup>
import { ref, onMounted } from 'vue';
// import api from '@/api/axios';
import { useMovies } from '@/composables/useMovies';
import { useRouter } from 'vue-router';

const { fetchMovies, deleteMovie, movies, loading, error } = useMovies();
const router = useRouter();
const selectedMovieId = ref(null);


//utilisation du composable
onMounted(async () => {
    await fetchMovies();
});


// Gestion de la soumission
const handleSubmit = async () => {
    await deleteMovie(selectedMovieId.value);
    router.push({ name: 'admin' })

};


</script>
<template>
    <div class="form-page-wrapper">
        <div class="form-container">
            <router-link to="/admin" class="back-link">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2.5" class="back-icon">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                Retour au panel
            </router-link>
            <h2>Supprimer un Film/Série</h2>
            <div class="form-group">
                <label for="movie">Choisir un film à supprimer</label>
                <div class="select-wrapper">
                    <select id="movie" v-model="selectedMovieId" required>
                        <option value="">-- Sélectionner un film --</option>
                        <option v-for="movie in movies" :key="movie.id" :value="movie.id">
                            {{ movie.title }}
                        </option>
                    </select>
                </div>
            </div>
            <button @click="handleSubmit" class="submit-btn danger">Confirmer la suppression</button>
        </div>
    </div>
</template>

<style scoped>
/* Conteneur global aligné sur la charte Deep Dark */
.form-page-wrapper {
    --bg-color: #0d0e12;
    --card-bg: #161820;
    --accent-color: #6366f1;
    --accent-hover: #4f46e5;
    --text-main: #ffffff;
    --text-muted: #9ca3af;
    --radius: 12px;
    --transition: all 0.3s ease;

    background-color: var(--bg-color);
    min-height: 100vh;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 4rem 1rem;
    font-family: 'Inter', system-ui, -apple-system, sans-serif;
    box-sizing: border-box;
}

/* Le bloc formulaire devient une carte sombre */
.form-container {
    max-width: 600px;
    width: 100%;
    background-color: var(--card-bg);
    padding: 3rem;
    border-radius: var(--radius);
    border: 1px solid rgba(255, 255, 255, 0.03);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
}

h2 {
    color: var(--text-main);
    font-size: 2rem;
    font-weight: 800;
    margin-bottom: 2rem;
    text-align: center;
    letter-spacing: -0.5px;
}

.form-group {
    margin-bottom: 1.5rem;
    display: flex;
    flex-direction: column;
}

.form-row {
    display: flex;
    gap: 1.5rem;
}

.form-row .form-group {
    flex: 1;
}

label {
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--text-muted);
    margin-bottom: 0.5rem;
}

/* Style uniforme des inputs */
input[type="text"],
input[type="date"],
input[type="number"],
input[type="url"],
select,
textarea {
    width: 100%;
    padding: 0.85rem 1rem;
    background-color: rgba(255, 255, 255, 0.03);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 8px;
    color: var(--text-main);
    font-size: 0.95rem;
    transition: var(--transition);
    box-sizing: border-box;
}

input:focus,
select:focus,
textarea:focus {
    outline: none;
    background-color: rgba(255, 255, 255, 0.05);
    border-color: var(--accent-color);
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
}

/* Style appliqué aux options pour éviter le fond blanc natif */
select option {
    background-color: var(--card-bg);
    color: var(--text-main);
    padding: 0.85rem;
    /* Pris en compte par certains navigateurs */
}

/* Optionnel : Enlève le style blanc de l'option désactivée ou par défaut */
select option:disabled {
    color: var(--text-muted);
}

/* Adaptation spécifique calendrier Chrome/Safari */
input[type="date"]::-webkit-calendar-picker-indicator {
    filter: invert(1) opacity(0.6);
}

textarea {
    resize: vertical;
}

/* Flèche personnalisée pour le select sur fond sombre */
.select-wrapper {
    position: relative;
}

.select-wrapper::after {
    content: '▼';
    font-size: 0.7rem;
    color: var(--text-muted);
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    pointer-events: none;
}

select {
    appearance: none;
    cursor: pointer;
}

/* --- STYLE REVISITÉ POUR VOS CHECKBOXES ACTUELLES --- */

/* Alignement et grille pour l'affichage des genres */
.form-group:has(.checkbox-label) {
    display: flex;
    flex-direction: column;
}

/* Conteneur implicite : On applique la grille sur le parent direct des labels */
.form-group>label~.checkbox-label {
    margin-bottom: 0.5rem;
}

/* Pour faire une jolie grille comme avant sans toucher au HTML, 
   on cible les labels de type checkbox */
.checkbox-label {
    display: inline-flex;
    align-items: center;
    cursor: pointer;
    user-select: none;
    color: var(--text-muted);
    font-size: 0.95rem;
    font-weight: 500;
    margin-bottom: 0.75rem;
    transition: var(--transition);
}

/* Style de l'input checkbox redesigné nativement */
.checkbox-label input[type="checkbox"] {
    appearance: none;
    /* Supprime le style moche par défaut du navigateur */
    -webkit-appearance: none;
    width: 18px;
    height: 18px;
    border: 2px solid rgba(255, 255, 255, 0.2);
    border-radius: 4px;
    margin-right: 0.75rem;
    background-color: rgba(255, 255, 255, 0.03);
    cursor: pointer;
    display: inline-grid;
    place-content: center;
    /* Centre la future coche */
    transition: var(--transition);
    position: relative;
}

/* Effet au survol de la case */
.checkbox-label:hover input[type="checkbox"] {
    border-color: var(--accent-color);
}

/* Style quand la case est cochée */
.checkbox-label input[type="checkbox"]:checked {
    background-color: var(--accent-color);
    border-color: var(--accent-color);
    box-shadow: 0 0 10px rgba(99, 102, 241, 0.3);
}

/* Dessin de la coche blanche en CSS pur dans l'input coché */
.checkbox-label input[type="checkbox"]:checked::before {
    content: "";
    width: 5px;
    height: 9px;
    border: solid white;
    border-width: 0 2px 2px 0;
    transform: rotate(45deg);
    margin-top: -2px;
    /* Ajustement précis du centrage */
}

/* Changement de couleur du texte du label quand coché */
.checkbox-label:has(input:checked) {
    color: var(--text-main);
}

.back-link {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--text-muted);
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 600;
    margin-bottom: 1.5rem;
    transition: var(--transition);
}

.back-icon {
    width: 16px;
    height: 16px;
    transition: var(--transition);
}

/* Animation au survol : le texte s'allume et la flèche glisse vers la gauche */
.back-link:hover {
    color: var(--accent-color);
}

.back-link:hover .back-icon {
    transform: translateX(-4px);
}


/* ---------------------------------------------------- */

/* Bouton Néon Violet */
.submit-btn {
    width: 100%;
    padding: 1rem;
    background-color: rgb(241, 99, 99);
    color: var(--text-main);
    border: none;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: 700;
    cursor: pointer;
    margin-top: 1.5rem;
    transition: var(--transition);
    box-shadow: 0 4px 15px rgba(241, 99, 99, 0.2);
}

.submit-btn:hover {
    background-color: rgb(241, 99, 99);
    box-shadow: 0 6px 20px rgba(241, 99, 99, 0.4);
    transform: translateY(-2px);
}

.submit-btn:active {
    transform: translateY(0);
}
</style>
