<script setup>

</script>
<template>
    <section class="reasons-section">
        <h2 class="section-title">Encore plus de raisons de vous abonner</h2>

        <div class="reasons-grid">
            <div class="reason-card">
                <h3 class="card-title">Regardez NetFlux sur votre TV</h3>
                <p class="card-text">
                    Regardez NetFlux sur votre Smart TV, PlayStation, Xbox, Chromecast, Apple TV, lecteur Blu-ray et
                    bien plus.
                </p>
                <div class="card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.5">
                        <rect x="2" y="3" width="20" height="13" rx="2" />
                        <path d="M12 16v4M8 20h8" />
                    </svg>
                </div>
            </div>

            <div class="reason-card">
                <h3 class="card-title">Téléchargez vos séries pour les regarder hors connexion</h3>
                <p class="card-text">
                    Enregistrez vos programmes préférés et ayez toujours quelque chose à regarder.
                </p>
                <div class="card-icon icon-circle">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M12 5v14M19 12l-7 7-7-7" />
                    </svg>
                </div>
            </div>

            <div class="reason-card">
                <h3 class="card-title">Où que vous soyez</h3>
                <p class="card-text">
                    Regardez des films et séries en accès illimité sur votre TV, smartphone, tablette et ordinateur.
                </p>
                <div class="card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.5">
                        <circle cx="12" cy="12" r="10" />
                        <polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76" />
                    </svg>
                </div>
            </div>

            <div class="reason-card">
                <h3 class="card-title">Créez des profils pour les enfants</h3>
                <p class="card-text">
                    Les enfants découvrent de nouvelles aventures et retrouvent leurs personnages préférés dans un
                    espace bien à eux, déjà inclus dans votre abonnement.
                </p>
                <div class="card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.5">
                        <path d="M18 9h.01M6 9h.01M10 14h4a3 3 0 0 1-4 0z" />
                        <rect x="2" y="2" width="20" height="20" rx="5" />
                    </svg>
                </div>
            </div>
        </div>
        </section>
</template>

<style scoped>

/* Conteneur de la section */
.reasons-section {
    max-width: 1400px;
    margin: 4rem auto;
    padding: 0 2rem;
    font-family: 'Inter', system-ui, sans-serif;
}

/* Titre principal identique à Netflix */
.section-title {
    font-size: 1.6rem;
    font-weight: 700;
    color: var(--text-main, #ffffff);
    margin-bottom: 1.5rem;
    letter-spacing: -0.5px;
}

/* Grille Responsive (1 colonne sur mobile, 2 sur tablette, 4 sur PC) */
.reasons-grid {
    display: grid;
    grid-template-columns: repeat(1, 1fr);
    gap: 1rem;
}

/* Style des Cartes (Design Dégradé Sombre & Néon) */
.reason-card {
    background: linear-gradient(135deg, #131520 0%, #1a162b 100%);
    /* Dégradé subtil noir/bleu/violet */
    border: 1px solid rgba(255, 255, 255, 0.03);
    border-radius: 16px;
    padding: 2rem;
    min-height: 280px;
    display: flex;
    flex-direction: column;
    position: relative;
    /* Nécessaire pour aligner l'icône en bas à droite */
    overflow: hidden;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Effet de survol premium */
.reason-card:hover {
    transform: translateY(-4px);
    border-color: rgba(99, 102, 241, 0.2);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.5), 0 0 20px rgba(99, 102, 241, 0.05);
}

/* Titres internes aux cartes */
.card-title {
    font-size: 1.4rem;
    font-weight: 700;
    color: var(--text-main, #ffffff);
    margin: 0 0 1rem 0;
    line-height: 1.3;
}

/* Textes de description secondaires */
.card-text {
    font-size: 0.95rem;
    color: var(--text-muted, #9ca3af);
    line-height: 1.5;
    margin: 0;
    max-width: 90%;
}

/* Conteneur d'icône positionné en bas à droite */
.card-icon {
    position: absolute;
    bottom: 1.5rem;
    right: 1.5rem;
    width: 48px;
    height: 48px;
    color: var(--accent-color, #6366f1);
    /* Couleur violette de ton thème */
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.reason-card:hover .card-icon {
    transform: scale(1.1);
    color: #a855f7;
    /* Devient rose/violet plus vif au survol */
}

/* Style spécial pour l'icône du bouton télécharger rond de la carte 2 */
.card-icon.icon-circle {
    background: linear-gradient(135deg, #6366f1, #a855f7);
    color: #ffffff;
    border-radius: 50%;
    padding: 10px;
    box-shadow: 0 0 15px rgba(99, 102, 241, 0.4);
}

.reason-card:hover .card-icon.icon-circle {
    box-shadow: 0 0 20px rgba(168, 85, 247, 0.6);
}

/* --- Media Queries pour le Responsive --- */
@media (min-width: 640px) {
    .reasons-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (min-width: 1024px) {
    .reasons-grid {
        grid-template-columns: repeat(4, 1fr);
        /* 4 Colonnes alignées comme sur la photo */
    }

    .section-title {
        font-size: 1.8rem;
    }
}
</style>