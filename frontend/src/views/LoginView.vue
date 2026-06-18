<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { useUserStore } from '@/stores/user.js';


const email = ref('');
const password = ref('');
const erreur = ref(null);
const success = ref(false);
const stores = useUserStore();

// const route = useRoute();
const router = useRouter();

async function envoyer() {
    erreur.value = null;
    success.value = false;

    try {
        await stores.login(email.value, password.value)
        console.log(stores.token)
        success.value = true;
        router.push({ name: 'Home' });
    } catch (e) {
        erreur.value = e.response?.data?.message || 'Erreur lors de la création.';
    }
}



</script>
<template>
    <div class="auth-container">
        <div class="auth-card">

            <div class="auth-header">
                <h2 class="auth-title">Connexion</h2>
                <p class="auth-subtitle">Connectez-vous pour accéder à vos films préférés</p>
            </div>

            <form @submit.prevent="envoyer" class="auth-form">

                <div class="form-group">
                    <label for="email" class="form-label">Adresse e-mail</label>
                    <input v-model="email" type="email" id="email" placeholder="nom@exemple.com" class="form-input" required>
                </div>

                <div class="form-group">
                    <div class="label-row">
                        <label for="password" class="form-label">Mot de passe</label>
                        <a href="#" class="forgot-password">Mot de passe oublié ?</a>
                    </div>
                    <input v-model="password" type="password" id="password" placeholder="••••••••" class="form-input" required>
                </div>

                <button type="submit" class="btn-submit">
                    Se connecter
                </button>
            </form>

            <p class="auth-footer">
                Nouveau sur Netflux ? <router-link to="/register" class="auth-link">Créer un compte</router-link>
            </p>
        </div>
    </div>
</template>

<style scoped>
/* --- Conteneur de la Page --- */
.auth-container {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: calc(100vh - 80px); 
  padding: 2rem;
  background-color: #0d0e12; /* Fond très sombre de l'app */
}

/* --- La Carte Formulaire --- */
.auth-card {
  background-color: #161820; /* Gris foncé pour détacher la carte du fond */
  border: 1px solid rgba(255, 255, 255, 0.08);
  border-radius: 16px;
  padding: 3.5rem 3rem; /* Grands espaces internes */
  width: 100%;
  max-width: 460px;
  box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
}

/* --- En-tête (Espacements) --- */
.auth-header {
  margin-bottom: 2.5rem; /* Donne de l'air avant le début du formulaire */
}

.auth-title {
  font-size: 2rem;
  font-weight: 700;
  margin: 0 0 0.75rem 0;
  color: #ffffff;
  letter-spacing: -0.5px;
}

.text-gradient {
  background: linear-gradient(135deg, #6366f1, #a855f7);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}

.auth-subtitle {
  color: #9ca3af;
  font-size: 0.95rem;
  line-height: 1.5;
  margin: 0;
}

/* --- Formulaire et Groupes (Aération) --- */
.auth-form {
  display: flex;
  flex-direction: column;
  gap: 2rem; /* Espace important entre chaque bloc d'input */
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 0.6rem; /* Espace entre le label et l'input */
}

.label-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.form-label {
  color: #e5e7eb; /* Blanc cassé pour une lecture parfaite */
  font-size: 0.9rem;
  font-weight: 500;
}

.forgot-password {
  color: #6366f1;
  font-size: 0.85rem;
  text-decoration: none;
  transition: color 0.2s ease;
}

.forgot-password:hover {
  color: #818cf8;
  text-decoration: underline;
}

/* --- LES INPUTS (Enfin visibles !) --- */
.form-input {
  width: 100%;
  background-color: #1f222f; /* Fond nettement plus clair que la carte */
  color: #ffffff;
  border: 2px solid rgba(255, 255, 255, 0.1); /* Bordure visible par défaut */
  border-radius: 10px;
  padding: 1rem 1.2rem; /* Plus grand pour cliquer facilement */
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
  border-color: #6366f1; /* Devient violet électrique */
  background-color: #242837; /* S'éclaircit un poil */
  box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.15); /* Halo lumineux subtil */
}

/* --- Bouton Connexion --- */
.btn-submit {
  background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
  color: #ffffff;
  border: none;
  border-radius: 10px;
  padding: 1rem;
  font-size: 1rem;
  font-weight: 600;
  cursor: pointer;
  margin-top: 0.5rem; /* Espace bonus avant le bouton */
  transition: all 0.3s ease;
  box-shadow: 0 4px 12px rgba(99, 102, 241, 0.2);
}

.btn-submit:hover {
  transform: translateY(-2px);
  box-shadow: 0 0 20px rgba(99, 102, 241, 0.4);
}

.btn-submit:active {
  transform: translateY(0);
}

/* --- Pied de page --- */
.auth-footer {
  text-align: center;
  margin-top: 2.5rem;
  font-size: 0.9rem;
  color: #9ca3af;
}

.auth-link {
  color: #6366f1;
  text-decoration: none;
  font-weight: 600;
}

.auth-link:hover {
  text-decoration: underline;
}
</style>