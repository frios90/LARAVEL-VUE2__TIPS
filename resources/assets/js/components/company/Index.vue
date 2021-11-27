<template > 

 <div class="mantainer">
    <div v-if="loader" class="loader"></div>

    <div class="">      
      <div class="head">       
        <div class="head-div1">
          <h1 class="mantainer-title">
            Bares<br>            
            <span class="mantainer-navegation">               
                <span @click="go('/home', '/home')"  title="Volver a inicio"><i class="fas fa-home mantainer-btn-navigation"></i></span>
                / 
                <span class="mantainer-in-here"> bares </span> 
                /
                <span @click="go('/company/create')"  title="Añadir un nuevo bar"><i class="fas fa-plus mantainer-btn-navigation"></i></span>
            </span>
          </h1> 
        </div>       
      </div>
      <hr class="mantainer-divisor"/>
 
      <div class="mantainer-container-table" >
        <v-client-table  class="index-table" :data="tableData" 
                      :columns="columns" 
                      :options="options">
          <span slot="actions" slot-scope="props">
            <router-link title ="editar empresa" v-if ="!props.row.deleted_at" :to="'/company/edit/'+props.row.id"><i class="actions fas fa-edit"></i></router-link>
            <router-link title ="ver usuarios de la empresa" v-if ="!props.row.deleted_at" :to="'/company/'+props.row.id+'/users'"><i class="actions fas fa-users"></i></router-link>
            <i v-if ="!props.row.deleted_at" class="fab fa-angellist actions" @click="changeStatus(props.row.id)"></i>
            <i v-else class="fas fa-skull" @click="changeStatus(props.row.id)"></i>                  
          </span>                                                     
        </v-client-table>
      </div>  
    </div>
  </div>
</template>
<script>
    import Table from '../mixins/Table.js'
    import Utilities from '../mixins/Utilities.js'
    export default {
        name: 'index-request',
        mixins: [Table, Utilities],
        data () {
          return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          }
        },
        created () {
          this.getDataTable('/company-table-list')
          this.columns          =  ['rut', 'name', 'email', 'phone','license.name', 'actions']
          this.options.headings = {                
            rut   : 'Rut',
            phone : 'Teléfono',
            name  : 'Nombre',
            email : 'Correo',
            'license.name': 'Licencia',
            actions: '',
          }
          this.options.sortable = ['rut']
        },
        methods: {          
          goToEdit(redirect) {
            event.preventDefault()           
            router.push('/company/edit/5')
          },
          changeStatus (id) {
            event.preventDefault()
            this.loader = true
            var data = {
                _token: this.csrf,
                id: id            
              }
            var self = this  
            this.$http.post('/company-status', data)
            .then(response => {
                self.getDataTable('/company-table-list')
                self.$toasted.global.APP_GENERAL_SUCCESS()
                self.errors = {}
                self.loader = false
              }, response => {                 
                 self.$toasted.global.APP_GENERAL_ERROR()
                 self.loader = false
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
.VueTables__search__input {
  background-color: whitesmoke;
  height: 30px!important;
}
.VueTables__search__input:focus {
  background-color: whitesmoke;
  color: black;
}
.content-body{
  padding-top: 35px!important;
  padding-left: 35px!important;
  padding-right: 35px!important;
}
.actions {
  color: #f5a623 !important;
  cursor: pointer;
}
.pagination {
  margin-top :20px!important;
} 

.content-body {
  height: 100%;
}
.mdi-checkbox-marked-circle {
  color:green;
}
.mdi-checkbox-blank-circle {
  color:red;
}
.mdi-tooltip-edit {
  color: blue;
}


.title { 
  display: grid; 
  grid-template-columns: repeat(2, 1fr); 
  grid-template-rows: 0.5fr; 
  grid-column-gap: 0px;
  grid-row-gap: 0px;  
}

.title .div1 { grid-area: 1 / 1 / 2 / 2; } 
.title .div2 { grid-area: 1 / 2 / 2 / 3;}
.title .div2 button  {
    text-align: center;
}    


/*
btn-plus, diseño del boton agregar nuevo registro
*/
.btn-plus {
	box-shadow:inset 0px 0px 15px 3px #276873;
	background:linear-gradient(to bottom, #599bb3 5%, #408c99 100%);
	background-color:#599bb3;
	border-radius:17px;
	border:1px solid #29668f;
	display:inline-block;
	cursor:pointer;
	color:#ffffff;
	font-family:Arial;
	font-size:15px;
	padding:6px 13px;
	text-decoration:none;
	text-shadow:0px 1px 0px #3d768a;
}
.btn-plus:hover {
	background:linear-gradient(to bottom, #408c99 5%, #599bb3 100%);
	background-color:#408c99;
}
.btn-plus:active {
	position:relative;
	top:1px;
}


</style>
