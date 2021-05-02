import Vue from 'vue'
import Router from 'vue-router'

// Landing Page Routes
const Index = () => import('@/views/LandingPages/Index.vue');


// Containers
const TheContainer = () => import('@/containers/TheContainer')


const Dashboard = () => import('@/views/Dashboard')

const CompanyDashboard = () => import('@/views/CompanyDashboard');

const InvestigationCode = () => import('@/views/InvestigationCode/investigation_code');


// Company Branch
const CreateBranch = () => import('@/views/branch/create');
const AllBranch = () => import('@/views/branch/index');
const BranchEdit = () => import('@/views/branch/edit');

// Designation
const CreateDesignation = () => import('@/views/designation/create');
const AllDesignation = () => import('@/views/designation/index');
const DesignationEdit = () => import('@/views/designation/edit');

// Employee
const AddNewEmployee = () => import('@/views/employee/create');
const AllEmployee = () => import('@/views/employee/index');
const EmployeeEdit = () => import('@/views/employee/edit');

// Check In_out
const CheckIn = () => import('@/views/check_in_out/check_in');
const CheckOut = () => import('@/views/check_in_out/check_out');


const Login = () => import('@/views/pages/Login')
const Register = () => import('@/views/pages/Register')
const Page404 = () => import('@/views/pages/Page404')
const Page500 = () => import('@/views/pages/Page500')


// Users
const Users = () => import('@/views/users/Users')
const User = () => import('@/views/users/User')
const EditUser = () => import('@/views/users/EditUser')

const Menus       = () => import('@/views/menu/MenuIndex')
const CreateMenu  = () => import('@/views/menu/CreateMenu')
const EditMenu    = () => import('@/views/menu/EditMenu')
const DeleteMenu  = () => import('@/views/menu/DeleteMenu')

const MenuElements = () => import('@/views/menuElements/ElementsIndex')
const CreateMenuElement = () => import('@/views/menuElements/CreateMenuElement')
const EditMenuElement = () => import('@/views/menuElements/EditMenuElement')
const ShowMenuElement = () => import('@/views/menuElements/ShowMenuElement')
const DeleteMenuElement = () => import('@/views/menuElements/DeleteMenuElement')

const Media = () => import('@/views/media/Media')

// Index Page
// const Index = () => import('@views/Index/Index');
Vue.use(Router)

let router = new Router({
  mode: 'hash', // https://router.vuejs.org/api/#mode
  linkActiveClass: 'active',
  scrollBehavior: () => ({ y: 0 }),
  routes: configRoutes()
})


router.beforeEach((to, from, next) => {
  let roles = localStorage.getItem("roles");
  if(roles != null){
    roles = roles.split(',')
  }
  if(to.matched.some(record => record.meta.requiresAdmin)) {
    if(roles != null && roles.indexOf('admin') >= 0 ){
      next()
    }else{
      next({
        path: '/login',
        params: { nextUrl: to.fullPath },
      })
    }
  }else if(to.matched.some(record => record.meta.requiresUser)) {
    if(roles != null && roles.indexOf('user') >= 0 ){
      next()
    }else{
      next({
        path: '/login',
        params: { nextUrl: to.fullPath }
      })
    }
  }else{
    next()
  }
})

export default router

