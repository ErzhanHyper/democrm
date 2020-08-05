<template>
   <div>
      <v-container class="fill-height" fluid>
         <v-row align="center" justify="center">

            <v-col cols="12" sm="8" md="4">

               <v-card class="elevation-12" v-if="authenticated == false">

                  <v-toolbar color="primary" dark flat>
                     <v-toolbar-title>Регистрация</v-toolbar-title>
                     <v-spacer></v-spacer>
                  </v-toolbar>

                  <v-card-text>
                     <v-form >
                        <v-text-field
                        label="Логин"
                        name="name"
                        v-model="name"
                        prepend-icon="mdi-account"
                        type="text"
                        ></v-text-field>

                        <v-text-field
                        label="Email"
                        name="email"
                        v-model="email"
                        prepend-icon="mdi-account"
                        type="text"
                        ></v-text-field>

                        <v-alert dense text type="success" v-if="formSend">{{message}}</v-alert>

                     </v-form>
                  </v-card-text>

                  <v-card-actions class='pl-5 pr-5 pb-4'>
                     <v-btn color="primary" @click="register" class="mr-2">Зарегистрироваться</v-btn>
                     <v-spacer></v-spacer>
                     <router-link to="/login" class="p-2">Авторизация</router-link>
                  </v-card-actions>

               </v-card >

               <v-card class="elevation-12 p-2" v-else>
                  <p>Вы авторизованы</p>
                  <p>{{user.user.name}}</p>
                  <p><router-link to="/profile">Перейти в личный кабинет</router-link></p>
               </v-card>

            </v-col>

         </v-row>
      </v-container>
   </div>
</template>


<script>
export default {

   data () {
      return {
         email: '',
         name: '',
         authenticated: auth.check(),
         user: auth.user,
         message: '',
         formSend: false
      }
   },

   methods: {
      register () {
         let data = {
            email: this.email,
            name: this.name,
         };
         let auth_data = {
            email: this.email,
         };
         axios.post('/register', data).then(({data}) => {
            // auth.login(auth_data);
            this.message = data.message
            this.formSend = true
         })

      }
   },

   mounted(){
      Event.$on('userLoggedOut', () => {
         this.authenticated = false;
         this.user = auth.user;
      });

   }
}

</script>
