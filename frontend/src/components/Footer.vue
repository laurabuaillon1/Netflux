<script setup>

</script>
<template>
    <footer class="main-footer">
    <div class="footer-container">
      
      <div class="footer-brand">
        <router-link to="/" class="logo">Net<span class="logo-accent">Flux</span></router-link>
        <p class="footer-description">
          Votre plateforme de streaming nouvelle génération. Découvrez les meilleurs films et séries en qualité premium.
        </p>
      </div>

      <div class="footer-links-group">
        <h4 class="footer-title">Navigation</h4>
        <ul class="footer-links">
          <li><router-link to="/" class="footer-item">Accueil</router-link></li>
          <li><router-link to="/movies" class="footer-item">Films</router-link></li>
          <li><router-link to="/favorites" class="footer-item">Favoris</router-link></li>
        </ul>
      </div>

      <div class="footer-links-group">
        <h4 class="footer-title">Légal</h4>
        <ul class="footer-links">
          <li><a href="#" class="footer-item">Conditions d'utilisation</a></li>
          <li><a href="#" class="footer-item">Politique de confidentialité</a></li>
          <li><a href="#" class="footer-item">Centre d'aide</a></li>
        </ul>
      </div>

      <div class="footer-status">
        <h4 class="footer-title">Communauté</h4>
        <div class="social-icons">
          <a href="#" class="social-link" aria-label="Twitter">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"/></svg>
          </a>
          <a href="#" class="social-link" aria-label="Instagram">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
          </a>
        </div>
      </div>

    </div>

    <div class="footer-bottom">
      <p>&copy; 2026 NetFlux. Tous droits réservés.</p>
      <div class="server-status">
        <span class="pulse-dot"></span>
        Tous les systèmes sont opérationnels
      </div>
    </div>
  </footer>
</template>

<style scoped>
    /* Le footer s'adapte au design global */
.main-footer {
  background-color: rgba(22, 24, 32, 0.5); /* --card-bg légèrement transparent */
  backdrop-filter: blur(12px);
  border-top: 1px solid rgba(255, 255, 255, 0.05);
  padding: 4rem 2rem 2rem 2rem;
  margin-top: auto; /* Permet de pousser le footer en bas si flexbox sur le parent */
}

.footer-container {
  max-width: 1400px;
  margin: 0 auto;
  display: grid;
  grid-template-columns: repeat(1, 1fr);
  gap: 2.5rem;
}

/* Identité visuelle */
.footer-brand {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.logo {
  font-size: 1.6rem;
  font-weight: 800;
  letter-spacing: -0.5px;
  text-decoration: none;
  color: #ffffff; /* --text-main */
}

.logo-accent {
  background: linear-gradient(45deg, #6366f1, #a855f7);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}

.footer-description {
  color: #9ca3af; /* --text-muted */
  font-size: 0.9rem;
  line-height: 1.5;
  max-width: 320px;
}

/* Titres des colonnes */
.footer-title {
  color: #ffffff;
  font-size: 1rem;
  font-weight: 600;
  margin-top: 0;
  margin-bottom: 1.2rem;
  letter-spacing: 0.5px;
}

/* Listes de liens */
.footer-links {
  list-style: none;
  padding: 0;
  margin: 0;
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
}

.footer-item {
  color: #9ca3af; /* --text-muted */
  text-decoration: none;
  font-size: 0.9rem;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); /* --transition */
}

.footer-item:hover {
  color: #6366f1; /* --accent-color */
  transform: translateX(4px);
  display: inline-block;
}

/* Icônes Réseaux Sociaux */
.social-icons {
  display: flex;
  gap: 1rem;
}

.social-link {
  color: #9ca3af;
  background-color: rgba(255, 255, 255, 0.05);
  padding: 0.6rem;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  border: 1px solid rgba(255, 255, 255, 0.05);
}

.social-link:hover {
  color: #ffffff;
  background-color: #6366f1; /* --accent-color */
  box-shadow: 0 0 15px rgba(99, 102, 241, 0.4);
  transform: translateY(-3px);
}

/* Partie basse du footer */
.footer-bottom {
  max-width: 1400px;
  margin: 3rem auto 0 auto;
  padding-top: 1.5rem;
  border-top: 1px solid rgba(255, 255, 255, 0.05);
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 1rem;
  font-size: 0.85rem;
  color: #9ca3af;
}

.server-status {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  background-color: rgba(255, 255, 255, 0.03);
  padding: 0.4rem 0.8rem;
  border-radius: 20px;
  border: 1px solid rgba(255, 255, 255, 0.05);
}

/* Point clignotant calqué sur votre navbar */
.pulse-dot {
  width: 6px;
  height: 6px;
  background-color: #10b981;
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

/* --- Responsive Layout --- */
@media (min-width: 640px) {
  .footer-container {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (min-width: 1024px) {
  .footer-container {
    grid-template-columns: 2fr repeat(2, 1fr) 1.5fr;
  }

  .footer-bottom {
    flex-direction: row;
    justify-content: space-between;
  }
}
</style>