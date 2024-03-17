import { createRouter, createWebHistory } from 'vue-router';
import Login from '../components/Login.vue';
import NetworkServices from '../components/NetworkServices.vue';
import NetworkService from '../components/NetworkService.vue';
import Register from '../components/Register.vue';

const routes = [
  {
    path: '/',
    redirect: '/services'
  },
  { 
    path: '/register', 
    name: 'Register',
    component: Register 
  },
  { 
    path: '/login', 
    name: 'Login',
    component: Login 
  },
  {
    path:'/services',
    component:NetworkServices,
    name: 'NetworkServices',
    meta: { requiresAuth: true }
  },
  {
    path:'/services/:service_id',
    name: 'NetworkService',
    component:NetworkService,
    props: true,
    meta: { requiresAuth: true }
  },
];

const router = createRouter({
  mode: 'history',
  history: createWebHistory(),
  routes,
});

router.beforeEach((to, from, next) => {
  const isAuthenticated = localStorage.getItem('access_token');
  if (to.matched.some(record => record.meta.requiresAuth) && !isAuthenticated) {
    next('/login');
  } else {
    next();
  }
});

export default router;