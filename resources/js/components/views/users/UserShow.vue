<template>
   <div>
      <v-layout column>
         <v-card class="p-4">
            <h4 class="text-left">{{user.name}}</h4>
            <v-form class="text-left">

               <v-select
               v-model="group"
               :items="groups"
               label="Группа пользователя"
               item-text="name"
               item-value="id"
               >
            </v-select>

            <v-btn color="primary" @click="update" class="mr-2">Сохранить</v-btn>

         </v-form>
      </v-card>
   </v-layout>
</div>
</template>

<script>
export default {

   props: ['id'],

   data () {
      return {
         name: '',
         user: auth.user,
         group:'',
         groups: [],
      }
   },

   mounted(){

   },

   methods: {



      update(){

         axios.post('/users/update/group/'+this.id, {
            group: this.group,
         }).then(({data}) => {
            this.$notify({
               text: 'Данные обновлены',
               type:'success'
            })
         }).catch((response) => {

            this.$notify({
               text: 'Ошибка',
               type:'error'
            })
         })
      }

   },

   mounted(){
      axios.get('/groups/index').then((response) => {
         this.groups = response.data
      })

      axios.get('/users/show/'+this.id).then((response) => {

      })
   },

}


</script>
