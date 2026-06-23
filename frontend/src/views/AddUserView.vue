<script setup>
import { reactive } from 'vue';
import { useUsers } from '@/composables/useUsers';
import { useRouter } from 'vue-router';

const { createUser, loading, error } = useUsers();
const router = useRouter();

// Liste des rôles autorisés par l'entité USER
const availableRoles = ['ROLE_USER', 'ROLE_ADMIN'];

// Initialisation des données du formulaire
const formData = reactive({
    email: '',
    password: '',
    pseudo: null,
    roles: ['ROLE_USER'],
});

// Gestion de la soumission
const handleSubmit = async () => {
    await createUser(formData);
    if (!error.value) {
        router.push({ name: 'admin' });
    }
    console.log('Nouvel utilisateur ajouté avec succès!')
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
                Retour à la console
            </router-link>

            <h2>Ajouter un Utilisateur</h2>

            <div v-if="error" class="error-banner">
                {{ error.response?.data?.['hydra:description'] || error.message || error }}
            </div>

            <form @submit.prevent="handleSubmit">
                <div class="form-group">
                    <label for="pseudo">Pseudo *</label>
                    <input type="text" id="pseudo" v-model="formData.pseudo" required minlength="2" maxlength="255"
                        placeholder="Ex: NeoFlix" />
                </div>

                <div class="form-group">
                    <label for="email">Adresse Email *</label>
                    <input type="email" id="email" v-model="formData.email" required
                        placeholder="exemple@netflux.com" />
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe *</label>
                    <input type="password" id="password" v-model="formData.password" required minlength="8"
                        placeholder="Min. 8 caractères ( lettre + 1 chiffre)" />
                </div>

                <div class="form-group">
                    <label>Rôles applicables</label>
                    <label v-for="role in availableRoles" :key="role" class="checkbox-label">
                        <input type="checkbox" :value="role" v-model="formData.roles" />
                        {{ role }}
                    </label>
                </div>

                <button type="submit" class="submit-btn" :disabled="loading">
                    <span v-if="loading">Création en cours...</span>
                    <span v-else>Créer l'utilisateur</span>
                </button>
            </form>
        </div>
    </div>
</template>

<style scoped>
/* Conteneur global (Deep Dark & Neon Violet) */
.form-page-wrapper {
    --bg-color: #0d0e12;
    --card-bg: #161820;
    --accent-color: #6366f1;
    --accent-hover: #4f46e5;
    --text-main: #ffffff;
    --text-muted: #9ca3af;
    --error-color: #ef4444;
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

.form-container {
    max-width: 500px;
    width: 100%;
    background-color: var(--card-bg);
    padding: 3rem;
    border-radius: var(--radius);
    border: 1px solid rgba(255, 255, 255, 0.03);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
}

/* Bouton Retour */
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

.back-link:hover {
    color: var(--accent-color);
}

.back-link:hover .back-icon {
    transform: translateX(-4px);
}

h2 {
    color: var(--text-main);
    font-size: 2rem;
    font-weight: 800;
    margin-bottom: 2rem;
    text-align: center;
    letter-spacing: -0.5px;
}

/* Bannière d'erreur */
.error-banner {
    background-color: rgba(239, 68, 68, 0.1);
    border: 1px solid var(--error-color);
    color: var(--text-main);
    padding: 0.85rem 1rem;
    border-radius: 8px;
    font-size: 0.9rem;
    margin-bottom: 1.5rem;
    text-align: center;
}

.form-group {
    margin-bottom: 1.5rem;
    display: flex;
    flex-direction: column;
}

label {
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--text-muted);
    margin-bottom: 0.5rem;
}

/* Inputs */
input[type="text"],
input[type="email"],
input[type="password"] {
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

input:focus {
    outline: none;
    background-color: rgba(255, 255, 255, 0.05);
    border-color: var(--accent-color);
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
}

/* Style des Checkboxes Natives */
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

/* Bouton Soumettre */
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

.submit-btn:hover:not(:disabled) {
    background-color: var(--accent-hover);
    box-shadow: 0 6px 20px rgba(99, 102, 241, 0.4);
    transform: translateY(-2px);
}

.submit-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}
</style>