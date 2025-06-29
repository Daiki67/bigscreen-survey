import { createRouter, createWebHistory } from 'vue-router'
import SurveyView from '../views/SurveyView.vue'
import AnswerView from '../views/AnswerView.vue'
import Administration from '../layout/AdminLayout.vue'
import DashboardView from '@/views/administration/DashboardView.vue'
import QuizView from '@/views/administration/QuizView.vue'
import ResponseView from '@/views/administration/ResponseView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'survey',
      component: SurveyView,
    },
    {
      path: '/answer',
      name: 'answer',
      component: AnswerView
    },
    {
      path: '/administration',
      component: Administration,
      children: [
        { path: '', redirect: { name: 'Dashboard' } },
        { path: '/dashboard', name: 'Dashboard', component: DashboardView },
        { path: '/quiz', name: 'Quiz', component: QuizView },
        { path: '/response', name: 'Response', component: ResponseView },
      ]
    }
  ],
})

export default router
