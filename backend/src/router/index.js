import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import Login from '../views/Login.vue'
import RequestPassword from '../views/RequestPassword.vue'
import ResetPassword from '../views/ResetPassword.vue'
import AppLayout from '@/components/AppLayout.vue'
import Dashboard from '@/views/Dashboard.vue'
import Products from '@/views/Products/Products.vue'
import ProductForm from '@/views/Products/ProductForm.vue'
import Users from '@/views/Users/Users.vue'
import Customers from '@/views/Customers/Customers.vue'
import CustomerView from '@/views/Customers/CustomerView.vue'
import Orders from '@/views/Orders/Orders.vue'
import Reports from '@/views/Reports/Reports.vue'
import OrdersView from '@/views/Orders/OrdersView.vue'
import NotFount from '@/views/NotFount.vue'
import store from '@/store'
import OrdersReports from '@/views/Reports/OrdersReports.vue'
import CustomersReports from '@/views/Reports/CustomersReports.vue'
import Categories from '@/views/Categories/Categories.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      redirect: '/app/dashboard',
      component: HomeView,
    },
    {
      path: '/app',
      name: 'app',
      redirect: '/app/dashboard',
      component: AppLayout,
      meta: {
        requiresAuth: true,
      },
      children: [
        {
          path: 'dashboard',
          name: 'app.dashboard',
          component: Dashboard,
        },
        {
          path: 'products',
          name: 'app.products',
          component: Products,
        },
        {
          path: 'categories',
          name: 'app.categories',
          component: Categories,
        },
        {
          path: 'products/create',
          name: 'app.products.create',
          component: ProductForm,
        },
        {
          path: 'products/:id',
          name: 'app.products.edit',
          component: ProductForm,
          props: {
            id: (value) => {
              ;/^\d+$/.test(value)
              // /^\d+$/.test(value.id) ? Number(value.id) : null
            },
          },
        },
        {
          path: 'orders',
          name: 'app.orders',
          component: Orders,
        },
        {
          path: 'orders/:id',
          name: 'app.orders.view',
          component: OrdersView,
        },
        {
          path: 'users',
          name: 'app.users',
          component: Users,
        },
        {
          path: 'customers',
          name: 'app.customers',
          component: Customers,
        },
        {
          path: 'customers/:id',
          name: 'app.customers.view',
          component: CustomerView,
        },
        {
          path: '/report',
          name: 'reports',
          component: Reports,
          meta: {
            requiresAuth: true,
          },
          children: [
            {
              path: 'orders/:date?',
              name: 'reports.orders',
              component: OrdersReports,
            },
            {
              path: 'customers/:date?',
              name: 'reports.customers',
              component: CustomersReports,
            },
          ],
        },
      ],
    },
    {
      path: '/login',
      name: 'login',
      component: Login,
      meta: {
        requiresGuest: true,
      },
    },
    {
      path: '/request-password',
      name: 'requestPassword',
      component: RequestPassword,
    },
    {
      path: '/reset-password:token',
      name: 'resetPassword',
      component: ResetPassword,
    },
    {
      path: '/:pathMatch(.*)',
      name: 'notfount',
      component: NotFount,
    },
  ],
})

// to represents the route object that is being navigated to.
// from represents the route object that is being navigated away from.
// next is a function that must be called to resolve the navigation.
router.beforeEach((to, from, next) => {
  if (to.meta.requiresAuth && !store.state.user.token) {
    next({ name: 'login' })
  } else if (to.meta.requiresGuest && store.state.user.token) {
    next({ name: 'app.dashboard' })
  } else {
    next()
  }
})

export default router