function configRoutes () {
  return [
    {
      path:'/',
      name:'Index',
      component:Index,
      meta:{
        requiresUser:false
      }
    },
    {
      path: '/',
      redirect: '/dashboard',
      name: 'Home',
      component: TheContainer,
      children: [
        {
          path: 'media',
          name: 'Media',
          component: Media,
          meta:{
            requiresAdmin: true
          }
        },
        {
          path: 'dashboard',
          name: 'Dashboard',
          component: Dashboard
        },
        {
          path: 'investigation_code',
          name: 'InvestigationCode',
          component: InvestigationCode,
          meta:{
            requiresAdmin: true
          }
        },

        // Company Branch
        {
          path: 'create_branch',
          name: 'CreateBranch',
          component: CreateBranch,
          meta:{
            auth:true
          }
        },
        {
          path: 'branch_index',
          name: 'AllBranch',
          component: AllBranch,
          meta:{
            auth:true
          }
        },
        {
          path: 'branch_edit',
          name: 'branch_edit',
          component: BranchEdit,
          meta:{
            auth:true
          }
        },
        // Company Branch End

        // Designation Start
        {
          path: 'create_designation',
          name: 'CreateDesignation',
          component: CreateDesignation,
          meta:{
            auth:true
          }
        },
        {
          path: 'designation_index',
          name: 'AllDesignation',
          component: AllDesignation,
          meta:{
            auth:true
          }
        },
        {
          path: 'designation_edit',
          name: 'designation_edit',
          component: DesignationEdit,
          meta:{
            auth:true
          }
        },
        // Designation End


        // Employee Start
        {
          path: 'employee_Add',
          name: 'AddNewEmployee',
          component: AddNewEmployee,
          meta:{
            auth:true
          }
        },
        {
          path: 'employee_index',
          name: 'AllEmployee',
          component: AllEmployee,
          meta:{
            auth:true
          }
        },
        {
          path: 'employee_edit',
          name: 'employee_edit',
          component: EmployeeEdit,
          meta:{
            auth:true
          }
        },

        // Employee End

        // Check In Out Start
        {
          path: 'check_in',
          name: 'CheckIn',
          component: CheckIn,
          meta:{
            auth:true
          }
        },
        {
          path: 'check_out',
          name: 'CheckOut',
          component: CheckOut,
          meta:{
            auth:true
          }
        },
        // Check In Out End
        
        {
          path: 'menu',
          meta: { label: 'Menu'},
          component: {
            render (c) { return c('router-view') }
          },
          children: [
            {
              path: '',
              component: Menus,
              meta:{
                requiresAdmin: true
              }
            },
            {
              path: 'create',
              meta: { label: 'Create Menu' },
              name: 'CreateMenu',
              component: CreateMenu,
              meta:{
                requiresAdmin: true
              }
            },
            {
              path: ':id/edit',
              meta: { label: 'Edit Menu' },
              name: 'EditMenu',
              component: EditMenu,
              meta:{
                requiresAdmin: true
              }
            },
            {
              path: ':id/delete',
              meta: { label: 'Delete Menu' },
              name: 'DeleteMenu',
              component: DeleteMenu,
              meta:{
                requiresAdmin: true
              }
            },
          ]
        },
        {
          path: 'menuelement',
          meta: { label: 'MenuElement'},
          component: {
            render (c) { return c('router-view') }
          },
          children: [
            {
              path: ':menu/menuelement',
              component: MenuElements,
              meta:{
                requiresAdmin: true
              }
            },
            {
              path: ':menu/menuelement/create',
              meta: { label: 'Create Menu Element' },
              name: 'Create Menu Element',
              component: CreateMenuElement,
              meta:{
                requiresAdmin: true
              }
            },
            {
              path: ':menu/menuelement/:id',
              meta: { label: 'Menu Element Details'},
              name: 'Menu Element',
              component: ShowMenuElement,
              meta:{
                requiresAdmin: true
              }
            },
            {
              path: ':menu/menuelement/:id/edit',
              meta: { label: 'Edit Menu Element' },
              name: 'Edit Menu Element',
              component: EditMenuElement,
              meta:{
                requiresAdmin: true
              }
            },
            {
              path: ':menu/menuelement/:id/delete',
              meta: { label: 'Delete Menu Element' },
              name: 'Delete Menu Element',
              component: DeleteMenuElement,
              meta:{
                requiresAdmin: true
              }
            },
          ]
        },
        {
          path: 'users',
          meta: { label: 'Users'},
          component: {
            render (c) { return c('router-view') }
          },
          children: [
            {
              path: '',
              component: Users,
              meta:{
                requiresAdmin: true
              }
            },
            {
              path: ':id',
              meta: { label: 'User Details'},
              name: 'User',
              component: User,
              meta:{
                requiresAdmin: true
              }
            },
            {
              path: ':id/edit',
              meta: { label: 'Edit User' },
              name: 'Edit User',
              component: EditUser,
              meta:{
                requiresAdmin: true
              }
            },
          ]
        },
      ]
    },



    
    {
      path: '/pages',
      redirect: '/pages/404',
      name: 'Pages',
      component: {
        render (c) { return c('router-view') }
      },
      children: [
        {
          path: '404',
          name: 'Page404',
          component: Page404
        },
        {
          path: '500',
          name: 'Page500',
          component: Page500
        },
      ]
    },
    {
      path: '/',
      redirect: '/login',
      name: 'Auth',
      component: {
        render (c) { return c('router-view') }
      },
      children: [
        {
          path: 'login',
          name: 'Login',
          component: Login
        },
        {
          path: 'register',
          name: 'Register',
          component: Register
        },
      ]
    },
    {
      path: '*',
      name: '404',
      component: Page404
    }
  ]
}
