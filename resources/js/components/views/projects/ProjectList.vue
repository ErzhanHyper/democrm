<template>
   <div>
      <v-layout column>
         <v-card class="p-4 text-left">
            <v-row>
               <v-col cols="6">
                  <h4 class="text-left">Проекты</h4>
               </v-col>
               <v-col cols="6" class="text-right">
                  <router-link to="/projects/create" v-if="edit"><v-btn>Добавить проект</v-btn></router-link>
               </v-col>
            </v-row>
            <hr>

            <v-row>

               <v-col cols="3">
                  <v-text-field
                  v-model="searchName"
                  label="Поиск по наименованию"
                  ></v-text-field>
               </v-col>

               <v-col cols="3">
                  <v-select
                  :items="statuses"
                  v-model="selectStatus"
                  label="Статус"
                  item-text="name"
                  item-value="name"
                  ></v-select>
               </v-col>

               <v-col cols="3">
                  <v-select
                  :items="owners"
                  v-model="selectOwner"
                  label="Исполнитель"
                  item-text="name"
                  item-value="name"
                  ></v-select>
               </v-col>

               <v-col cols="3">
                  <v-btn small class="mt-5" @click="resetFilter">Сбросить</v-btn>
               </v-col>

            </v-row>


            <v-simple-table v-if="items.length > 0">
               <thead>
                  <tr>
                     <th>Наименование</th>
                     <th>Дата создание</th>
                     <th>Исполнитель</th>
                     <th>Клиент</th>
                     <th>Статус</th>
                  </tr>
               </thead>
               <tbody>
                  <tr v-for="(item, index) in filteredItems" :key="index">
                     <td><router-link :to="{ name: 'project_show', params: { id: item.id }}" v-if="read">{{ item.name }}</router-link><span v-else>{{ item.name }}</span></td>
                     <td>{{ item.dtin }}</td>
                     <td>{{ item.owner }}</td>
                     <td>{{ item.client }}</td>
                     <td>{{ item.status }}</td>
                  </tr>
               </tbody>
            </v-simple-table>
            <span v-else>Пусто</span>

         </v-card>
      </v-layout>
   </div>
</template>

<script>



export default {

   data () {
      return {
         owners: [],
         searchName: '',
         selectStatus: '',
         selectOwner: '',
         user: auth.user,
         items: [],
         edit:auth.user.grpuser.group.edit,
         read:auth.user.grpuser.group.read,
         del: auth.user.grpuser.group.delete,
         statuses: [],
      }
   },

   mounted(){
      axios.get('/projects/index').then((response) => {
         this.items = response.data;
      })

      axios.get('/get-users').then((response) => {
         this.owners = response.data;
      })

      axios.get('/statuses/index').then((response) => {
         this.statuses = response.data;
      })

   },

   computed: {

      filteredItems: function() {
         return this.items.filter(item => {
            return this.searchName == '' || item.name.toLowerCase().indexOf(this.searchName.toLowerCase()) !== -1;
         }).filter(item => {
            return this.selectStatus == '' || item.status.toLowerCase().indexOf(this.selectStatus.toLowerCase()) !== -1;
         }).filter(item => {
            return this.selectOwner == '' || item.owner.toLowerCase().indexOf(this.selectOwner.toLowerCase()) !== -1;
         });;
      }


   },

   methods:{

      resetFilter(){
         this.selectStatus = ''
         this.selectOwner = ''
         this.searchName = ''
      }

   }

}


</script>
