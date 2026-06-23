<script setup>
</script>

<template>
    <div class="netflux-admin-bg">
        <div class="admin-dashboard">
            <header class="dashboard-header">
                <h1>Console d'Administration</h1>
                <p class="subtitle">Gestion du catalogue de Films et Séries</p>
            </header>

            <div class="dashboard-grid">

                <router-link to="/movies/new" class="card card-add">
                    <div class="card-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                    </div>
                    <div class="card-content">
                        <h3>Ajouter un film/série</h3>
                        <p>Publier un nouveau film ou une nouvelle série dans le catalogue.</p>
                    </div>
                    <div class="card-footer">
                        <span class="action-link">Ouvrir le formulaire →</span>
                    </div>
                </router-link>

                <router-link to="/movies/updated" class="card card-edit">
                    <div class="card-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                            <path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                        </svg>
                    </div>
                    <div class="card-content">
                        <h3>Modifier un film/série</h3>
                        <p>Mettre à jour les informations, les images ou les genres d'une œuvre existante.</p>
                    </div>
                    <div class="card-footer">
                        <span class="action-link">Voir le formulaire →</span>
                    </div>
                </router-link>

                <router-link to="/movies/deleted" class="card card-delete">
                    <div class="card-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <polyline points="3 6 5 6 21 6"></polyline>
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                            </path>
                            <line x1="10" y1="11" x2="10" y2="17"></line>
                            <line x1="14" y1="11" x2="14" y2="17"></line>
                        </svg>
                    </div>
                    <div class="card-content">
                        <h3>Supprimer un film/série</h3>
                        <p>Retirer définitivement un film ou une série de la base de données.</p>
                    </div>
                    <div class="card-footer">
                        <span class="action-link">Gérer les suppressions →</span>
                    </div>
                </router-link>
                
                <router-link to="/users/new" class="card card-add">
                    <div class="card-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                    </div>
                    <div class="card-content">
                        <h3>Ajouter un utilisateur</h3>
                        <p>Créer un nouveau compte utilisateur sur la plateforme.</p>
                    </div>
                    <div class="card-footer">
                        <span class="action-link">Ouvrir le formulaire →</span>
                    </div>
                </router-link>

                <router-link to="/users/updated" class="card card-edit">
                    <div class="card-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                            <path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                        </svg>
                    </div>
                    <div class="card-content">
                        <h3>Modifier le profil d'un utilisateur</h3>
                        <p>Mettre à jour les informations d'un utilisateur existant.</p>
                    </div>
                    <div class="card-footer">
                        <span class="action-link">Voir le formulaire →</span>
                    </div>
                </router-link>

                <router-link to="/movies/deleted" class="card card-delete">
                    <div class="card-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <polyline points="3 6 5 6 21 6"></polyline>
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                            </path>
                            <line x1="10" y1="11" x2="10" y2="17"></line>
                            <line x1="14" y1="11" x2="14" y2="17"></line>
                        </svg>
                    </div>
                    <div class="card-content">
                        <h3>Supprimer un utilisateur</h3>
                        <p>Retirer définitivement un utilisateur de la base de données.</p>
                    </div>
                    <div class="card-footer">
                        <span class="action-link">Gérer les suppressions →</span>
                    </div>
                </router-link>

            </div>
        </div>
    </div>
</template>

<style scoped>
/* Conteneur global pleine page style Cinéma/Sombre */
/* Déclaration locale de vos variables de design */
.netflux-admin-bg {
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
    font-family: 'Inter', system-ui, -apple-system, sans-serif;
    box-sizing: border-box;
}

.admin-dashboard {
    max-width: 1200px;
    margin: 0 auto;
    padding: 4rem 2rem;
}

/* Header */
.dashboard-header {
    text-align: center;
    margin-bottom: 4rem;
}

.dashboard-header h1 {
    font-size: 2.8rem;
    font-weight: 800;
    color: var(--text-main);
    margin-bottom: 0.5rem;
    letter-spacing: -0.5px;
}

.dashboard-header .subtitle {
    color: var(--text-muted);
    font-size: 1.1rem;
}

/* Layout */
.dashboard-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
}

/* Base des cartes */
.card {
    background: var(--card-bg);
    border: 1px solid rgba(255, 255, 255, 0.03);
    border-radius: var(--radius);
    padding: 2.5rem 2rem;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    text-decoration: none;
    color: inherit;
    transition: var(--transition);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
}

/* Hover - Effet Néon Violet Moderne */
.card:hover {
    transform: translateY(-6px);
    border-color: var(--accent-color);
    box-shadow: 0 12px 30px rgba(99, 102, 241, 0.15);
    /* Lueur diffuse violette */
}

/* Icônes */
.card-icon {
    width: 48px;
    height: 48px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1.5rem;
    background-color: rgba(255, 255, 255, 0.03);
    color: var(--text-muted);
    transition: var(--transition);
}

/* L'icône prend la couleur violette au survol de la carte */
.card:hover .card-icon {
    background-color: rgba(99, 102, 241, 0.1);
    color: var(--accent-color);
}

/* Contenu textuel */
.card-content h3 {
    font-size: 1.4rem;
    font-weight: 700;
    margin-bottom: 0.75rem;
    color: var(--text-main);
}

.card-content p {
    color: var(--text-muted);
    font-size: 0.95rem;
    line-height: 1.6;
    margin-bottom: 2rem;
}

.card-footer {
    margin-top: auto;
    font-weight: 600;
    font-size: 0.95rem;
}

.action-link {
    color: var(--text-muted);
    transition: var(--transition);
}

/* Le lien s'anime en violet au survol */
.card:hover .action-link {
    color: var(--accent-color);
    padding-left: 4px;
    /* Petit effet de glissement sympa */
}
</style>