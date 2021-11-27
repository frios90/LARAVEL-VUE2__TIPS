<template >
 <div class="mantainer">
    <div v-if="loader" class="loader"></div>
    <div class="">
      <div class="head">       
        <div class="head-div1">
          <h1 class="mantainer-title">
            Licencias <br>
            <span class="mantainer-navegation">               
                <span @click="go('/home', 'home')"  title="Volver a inicio" ><i class="fas fa-home mantainer-btn-navigation"></i></span>
                / 
                <span class="mantainer-in-here"> licencias </span> 
                /
                <span @click="go('/license/create')"  title="Añadir un nueva licencia"><i class="fas fa-plus mantainer-btn-navigation"></i></span>
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
            <router-link v-if ="!props.row.deleted_at" title="Editar registro" :to="'/license/edit/'+props.row.id"><i class="actions fas fa-edit"></i></router-link>
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
        name: 'index-license',
        mixins: [Table, Utilities],
        data () {
          return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
          }
        },
        created () {
          this.getDataTable('/license-table-list')
          this.columns = ['name', 'code', 'qty_staff', 'qty_user','qty_work_month','value','actions']
          this.options.headings = {                
            name           : 'Nombre',
            code           : 'código',
            qty_staff      : 'Colboradores',
            qty_user       : 'Usuarios',
            qty_work_month : 'Solicitudes',
            value          : 'Valor',
            actions        : '',
          }
          this.options.sortable = [
            'name'
          ]
        },       
        methods: {        
          goToEdit(redirect) {
            event.preventDefault()           
            router.push('/license/edit/5')
          },
          changeStatus (id) {
            event.preventDefault()
            var data = {
                _token: this.csrf,
                id: id            
              }
            var self = this  
            this.$http.post('/license-status', data)
            .then(response => {
                self.getDataTable('/license-table-list')
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
