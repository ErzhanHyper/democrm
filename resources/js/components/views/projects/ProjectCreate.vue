<template>
   <div>
      <v-layout column>
         <v-card class="p-4">
            <h4 class="text-left">Добавить проект</h4>
            <v-form >
               <v-text-field
               label="Название"
               v-model="name"
               type="text"
               :error-messages="nameErrors"
               @input="$v.name.$touch()"
               @blur="$v.name.$touch()"
               ></v-text-field>
               <br>
               <v-textarea
               v-model="description"
               solo
               label="Описание"
               rows="2"
               ></v-textarea>

               <v-select
               v-model="owner"
               :items="users"
               label="Ответственный"
               item-text="Fio"
               item-value="id"
               :error-messages="ownerErrors"
               @input="$v.owner.$touch()"
               @blur="$v.owner.$touch()"
               >
            </v-select>

            <v-select
            v-model="collaborators"
            multiple
            :items="users"
            label="Соисполнители"
            item-text="Fio"
            item-value="id"
            >
         </v-select>

         <v-select
         v-model="client"
         :items="clients"
         label="Клиенты"
         item-text="name"
         item-value="id"
         >
      </v-select>

      <v-btn color="primary" @click="create" class="mr-2">Добавить</v-btn>

   </v-form>
</v-card>
</v-layout>
</div>
</template>

<script>
import { required, maxLength, email} from 'vuelidate/lib/validators'

export default {

   data () {
      return {
         name: '',
         description: '',
         owner: '',
         collaborators: '',
         client: '',
         users: [],
         clients: [],
         tasks: [],
         message: []
      }
   },

   mounted(){

   },

   validations: {
      name: { required},
      owner: { required},
   },

   computed: {
      nameErrors () {
         const errors = []
         if (!this.$v.name.$dirty) return errors
         !this.$v.name.required && errors.push('Объязательно для заполнения')
         return errors
      },

      ownerErrors () {
         const errors = []
         if (!this.$v.owner.$dirty) return errors
         !this.$v.owner.required && errors.push('Объязательно для заполнения')
         return errors
      },

   },

   methods: {



      create(){
         this.$v.$touch()

         let data = {
            name: this.name,
            description: this.description,
            owner: this.owner,
            collaborators: this.collaborators,
            client: this.client,
            tasks: this.tasks,
         }
         axios.post('/projects/store', {
            name: this.name,
            description: this.description,
            owner: this.owner,
            collaborators: this.collaborators,
            client: this.client,
            tasks: this.tasks,
         }).then(({data}) => {
            this.message = data.message
            this.$notify({
               text: this.message,
               type:'success'
            })
            this.$router.push('/projects');

         }).catch((response) => {
            this.$notify({
               text: 'Ошибка',
               type:'error'
            })
         })
      }

   },

   mounted(){
      axios.get('/clients/index').then((response) => {
         this.clients = response.data;
      })

      axios.get('/get-users').then((response) => {
         this.users = response.data;
      })
   },

}


</script>
