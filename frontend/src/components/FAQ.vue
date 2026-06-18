<script setup>
import { useUserStore } from '@/stores/user';
import { computed, ref} from 'vue';
const stores = useUserStore();

// Liste de tes questions / réponses
const faqs = computed(() => [
    {
        id: 1,
        question: "NetFlux, qu'est-ce que c'est ?",
        answer: "NetFlux est une plateforme de démonstration moderne. Elle s'inspire de l'ergonomie de Netflix mais troque le rouge classique pour un violet électrique et un noir bleuté plus futuriste."
    },
    {
        id: 2,
        question: "Combien coûte l'abonnement ?",
        answer: `Regardez Netflux sur votre smartphone, tablette, Smart TV, ordinateur ou appareil de streaming, le tout pour un tarif mensuel fixe. Les offres vont de ${stores.price} € par mois.`
    },
    {
        id: 3,
        question: "Où puis-je regarder NetFlux ?",
        answer: "Partout où votre code est déployé : sur votre navigateur d'ordinateur, votre smartphone, ou même directement sur une TV connectée si vous configurez correctement votre serveur local."
    }
])

// Variable pour suivre quel accordéon est actuellement ouvert (null = tous fermés)
const activeId = ref(null)

// Fonction pour ouvrir/fermer (ferme le précédent si on en ouvre un nouveau)
const toggleAccordion = (id) => {
    activeId.value = activeId.value === id ? null : id
}

</script>
<template >
    <div class="faq-section">
        <h2 class="faq-title">Foire aux questions</h2>

        <div class="accordion-container">
            <div v-for="item in faqs" :key="item.id" class="accordion-item"
                :class="{ 'is-open': activeId === item.id }">
                <button class="accordion-header" @click="toggleAccordion(item.id)"
                    :aria-expanded="activeId === item.id">
                    <span>{{ item.question }}</span>

                    <svg class="icon-toggle" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                </button>

                <div class="accordion-body">
                    <div class="accordion-content">
                        <p>{{ item.answer }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
    /***************************** */
/* Conteneur global de la FAQ */
/**************************** */
/* Zone globale de la FAQ */
.faq-section {
    max-width: 850px;
    margin: 4rem auto;
    padding: 0 1.5rem;
    font-family: 'Inter', system-ui, sans-serif;
}

.faq-title {
    font-size: 2.2rem;
    font-weight: 800;
    color: var(--text-main);
    margin-bottom: 2rem;
    text-align: left;
    letter-spacing: -0.5px;
}

/* Grille d'items empilés style Netflix */
.accordion-container {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    /* Espace entre les blocs */
}

/* Style de chaque bloc */
.accordion-item {
    background-color: var(--card-bg);
    border-radius: var(--radius);
    overflow: hidden;
    /* Important pour masquer le texte fermé */
    border: 1px solid rgba(255, 255, 255, 0.03);
    transition: var(--transition);
}

/* Effet esthétique au survol du bloc complet */
.accordion-item:hover {
    border-color: rgba(99, 102, 241, 0.2);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3), 0 0 15px rgba(99, 102, 241, 0.03);
}

/* Bouton de la question */
.accordion-header {
    width: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem 2rem;
    background: transparent;
    border: none;
    color: var(--text-main);
    font-size: 1.25rem;
    font-weight: 600;
    text-align: left;
    cursor: pointer;
    transition: var(--transition);
}

.accordion-header:hover {
    background-color: rgba(255, 255, 255, 0.02);
}

/* Gestion de l'icône SVG (+) */
.icon-toggle {
    color: var(--text-main);
    transition: var(--transition);
    flex-shrink: 0;
    margin-left: 1rem;
}

/* --- ANIMATIONS ET ÉTATS OUVERTS --- */

/* Changement de couleur au survol général si ouvert */
.accordion-item.is-open {
    border-color: rgba(99, 102, 241, 0.4);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.4), 0 0 20px rgba(99, 102, 241, 0.08);
}

/* Transformation du '+' en 'x' (rotation à 45°) et changement de couleur */
.accordion-item.is-open .icon-toggle {
    transform: rotate(45deg);
    color: var(--accent-color);
}

/* Structure pour l'effet de glissement fluide de la réponse */
.accordion-body {
    display: grid;
    grid-template-rows: 0fr;
    /* Fermé par défaut (hauteur 0) */
    transition: grid-template-rows 0.35s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Technique CSS moderne pour animer une hauteur auto sans JS */
.accordion-item.is-open .accordion-body {
    grid-template-rows: 1fr;
    /* Ouvre le container de manière fluide */
}

/* Conteneur interne du texte */
.accordion-content {
    overflow: hidden;
}

.accordion-content p {
    padding: 2rem;
    /* Marges internes adaptées */
    margin: 0;
    color: var(--text-muted);
    font-size: 1.05rem;
    line-height: 1.6;
}

/* Version mobile responsive */
@media (max-width: 640px) {
    .faq-title {
        font-size: 1.75rem;
    }

    .accordion-header {
        padding: 1.25rem 1.5rem;
        font-size: 1.1rem;
    }

    .accordion-content p {
        padding: 0 1.5rem 1.5rem 1.5rem;
        font-size: 0.95rem;
    }
}
</style>