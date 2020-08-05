<template>
   <div>
      <v-container fluid>
         <v-layout column>

            <v-card class="p-4">

               <h4 class="text-left">Изменение пароля</h4>
               <hr>
               <v-col cols="4">

                  <v-card-text>
                     <v-form >
                        <v-text-field
                        label="Пароль"
                        v-model="password"
                        prepend-icon="mdi-account"
                        type="password"
                        ></v-text-field>

                        <v-text-field
                        label="Подтверждение пароля"
                        v-model="password_confirmation"
                        prepend-icon="mdi-lock"
                        type="password"
                        ></v-text-field>
                     </v-form>

                     <v-alert dense text type="success" v-if="show">
                        {{message}}
                     </v-alert>
                  </v-card-text>

                  <v-card-actions>
                     <v-spacer></v-spacer>
                     <v-btn color="primary" @click="requestChangePassword" class="mr-2">Сохранить</v-btn>
                  </v-card-actions>
               </v-col>

            </v-card >

         </v-layout>

      </v-container>
   </div>
</template>

<script>
export default {
   data() {
      return {
         password: '',
         password_confirmation: '',
         show: false,
         message: '',
      }
   },
   methods: {
      requestChangePassword() {
         axios.post('/user/change_password', {
            password: this.password,
            password_confirmation: this.password_confirmation,
         }).then((response) => {
            this.show = true
            this.message = response.data.message
         });
      }
   }
}
</script>
