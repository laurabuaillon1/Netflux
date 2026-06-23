<script setup>
import { ref, reactive, onMounted, watch } from 'vue';
import api from '@/api/axios';
import { useMovies } from '@/composables/useMovies';
import { useRouter } from 'vue-router';

const { fetchMovies, updateMovie, movies, loading, error } = useMovies();

const router = useRouter();
const genres = ref([]);
const selectedMovieId = ref(null);


//utilisation du composables
onMounted(async () => {
    await fetchMovies();
    const res = await api.get("/genres");
    genres.value = res.data.member;
});

// Quand on choisit un film, on pré-remplit le formulaire
watch(selectedMovieId, (id) => {
    const movie = movies.value.find(m => m.id === parseInt(id));
    if (movie) {
        formData.title = movie.title;
        formData.synopsis = movie.synopsis;
        formData.releaseDate = movie.releaseDate?.split('T')[0];
        formData.duration = movie.duration;
        formData.rating = movie.rating;
        formData.type = movie.type;
        formData.imageUrl = movie.imageUrl;
        formData.videoUrl = movie.videoUrl;
        formData.belong = movie.belong.map(g => g['@id'] ?? g);
    }
});

// Initialisation des données du formulaire
const formData = reactive({
    title: '',
    synopsis: '',
    releaseDate: '',
    duration: null,
    rating: 0,
    type: 'Film', // Valeur par défaut de l'enum MovieType
    imageUrl: '',
    videoUrl: '',
    belong: [] // Tableau pour stocker les genres sélectionnés (ManyToMany)
});

// Gestion de la soumission
const handleSubmit = async () => {
    await updateMovie(selectedMovieId.value, formData);
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

            <h2>Modifier un Film/Série</h2>

            <form @submit.prevent="handleSubmit">

                <div class="form-group">
                    <label for="movie">Choisir un film</label>
                    <div class="select-wrapper">
                        <select id="movie" v-model="selectedMovieId" required>
                            <option value="">-- Sélectionner un film --</option>
                            <option v-for="movie in movies" :key="movie.id" :value="movie.id">
                                {{ movie.title }}
                            </option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="title">Titre *</label>
                    <input type="text" id="title" v-model="formData.title" required placeholder="Ex: Inception" />
                </div>

                <div class="form-group">
                    <label for="type">Type *</label>
                    <div class="select-wrapper">
                        <select id="type" v-model="formData.type" required>
                            <option value="Film">Film</option>
                            <option value="Série">Série</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="synopsis">Synopsis</label>
                    <textarea id="synopsis" v-model="formData.synopsis" rows="4"
                        placeholder="Résumé de l'œuvre..."></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="releaseDate">Date de sortie</label>
                        <input type="date" id="releaseDate" v-model="formData.releaseDate" />
                    </div>

                    <div class="form-group">
                        <label for="duration">Durée (en minutes)</label>
                        <input type="number" id="duration" v-model.number="formData.duration" min="0" />
                    </div>
                </div>

                <div class="form-group">
                    <label for="rating">Note (0 à 5)</label>
                    <input type="number" id="rating" v-model.number="formData.rating" min="0" max="5" stroke-width="2"
                        step="0.1" />
                </div>

                <div class="form-group">
                    <label for="imageUrl">URL de l'image</label>
                    <input type="url" id="imageUrl" v-model="formData.imageUrl"
                        placeholder="https://link-to-image.com/poster.jpg" />
                </div>

                <div class="form-group">
                    <label for="videoUrl">URL de la vidéo (Bande-annonce)</label>
                    <input type="url" id="videoUrl" v-model="formData.videoUrl" placeholder="https://youtube.com/..." />
                </div>

                <div class="form-group">
                    <label>Genres</label>
                    <label v-for="genre in genres" :key="genre.id" class="checkbox-label">
                        <input type="checkbox" :value="genre['@id']" v-model="formData.belong" />
                        {{ genre.name }}
                    </label>
                </div>

                <button type="submit" class="submit-btn">Enregistrer</button>
            </form>
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
    position: relative;
    /* Nécessaire si on veut ajuster des éléments */
}

/* --- STYLE DU BOUTON RETOUR --- */
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

/* ------------------------------ */

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

/* Options du select */
select option {
    background-color: var(--card-bg);
    color: var(--text-main);
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

/* --- STYLE DES CHECKBOXES --- */
.form-group:has(.checkbox-label) {
    display: flex;
    flex-direction: column;
}

.form-group>label~.checkbox-label {
    margin-bottom: 0.5rem;
}

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

.checkbox-label input[type="checkbox"] {
    appearance: none;
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
    transition: var(--transition);
    position: relative;
}

.checkbox-label:hover input[type="checkbox"] {
    border-color: var(--accent-color);
}

.checkbox-label input[type="checkbox"]:checked {
    background-color: var(--accent-color);
    border-color: var(--accent-color);
    box-shadow: 0 0 10px rgba(99, 102, 241, 0.3);
}

.checkbox-label input[type="checkbox"]:checked::before {
    content: "";
    width: 5px;
    height: 9px;
    border: solid white;
    border-width: 0 2px 2px 0;
    transform: rotate(45deg);
    margin-top: -2px;
}

.checkbox-label:has(input:checked) {
    color: var(--text-main);
}

/* Bouton Néon Violet */
.submit-btn {
    width: 100%;
    padding: 1rem;
    background-color: var(--accent-color);
    color: var(--text-main);
    border: none;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: 700;
    cursor: pointer;
    margin-top: 1.5rem;
    transition: var(--transition);
    box-shadow: 0 4px 15px rgba(99, 102, 241, 0.2);
}

.submit-btn:hover {
    background-color: var(--accent-hover);
    box-shadow: 0 6px 20px rgba(99, 102, 241, 0.4);
    transform: translateY(-2px);
}

.submit-btn:active {
    transform: translateY(0);
}
</style>