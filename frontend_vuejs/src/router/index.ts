// -----------------------------------------------------------------------------
// Fichier : index.ts
// Type : Configuration du routeur Vue 3 (vue-router)
// Rôle : Définit les routes de l’application, la structure de navigation et les gardes d’accès.
// Librairies tierces utilisées :
//   - vue-router : gestion de la navigation SPA
//   - @/utilities/utils.js : utilitaires d’authentification (isAuthenticated)
// -----------------------------------------------------------------------------

// Importation des fonctions principales de vue-router
import { createRouter, createWebHistory } from 'vue-router'; // createRouter : (config) => Router, createWebHistory : (base?: string) => History
// Importation des vues et layouts (composants Vue)
import SurveyView from '../views/SurveyView.vue'; // Composant Vue - Vue principale du sondage
import AnswerView from '../views/AnswerView.vue'; // Composant Vue - Vue de réponse au sondage
import Administration from '../layout/AdminLayout.vue'; // Composant Vue - Layout d’administration
import DashboardView from '@/views/administration/DashboardView.vue'; // Composant Vue - Tableau de bord admin
import QuizView from '@/views/administration/QuizView.vue'; // Composant Vue - Gestion des quiz
import ResponseView from '@/views/administration/ResponseView.vue'; // Composant Vue - Gestion des réponses
import LoginView from '@/views/administration/LoginView.vue'; // Composant Vue - Connexion admin
// Importation de la fonction utilitaire d’authentification
import { isAuthenticated } from '@/utilities/utils.js'; // Fonction : () => Promise<boolean>

// Définition du routeur principal
const router = createRouter({
  // Utilisation de l’historique HTML5 (sans hash)
  history: createWebHistory(import.meta.env.BASE_URL),
  // Définition des routes principales
  routes: [
    {
      path: '/',
      name: 'survey',
      component: SurveyView, // Affiche la vue du sondage principal
    },
    {
      path: '/answer/:token', // Route dynamique avec paramètre 'token'
      name: 'answer',
      component: AnswerView, // Affiche la vue de réponse
      props: true, // Passe le paramètre 'token' comme prop au composant
    },
    {
      path: '/administration',
      name: 'Login',
      component: LoginView // Page de connexion admin
    },
    {
      path: '/admin',
      component: Administration, // Layout d’administration
      meta: { requiresAdmin: true }, // Nécessite l’authentification admin
      children: [
        { path: '', redirect: { name: 'Dashboard' } }, // Redirection par défaut
        { path: '/administration/dashboard', name: 'Dashboard', component: DashboardView },
        { path: '/administration/quiz', name: 'Quiz', component: QuizView },
        { path: '/administration/response', name: 'Response', component: ResponseView },
      ]
    }
  ],
});

// -----------------------------------------------------------------------------
// Garde de navigation globale
// -----------------------------------------------------------------------------
// Vérifie l’authentification de l’admin avant d’accéder aux routes protégées
router.beforeEach(async (to, from, next) => {
  // isAuthenticated : Promise<boolean> - Vérifie si l’utilisateur est authentifié
  const isAuth = await isAuthenticated();
  // Si la route nécessite l’admin et que l’utilisateur n’est pas authentifié
  if (to.meta.requiresAdmin && !isAuth ) {
    console.warn('Utilisateur non authentifié');
    next('/administration'); // Redirige vers la page de connexion
    return;
  }
  next(); // Autorise la navigation
});

// -----------------------------------------------------------------------------
// Export du routeur configuré
// -----------------------------------------------------------------------------
export default router;
