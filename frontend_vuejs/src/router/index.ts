import { createRouter, createWebHistory } from 'vue-router';
import SurveyView from '../views/SurveyView.vue';
import AnswerView from '../views/AnswerView.vue';
import Administration from '../layout/AdminLayout.vue';
import DashboardView from '@/views/administration/DashboardView.vue';
import QuizView from '@/views/administration/QuizView.vue';
import ResponseView from '@/views/administration/ResponseView.vue';
import LoginView from '@/views/administration/LoginView.vue';
import { isAuthenticated } from '@/utilities/utils.js';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'survey',
      component: SurveyView,
    },
    {
      path: '/answer/:token', //Route dynamique avec pour paramètre token
      name: 'answer',
      component: AnswerView,
      props: true,// Important car on passe le paramètre de l'URL 'token' comme une prop au composant
    },
    {
      path: '/administration',
      name: 'Login',
      component: LoginView
    },
    {
      path: '/admin',
      component: Administration,
      meta: { requiresAdmin: true },
      children: [
        { path: '', redirect: { name: 'Dashboard' } },
        { path: '/administration/dashboard', name: 'Dashboard', component: DashboardView },
        { path: '/administration/quiz', name: 'Quiz', component: QuizView },
        { path: '/administration/response', name: 'Response', component: ResponseView },
      ]
    }
  ],
})

  // Ajout d'une garde de navigation pour vérifier l'authentification de l'admin
  router.beforeEach(async (to, from, next) => {

    const isAuth = await isAuthenticated();

    if (to.meta.requiresAdmin && !isAuth ) {

      console.warn('Utilisateur non authentifié')
      next('/administration')
      return

    }

    next()
  })


export default router
