<template>
   <div>
      <v-container class="fill-height" fluid>
         <v-row align="center" justify="center">

            <v-col cols="12" sm="8" md="4">

               <v-card class="elevation-12" v-if="authenticated == false">

                  <v-toolbar color="primary" dark flat>
                     <v-toolbar-title>Авторизация</v-toolbar-title>
                     <v-spacer></v-spacer>
                  </v-toolbar>

                  <v-card-text>
                     <v-form >

                        <!-- <ul class="list-group alert alert-danger" v-if="errors.length > 0">
                           <li class="list-group-item" v-for="error in errors" :key="errors.indexOf(error)">
                              <span v-for="value in error">
                                 {{value[0]}}
                                 <br>
                              </span>
                           </li>
                        </ul> -->

                        <v-alert type="error" v-if="errors.length > 0" class="text-left">
                           <span v-for="error in errors" :key="errors.indexOf(error)">
                              <span v-for="value in error">
                                 {{value[0]}}
                                 <br>
                              </span>
                           </span>
                        </v-alert>


                        <v-text-field
                        label="Email"
                        name="email"
                        v-model="email"
                        :rules="[rules.required]"
                        prepend-icon="mdi-account"
                        type="text"
                        ></v-text-field>

                        <v-text-field
                        v-model="password"
                        :append-icon="show ? 'mdi-eye' : 'mdi-eye-off'"
                        prepend-icon="mdi-lock"
                        :rules="[rules.required, rules.min]"
                        :type="show ? 'text' : 'password'"
                        name="input-10-1"
                        label="Пароль"
                        hint="Не меньше 8 символов"
                        counter
                        @click:append="show = !show"
                        ></v-text-field>

                     </v-form>
                  </v-card-text>

                  <v-card-actions class='pl-5 pr-5 pb-4'>
                     <v-btn color="primary" @click="login" class="mr-2">Войти</v-btn>
                     <v-spacer></v-spacer>
                     <router-link to="/register">Регистрация</router-link>
                  </v-card-actions>

               </v-card >

               <v-card class="elevation-12 p-2" v-else>
                  <p>Вы авторизованы</p>
                  <p>{{user.name}}</p>
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
         password: '',
         authenticated: auth.check(),
         user: auth.user,
         show: false,
         errors: [],
         rules: {
            required: value => !!value || 'объязательно.',
            min: v => v.length >= 8 || 'Минимум 8 символов',
            emailMatch: () => ('The email and password you entered don\'t match'),
         },
      }
   },

   methods: {
      login () {
         let data = {
            email: this.email,
            password: this.password,
         };
         axios.post('/login', data).then(({data}) => {
            console.log(data);
            
            auth.login(data);
            if(this.$route.path != '/profile'){
               this.$router.push('/profile');
            }
         }).catch(error => {
            this.errors = []
            if (error.response.status == 422) {
               this.errors.push(error.response.data.errors);
            }
         })
         console.log(this.errors);
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
