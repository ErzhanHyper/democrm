class Auth {
   constructor() {

      let userData = window.localStorage.getItem('user');
      this.user = userData ? JSON.parse(userData) : null;
      this.getUser();

   }

   update(user){
      this.user = user;
      this.getUser();
      Event.$emit('userUpdated');
   }

   login (user) {
      this.user = user;
      this.getUser();
      Event.$emit('userLoggedIn');
   }

   logout() {
      axios.post('/logout').then(response => {
         window.localStorage.setItem('user', null);
         this.user = null;
         Event.$emit('userLoggedOut');
      }).catch(error => {

      });
   }


   getUser() {
      if(this.user){
         axios.get('/get-user')
         .then(({data}) => {
            window.localStorage.setItem('user', JSON.stringify(data));
            this.user = data
         })
         .catch(({response}) => {
            this.logout()
         });
      }
   }


   check () {
      return !! this.user;
   }


   active () {
      if(this.user){
         return this.user.status == 'ACTIVE' ? true : false;
      }
   }



}



export default Auth;
