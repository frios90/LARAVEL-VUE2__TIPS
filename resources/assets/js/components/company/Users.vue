<template >  

 <div class="mantainer">
    <div class="">      
      <div v-if="loader" class="loader"></div>

      <div class="head">       
        <div class="head-div1">
          <h1 class="mantainer-title">
            Usuarios de la empresa {{name_company}} <br>
            <span class="mantainer-navegation">
                <span @click="go('/home')" class="mantainer-pointer"><i class="fas fa-home mantainer-btn-navigation"></i></span>
                /  
                <span @click="go('/company')" class="mantainer-pointer"> bares </span>               
                / 
                <span class="mantainer-in-here"> usuarios </span>
                /
                <span @click="go('/company/'+company_id+'/users/create')"  title="Añadir un nuevo usuario"><i class="fas fa-plus mantainer-btn-navigation"></i></span>
            </span>
          </h1> 
        </div>        
      </div>
      <div class="mantainer-container-table" >
        <v-client-table  class="index-table" :data="tableData" 
                      :columns="columns" 
                      :options="options">
          <span slot="actions" slot-scope="props">
            <router-link title="Editar" v-if ="!props.row.deleted_at" :to="'/company/'+company_id+'/users/edit/'+props.row.id"><i class="actions fas fa-edit"></i></router-link>
            <i title="Cambiar estado" v-if ="!props.row.deleted_at" class="fab fa-angellist actions" @click="changeStatus(props.row.id)"></i>
            <i title="Cambiar estado" v-else class="fas fa-skull" @click="changeStatus(props.row.id)"></i> 
            <i title="Reiniciar contraseña" class="fas fa-recycle actions" @click="resetPass(props.row.id)"></i>                
          </span>                                                     
        </v-client-table>
      </div>  
    </div>
  </div>
</template>
<script>
    import Company   from '../mixins/Company.js'
    import Table     from '../mixins/Table.js'
    import Utilities from '../mixins/Utilities.js'
    import Swal from "sweetalert2";

    export default {
        name: 'create',
        mixins: [Company, Table, Utilities],
        data() {
            return {
                company_id : this.$route.params.id,
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                errors: {},
                region_list: {},
                commune_list: {},
                area_list: {},
                profile_list: {},
                rut: "",
                name: "",
                email: "",
                cash: "",
                since: "",
                phone: "",
                address: "",               
                commune_id: "",
                region_id: "",
                contact: "",
                legal_name: "",
               
            }
        },
        created() {
          this.getCompany(this.company_id)          
          this.getDataTable('/company-get-users',  {company_id: this.company_id})
          this.columns =   [
            'rut',
            'name',
            'email',
            'phone',
            'actions'
          ]
          this.options.headings = {                
            rut: 'Rut',
            name: 'nombre',
            phone: 'telefono',
            actions: ''
          }
          this.options.sortable = ['nombre', 'rut']
        },
        methods: { 
          resetPass (id) {
            const swalWithBootstrapButtons = Swal.mixin({
              customClass: {
                confirmButton : "btn btn-success",
                cancelButton  : "btn btn-danger"
              },
              buttonsStyling: false
            });
            var self = this;
            var save_ok = false;
            swalWithBootstrapButtons
              .fire({
                title : "¿Esta seguro de reiniciar la contraseña?",
                text  : "Confirme que el usuario a reiniciar sea el que solicito el cambio!",
                icon  : "warning",
                showCancelButton: true,
                confirmButtonText: "Sí, seguro!",
                cancelButtonText:  "No, cancelar!",
                reverseButtons: true
              })
              .then(result => {
                if (result.value) {
                 var data = {
                          _token: this.csrf,
                          id: id            
                      }
                      var self = this  
                      this.$http.post('/reset-pass', data)
                      .then(response => {                          
                          self.$toasted.global.APP_GENERAL_SUCCESS()
                          self.errors = {}
                        }, response => {                 
                          self.$toasted.global.APP_GENERAL_ERROR()
                        })

                }
              })
          },       
          isNumber: function(evt) {
              evt = (evt) ? evt : window.event;
              var charCode = (evt.which) ? evt.which : evt.keyCode;
              if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
                  evt.preventDefault();;
              } else {
                  return true;
              }
          },
          changeStatus (id) {
            event.preventDefault()
            var data = {
                _token: this.csrf,
                id: id            
            }
            var self = this  
            this.$http.post('/user-status', data)
            .then(response => {
                this.getDataTable('/company-get-users',  {company_id: this.company_id})
                self.$toasted.global.APP_GENERAL_SUCCESS()
                self.errors = {}
              }, response => {                 
                 self.$toasted.global.APP_GENERAL_ERROR()
              })
          } 
        },
        filters: {
          upper: function(value) {
              return value.toUpperCase();
          }
        }
    }
</script>
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
