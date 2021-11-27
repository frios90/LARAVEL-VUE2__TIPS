<template >
 <div class="mantainer">
    <div v-if="loader" class="loader"></div>
    <div class="">
      <div class="head">       
        <div class="head-div1">
          <h1 class="mantainer-title">
            Staffs <br>
            <span class="mantainer-navegation">               
                <span @click="go('/home', 'home')"  title="Volver a inicio" ><i class="fas fa-home mantainer-btn-navigation"></i></span>
                / 
                <span class="mantainer-in-here"> staff </span> 
                /
                <span v-if="license_allowed.staff_allow.status" @click="go('/staff/create')"  title="Añadir un nuevo colaborador al staff"><i class="fas fa-plus mantainer-btn-navigation"></i></span>
                <span v-else title="Haz alcanzado el limite de colaboradores activos de tu licencia"><i class="fas fa-exclamation mantainer-btn-navigation"></i></span>
            </span>
          </h1> 
        </div>       
      </div>
      <hr class="mantainer-divisor"/>
      <div class="mantainer-container-table" >
        <v-client-table 
                      :data="tableData" 
                      :columns="columns" 
                      :options="options">
          <span slot="actions" slot-scope="props">
            <router-link v-if ="!props.row.deleted_at" title="Editar registro" :to="'/staff/edit/'+props.row.id"><i class="actions fas fa-edit"></i></router-link>
            <i v-if ="!props.row.deleted_at" title="Cambiar estado" class="actions fab fa-angellist hover-cursor" @click="changeStatus(props.row.id)"></i>
            <i v-else class="fas fa-skull hover-cursor" title="Cambiar estado" @click="changeStatus(props.row.id)"></i>                  
          </span>                                                     
        </v-client-table>  
      </div>     
      
    </div>
  </div>
</template>
<script>  
    import Table     from '../mixins/Table.js';
    import Utilities from '../mixins/Utilities.js'
    export default {
        name: 'index-staff',
        mixins: [Table, Utilities],
        data () {
          return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
          }
        },
        created () {
          this.getDataTable('/staff-table-list')
          this.columns = ['name', 'email', 'phone', 'country','actions']
          this.options.headings = {                
            phone   : 'Teléfono',
            name    : 'Nombre',
            email   : 'Correo',
            country : 'Nacionalidad',                    
            actions : '',
          }
          this.options.sortable = [
            'rut'
          ]
        },       
        methods: {        
          goToEdit(redirect) {
            event.preventDefault()           
            router.push('/staff/edit/5')
          },
          changeStatus (id) {
            event.preventDefault()
            var data = {
                _token: this.csrf,
                id: id            
              }
            var self = this  
            this.$http.post('/staff-status', data)
            .then(response => {
                self.getDataTable('/staff-table-list')
                self.$toasted.global.APP_GENERAL_SUCCESS()
                self.errors = {}
              }, response => {                 
                 self.$toasted.global.APP_GENERAL_ERROR()
              })
          }          
        },
        filters: {
          upper: function (value) {
            return value.toUpperCase();
          }
        },
        computed: {
          rows() {
            return this.items.length
          }
        }
    }
</script>
@endsection
<style>







  


</style>
