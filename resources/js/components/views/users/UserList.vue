<template>
   <div>
      <v-layout column>
         <v-card class="p-4 text-left">
            <h4 >Пользователи</h4>
            <hr>
            <v-simple-table v-if="user.status == 'ACTIVE' && items.length > 0">
               <thead>
                  <tr>
                     <th>ID</th>
                     <th>Аватар</th>
                     <th>Логин</th>
                     <th>ФИО</th>
                     <th>Email</th>
                     <th>Телефон</th>
                     <th>Статус</th>
                     <th>Редактировать</th>
                  </tr>
               </thead>
               <tbody>
                  <tr v-for="item in items" :key="item.name">
                     <td>{{ item.id }}</td>
                     <td><img width="40px" :src="'/storage/user_photo/'+item.avatar " v-if="item.avatar != null"><span v-else>-</span></td>
                     <td>{{ item.name }}</td>
                     <td>{{ item.Fio }}</td>
                     <td>{{ item.email }}</td>
                     <td>{{ item.phone }}</td>
                     <td>{{ item.status == 'ACTIVE' ? 'Активный' : 'Не активный'}}</td>
                     <td><router-link :to="{ name: 'user_show', params: { id: item.id }}" ><v-icon>mdi-account-edit</v-icon></router-link></td>
                  </tr>
               </tbody>
            </v-simple-table>
            <span v-else >Пусто</span>

         </v-card>
      </v-layout>
   </div>
</template>

<script>
export default {

   data () {
      return {
         user: auth.user,
         items: [],
      }
   },

   mounted(){
      axios.get('/get-users').then((response) => {
         this.items = response.data;
      })

   },


}


</script>
