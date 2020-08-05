<template>
   <div>
      <v-layout column>
         <v-card class="p-4">
            <h4 class="text-left">Проект {{project.name}}</h4>
            <v-form class="text-left">
               <v-text-field
               label="Название"
               v-model="name"
               type="text"
               ></v-text-field>

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


      <v-select
      v-model="status"
      :items="statuses"
      label="Статус"
      item-text="name"
      item-value="id"
      >
   </v-select>

   <v-btn color="primary" @click="update" class="mr-2" v-if="edit">Сохранить</v-btn>

</v-form>

<br>
<hr>
<br>

<v-tabs v-model="tab" class="elevation-2" >
<v-tabs-slider></v-tabs-slider>

<v-tab v-for="tab in tabs" :key="tab.id" :href="'#tab-'+tab.id" >
   {{ tab.name }}
</v-tab>

<v-tab-item :value="'tab-1'">
   <v-card flat tile>
      <v-simple-table class="text-left" v-if="projects.length > 0">
         <thead>
            <tr>
               <th>Наименование задачи</th>
               <th>Дата создания</th>
               <th>Статус</th>
               <th>Исполнитель</th>
            </tr>
         </thead>
         <tbody>
            <tr v-for="item in projects" :key="item.id">
               <td><router-link :to="{ name: 'task_show', params: { id: item.id }}" >{{ item.name }}</router-link></td>
               <td>{{ item.dtin }}</td>
               <td>{{ item.status }}</td>
               <td>{{ item.user.Fio }}</td>
            </tr>
         </tbody>
      </v-simple-table>
   </v-card>
</v-tab-item>


<v-tab-item :value="'tab-2'">
   <v-card flat tile>
      Звонки
   </v-card>
</v-tab-item>

<v-tab-item :value="'tab-3'">
   <v-card flat tile>
      Примечание
   </v-card>
</v-tab-item>


<v-tab-item :value="'tab-4'">
   <v-card flat tile>
      Фотографии
   </v-card>
</v-tab-item>

</v-tabs>


</v-card>
</v-layout>
</div>
</template>

<script>
export default {

   props: ['id'],

   data () {
      return {
         statuses: [],
         name: '',
         description: '',
         owner: '',
         collaborators: '',
         client: '',
         users: [],
         clients: [],
         tasks: [],
         project:'',
         projects:[],
         status: '',
         executor:null,

         edit:auth.user.grpuser.group.edit,

         tab: null,
         tabs: {
            0:{
               id: 1,
               name: 'Задачи'
            },
            1:{
               id: 2,
               name: 'Звонки'
            },
            2:{
               id: 3,
               name: 'Примечание'
            },
            3:{
               id: 4,
               name: 'Фотографии'
            },
         },

      }
   },

   mounted(){

   },

   methods: {



      update(){
         if(this.edit){
            let data = {
               name: this.name,
               description: this.description,
               owner: this.owner,
               collaborators: this.collaborators,
               client: this.client,
               tasks: this.tasks,
            }
            axios.post('/projects/update/'+this.id, {
               name: this.name,
               description: this.description,
               owner: this.owner,
               collaborators: this.collaborators,
               client: this.client,
               tasks: this.tasks,
               status: this.status,
            }).then(({data}) => {
               this.$notify({
                  text: data.message,
                  type:'success'
               })
            }).catch((response) => {
               this.$notify({
                  text: 'Ошибка',
                  type:'error'
               })
            })
         }
      }

   },

   mounted(){
      axios.get('/clients/index').then((response) => {
         this.clients = response.data;
      })

      axios.get('/get-users').then((response) => {
         this.users = response.data;
      })

      axios.get('/statuses/index').then((response) => {
         this.statuses = response.data;
      })

      axios.get('/projects/show/'+this.id).then((response) => {
         this.project = response.data
         this.name = this.project.name
         this.description = this.project.description
         this.owner = this.project.owner
         this.collaborators = JSON.parse(this.project.collaborators)
         this.client = this.project.client_id
         this.status = this.project.status
         this.projects = this.project.task
      })

   },

}


</script>
