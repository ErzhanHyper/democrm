import VueRouter from 'vue-router';

let routes = [
   {
      path: '/',
      name: 'main',
      component: require('./components/auth/Login.vue').default,
      meta: { middlewareAuth: true }
   },

   {
      path: '/projects',
      name: 'projects',
      component: require('./components/views/projects/ProjectList.vue').default,
      meta: {
         middlewareAuth: true,
         uactive:true
      }
   },
   {
      path: '/projects/create',
      component: require('./components/views/projects/ProjectCreate.vue').default,
      meta: {
         middlewareAuth: true,
         uactive:true
      }
   },
   {
      path: '/projects/show/:id',
      name: 'project_show',
      component: require('./components/views/projects/ProjectShow.vue').default,
      meta: {
         middlewareAuth: true,
         uactive:true
      },
      props:true
   },

   {
      path: '/profile',
      name: 'profile',
      component: require('./components/views/profile/ProfileMain.vue').default,
      meta: {
         middlewareAuth: true,
      },
   },

   {
      path: '/tasks',
      name: 'tasks',
      component: require('./components/views/tasks/TaskList.vue').default,
      meta: {
         middlewareAuth: true,
         uactive:true
      },
   },

   {
      path: '/tasks/create',
      component: require('./components/views/tasks/TaskCreate.vue').default,
      meta: {
         middlewareAuth: true,
         uactive:true
      },
   },

   {
      path: '/tasks/show/:id',
      name: 'task_show',
      component: require('./components/views/tasks/TaskShow.vue').default,
      meta: {
         middlewareAuth: true,
         uactive:true
      },
      props:true
   },

   {
      path: '/users',
      component: require('./components/views/users/UserList.vue').default,
      meta: {
         middlewareAuth: true,
         uactive:true,
         group:true,
      },
   },

   {
      path: '/users/show/:id',
      name: 'user_show',
      component: require('./components/views/users/UserShow.vue').default,
      meta: {
         middlewareAuth: true,
         uactive:true,
         group:true,
      },
      props:true
   },


   {
      path: '/groups',
      name: 'groups',
      component: require('./components/views/groups/GroupList.vue').default,
      meta: {
         middlewareAuth: true,
         uactive:true,
         group: true
      },

   },
   {
      path: "/groups/create",
      component: require('./components/views/groups/GroupCreate.vue').default,
   },


   {
      path: '/statuses',
      name: 'statuses',
      component: require('./components/views/statuses/StatusList.vue').default,
      meta: {
         middlewareAuth: true,
         uactive:true,
         group: true
      },

   },
   {
      path: "/statuses/create",
      component: require('./components/views/statuses/StatusCreate.vue').default,
   },
   {
      path: '/statuses/show/:id',
      name: 'status_show',
      component: require('./components/views/statuses/StatusShow.vue').default,
      meta: {
         middlewareAuth: true,
         uactive:true,
         group: true
      },
      props:true
   },

   {
      path: '/clients',
      name: 'clients',
      component: require('./components/views/clients/ClientList.vue').default,
      meta: {
         middlewareAuth: true,
         uactive:true
      },
   },

   {
      path: '/clients/show/:id',
      name: 'client_show',
      component: require('./components/views/clients/ClientShow.vue').default,
      meta: {
         middlewareAuth: true,
         uactive:true
      },
      props:true
   },

   {
      path: '/clients/create',
      component: require('./components/views/clients/ClientCreate.vue').default,
      meta: {
         middlewareAuth: true,
         uactive:true
      },
   },

   {
      path: '/login',
      name:'login',
      component: require('./components/auth/Login.vue').default,
   },

   {
      path: '/reset_password',
      component: require('./components/auth/ResetPassword.vue').default,
   },

   {
      path: '/change_password',
      component: require('./components/auth/ChangePassword.vue').default,
      meta: {
         middlewareAuth: true,
         uactive:true
      },

   },

   {
      path: '/register',
      name:'register',
      component: require('./components/auth/Register.vue').default,
   },


];

const router = new VueRouter({
   routes,
});


router.beforeEach((to, from, next) => {



   if (to.matched.some(route => route.meta.middlewareAuth) && (!auth.check())) {
      next({name: 'login'});
      return
   }

   if (to.matched.some(route => route.meta.middlewareAuth) && (auth.check())) {

      if (to.matched.some(route => route.meta.group) && (auth.active()) && (auth.user.grpuser.group.name != 'Администратор')) {
         next({name: 'profile'});
         return
      }
      if (to.matched.some(route => route.meta.uactive) && (!auth.active())) {
         next({name: 'profile'});
         return
      }
   }



   if (to.path === '/login' && auth.check()) {
      next({name: '/'});
      return
   }

   next()

})

export default router;
