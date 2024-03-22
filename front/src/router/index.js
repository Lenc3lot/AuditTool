import { createRouter, createWebHashHistory } from 'vue-router'
// import HomeView from '../views/HomeView.vue'

const routes = [
  {
    path: '/',
    name: 'home',
    component: () => import('../views/ReadDatabase.vue')
  },
  {
    path: '/test',
    name: 'test',
    component: () => import('../views/NouvelleView.vue')
  },
  {
    path: '/reader',
    name: 'reader',
    component: () => import('../views/ReadDatabase.vue')
  },
  {
    path: '/recherche',
    name: 'recherche',
    component: () => import('../views/RechercheView.vue')
  },
  {
    path: '/login',
    name: 'login',
    component: () => import('../views/LoginView.vue')
  },
  {
    path: '/clients/:id',
    name: 'clients',
    children: [
      {
        path: '',
        component: () => import('../views/ClientView.vue')
      },
      {
        path: 'services',
        name: 'services',
        children: [{
          path: '',
          component: () => import('../views/ServiceView.vue')
        },
        {
          path: ':idService/users',
          component: () => import('../views/UserView.vue')
        },
        {
          path: '',
          component: () => import('../views/ServiceView.vue')
        },
        {
          path: ':idService/cptgestion',
          component: () => import('../views/CompteGestion.vue')
        },
        {
          path: '',
          component: () => import('../views/ServiceView.vue')
        },
        {
          path: 'audit',
          component: () => import('../views/AuditView.vue')
        }
        ]
      }
    ]
  }
]

const router = createRouter({
  history: createWebHashHistory(),
  routes
})

router.beforeEach((to, from) => {
  console.log(to)
  if (!localStorage.token && to.name !== 'login') {
    return '/login'
  }
  return true
})

export default router
