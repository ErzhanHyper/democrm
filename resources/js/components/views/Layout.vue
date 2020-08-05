<template>
   <div>

      <v-app>
         <notifications classes="my-notification"/>

         <v-navigation-drawer app v-if="authenticated">
            <v-list dense nav class="py-0" >
               <router-link to="/profile">
                  <v-list-item two-line>
                     <v-list-item-avatar>
                        <img :src="'/storage/user_photo/'+user.avatar" width="60"v-if="user.avatar != null">
                     </v-list-item-avatar>

                     <v-list-item-content>
                        <v-list-item-title>{{user.name}}</v-list-item-title>
                        <v-list-item-subtitle>{{group}}</v-list-item-subtitle>
                     </v-list-item-content>
                  </v-list-item>
               </router-link>

               <v-divider></v-divider>

               <router-link to="/projects" v-if="active">
                  <v-list-item link>
                     <v-list-item-icon>
                        <v-icon>mdi-view-dashboard</v-icon>
                     </v-list-item-icon>

                     <v-list-item-content>
                        <v-list-item-title>Проекты</v-list-item-title>
                     </v-list-item-content>
                  </v-list-item>
               </router-link>

               <router-link to="/tasks" v-if="active">
                  <v-list-item link>
                     <v-list-item-icon>
                        <v-icon>mdi-view-dashboard</v-icon>
                     </v-list-item-icon>

                     <v-list-item-content>
                        <v-list-item-title>Задачи</v-list-item-title>
                     </v-list-item-content>
                  </v-list-item>
               </router-link>

               <router-link to="/clients" v-if="active">
                  <v-list-item link>
                     <v-list-item-icon>
                        <v-icon>mdi-account-box</v-icon>
                     </v-list-item-icon>

                     <v-list-item-content>
                        <v-list-item-title><a>Клиенты</a></v-list-item-title>
                     </v-list-item-content>
                  </v-list-item>
               </router-link>


               <router-link to="/users" v-if="active && group == 'Администратор'">
                  <v-list-item link>
                     <v-list-item-icon>
                        <v-icon>mdi-account-box</v-icon>
                     </v-list-item-icon>

                     <v-list-item-content>
                        <v-list-item-title><a>Пользователи</a></v-list-item-title>
                     </v-list-item-content>
                  </v-list-item>
               </router-link>

               <router-link to="/profile" >
                  <v-list-item link>
                     <v-list-item-icon>
                        <v-icon>mdi-account-box</v-icon>
                     </v-list-item-icon>

                     <v-list-item-content>
                        <v-list-item-title><a>Профиль</a></v-list-item-title>
                     </v-list-item-content>
                  </v-list-item>
               </router-link>


               <hr>

               <router-link to="/statuses" v-if="active && group == 'Администратор'">
                  <v-list-item link>
                     <v-list-item-icon>
                        <v-icon>mdi-account-box</v-icon>
                     </v-list-item-icon>

                     <v-list-item-content>
                        <v-list-item-title><a>Статусы проекта</a></v-list-item-title>
                     </v-list-item-content>
                  </v-list-item>
               </router-link>

               <router-link :to="{ name: 'groups'}" v-if="active && group == 'Администратор'">
                  <v-list-item link>
                     <v-list-item-icon>
                        <v-icon>mdi-account-box</v-icon>
                     </v-list-item-icon>

                     <v-list-item-content>
                        <v-list-item-title><a>Группы пользователей</a></v-list-item-title>
                     </v-list-item-content>
                  </v-list-item>
               </router-link>

            </v-list>
         </v-navigation-drawer>

         <v-app-bar app v-if="authenticated">
            <v-col class="text-left">
               LOGO
            </v-col>

            <v-col class="text-right">
               <a @click="logout">Выйти</a>
            </v-col>
         </v-app-bar>


         <v-main>
            <v-container fluid>
               <router-view></router-view>
            </v-container>
         </v-main>

         <v-footer app v-if="authenticated">
            Copyright 2020
         </v-footer>

      </v-app>
   </div>
</template>

<script>
export default {

   data() {
      return {
         authenticated: false,
         user: auth.user,
         active: auth.active(),
         group: null,
         edit:null,
         read:null,
         del:null,
      }
   },

   methods:{
      logout(){
         auth.logout()
         this.authenticated = false
         if(this.$route.path != '/'){
            this.$router.push('/');
         }

      }
   },

   mounted(){
      this.authenticated = auth.check()
      if(this.authenticated){
         axios.get('/get-user-group').then((response) => {
            this.group = auth.user.grpuser.group.name
            this.edit = auth.user.grpuser.group.edit
            this.read = auth.user.grpuser.group.read
            this.del = auth.user.grpuser.group.delete
         })
      }

      Event.$on('userUpdated', () => {
         this.active = auth.active()
      });

      Event.$on('userLoggedIn', () => {
         this.authenticated = true;
         this.user = auth.user;
         this.active = auth.active()
         this.group = auth.user.grpuser.group.name
         this.edit = auth.user.grpuser.group.edit
         this.read = auth.user.grpuser.group.read
         this.del = auth.user.grpuser.group.delete
      });

   }
}
</script>


<style lang="scss">
main{
   background-color: rgba(86,62,210,0.1);
}

.my-notification{
   padding: 10px;
   margin: 10px;
   border-radius: 4px;
   font-size: 14px;

   color: #ffffff;
   background: #44A4FC;
   border-left: 5px solid #187FE7;

   &.warn {
      background: #ffb648;
      border-left-color: #f48a06;
   }

   &.error {
      background: #E54D42;
      border-left-color: #B82E24;
   }

   &.success {
      background: #68CD86;
      border-left-color: #42A85F;
   }
}

</style>
