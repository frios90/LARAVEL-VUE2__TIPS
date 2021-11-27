import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

export default new Router({
    mode: 'history',
    base: process.env.BASE_URL,
    routes: [      
       /**Rutas para home */
      {
        path: '/home',
        name: 'home',
        component: require('./components/home/General')        
      },

      /**Rutas para mantenedor de STAFF */
      {
        path: '/staff',
        name: 'staff',
        component: require('./components/staff/Index')        
      },
      {
        path: '/staff/create',
        name: 'staff.create',
        component: require('./components/staff/Create')        
      },
      {
        path: '/staff/edit/:id',
        name: 'staff.edit',
        component: require('./components/staff/Edit')        
      },
       /**Rutas para mantenedor de Licencias */
       {
          path: '/license',
          name: 'license',
          component: require('./components/licenses/Index')        
        },
        {
          path: '/license/create',
          name: 'license.create',
          component: require('./components/licenses/Create')        
        },
        {
          path: '/license/edit/:id',
          name: 'license.edit',
          component: require('./components/licenses/Edit')        
        },
         /**Rutas para mantenedor de EMPRESAS */
         {
          path: '/company',
          name: 'company',
          component: require('./components/company/Index')        
        },
        {
          path: '/company/create',
          name: 'company.create',
          component: require('./components/company/Create')        
        },
        {
          path: '/company/edit/:id',
          name: 'company.edit',
          component: require('./components/company/Edit')        
        }, 
        {
          path: '/company/:id/users',
          name: 'company.users',
          component: require('./components/company/Users')        
        },
        {
          path: '/company/:company_id/users/edit/:id',
          name: 'company.users.edit',
          component: require('./components/company/UserEdit')        
        }, 
        {
          path: '/company/:company_id/users/create',
          name: 'company.users.create',
          component: require('./components/company/UserCreate')        
        }, 
        /**Rutas para gestión de propinas */
        {
          path: '/tips',
          name: 'tips',
          component: require('./components/tips/Index')        
        },
        {
          path: '/tip/see/:id',
          name: 'tip.see',
          component: require('./components/tips/See')        
        },
        /**Rutas para user me */
        {
          path: '/me',
          name: 'me',
          component: require('./components/User/Me')        
        }

    
    
     
    ]
   
  })