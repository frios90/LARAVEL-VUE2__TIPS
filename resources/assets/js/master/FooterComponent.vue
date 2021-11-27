<template>      
      <footer class="tm-footer row tm-mt-small">
            <div class="col-12 font-weight-light">
                <p class="text-center text-white mb-0 px-4 small">
                   </p>
            </div>
        </footer>
</template>
<script>
    export default {
        name: 'create-request',
        data () {
            return {               
                csrf  : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        },       
        created() {
        },
        methods: {
        //   logOut(){
        //       var data =  {
        //         _token: this.csrf
        //       }
        //       var self = this  
        //       this.$http.post('/log-out', data).then(function(response){
        //            location.href = window.location
        //           }, function(){
        //               alert('Error!');
        //           })           
            
        //   }
        }
    }
</script>
<style>

</style>