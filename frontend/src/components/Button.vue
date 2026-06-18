<script setup>
import { useUserStore } from '@/stores/user';

const stores = useUserStore();
</script>

<template >
    <div>

        <router-link v-if="!stores.token" to="/login" class="btn-login">
        <span>S'identifier</span></router-link>
        <button v-else @click="stores.logout()" class="btn-login">Déconnexion<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="btn-icon">
          <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
          <polyline points="10 17 15 12 10 7"></polyline>
          <line x1="15" y1="12" x2="3" y2="12"></line>
        </svg></button>
        

    </div>
</template>

<style scoped>
    /***************************** */
/*******Bouton connexion****** */
/***************************** */

.btn-login {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 0.6rem;
  
  /* Palette Moderne (Dégradé Violet/Indigo) */
  background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
  color: #ffffff !important; /* Le !important évite que le style des liens classiques prenne le dessus */
  text-decoration: none; /* Enlève le soulignage automatique des liens */
  
  /* Design et proportions */
  border-radius: 8px;
  padding: 0.6rem 1.4rem;
  font-size: 0.95rem;
  font-weight: 600;
  letter-spacing: 0.3px;
  
  /* Transitions fluides */
  cursor: pointer;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  box-shadow: 0 4px 12px rgba(99, 102, 241, 0.2);
}

/* --- Effet de survol (Glow néon) --- */
.btn-login:hover {
  box-shadow: 0 0 20px rgba(99, 102, 241, 0.5), 
              0 4px 6px rgba(0, 0, 0, 0.2);
  background: linear-gradient(135deg, #6c6ff3 0%, #564de9 100%);
  transform: translateY(-2px);
}

/* Animation de la petite flèche */
.btn-icon {
  transition: transform 0.3s ease;
}

.btn-login:hover .btn-icon {
  transform: translateX(4px);
}

/* --- Clic --- */
.btn-login:active {
  transform: translateY(0);
  box-shadow: 0 2px 6px rgba(99, 102, 241, 0.3);
}
</style>