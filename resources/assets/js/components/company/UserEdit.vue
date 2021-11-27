<template>
    <div class="mantainer">                             
        <div class="">
            <div v-if="loader" class="loader"></div>

            <div class="head">       
                <div class="head-div1">
                    <h1 class="mantainer-title">
                        Edicion de {{user.name}} de la empresa {{ name_company }}<br>
                        <span class="mantainer-navegation">               
                            <span @click="go('/home')"  title="Volver a inicio"><i class="fas fa-home mantainer-btn-navigation"></i></span>
                             /  
                            <span @click="go('/company')" class="mantainer-pointer"> bares </span> 
                             / 
                             <span @click="go('/company/'+company_id+'/users')" class="mantainer-pointer"> usuarios </span> 
                             /  
                            <span class="mantainer-in-here"> editar </span> 
                        </span>     
                    </h1> 
                </div>
                <div class="head-div2">
                    <div class="head-div2">   
                        <span @click="postCreate()" title="Ingresar" class="mantainer-btn-check-event"> <i class="far fa-check-circle"></i></span>            
                        <span @click="go('/company/'+company_id+'/users')" title="Cancelar y volver atras" class="mantainer-btn-cancel-event"> <i class="fas fa-ban"></i></span>  
                    </div> 
                </div>     
            </div>
        </div>   
        <hr class="mantainer-divisor"/>
        <div class="mantainer-container-table" >
            <div class="">
                <form action="" class="tm-edit-product-form">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="">Rut <i class="fas fa-info-circle mantainer-info" title="Rut del usuario de la cuenta empresa/bar"></i></label>
                            <input type="text" class="form-control form-control-sm mantainer-input" placeholder="ingrese el rut del nuevo usaurio" v-model="user.rut" name="rut" v-rut:live maxlength="12">
                            <span class="errors" v-if="errors && errors.rut">{{errors.rut[0] }}</span>
                        </div>
                        <div class="form-group col-md-8">
                            <label for="">Nombre  <i class="fas fa-info-circle mantainer-info" title="Nombre del usuario de la cuenta empresa/bar"></i></label>
                            <input type="text" class="form-control form-control-sm mantainer-input" placeholder="ingrese el nombre completo del usuario" v-model="user.name" name="name">
                            <span class="errors" v-if="errors && errors.name">{{errors.name[0] }}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="">Teléfono / celular   <i class="fas fa-info-circle mantainer-info" title="Teléfono del usuario de la cuenta empresa/bar"></i></label>
                            <input type="text" class="form-control form-control-sm mantainer-input" placeholder="Ingrese un número de contacto del usuario" v-model="user.phone" name="phone" maxlength="9" @keypress="isNumber($event)">
                            <span class="errors" v-if="errors && errors.phone">{{errors.phone[0] }}</span>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">Correo / acceso  <i class="fas fa-info-circle mantainer-info" title="Correo de acceso del usuario de la cuenta empresa/bar"></i></label>
                            <input type="text" class="form-control form-control-sm mantainer-input" placeholder="Ingrese el correo de contacto y acceso del usuario" v-model="user.email" name="email">
                            <span class="errors" v-if="errors && errors.email">{{errors.email[0] }}</span>
                        </div>
                        
                    </div>
                    <div class="row">                                           
                        <div class="form-group col-md-4">
                            <label for="">Perfil <i class="fas fa-info-circle mantainer-info" title="Tipo de perfil del usuario de la cuenta empresa/bar"></i></label>
                            <select class="form-control form-control-sm    mantainer-input" v-model="user.profile_id">
                                <option value="0" selected>Seleccione un perfil</option>
                                <option v-for="(list, index) in profile_list" :key="index" :value="list.id" name="commune_id">
                                    {{ list.name }}</option>
                            </select>
                            <span class="errors" v-if="errors && errors.profile_if">{{errors.profile_if[0] }}</span>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">Dirección <i class="fas fa-info-circle mantainer-info" title="Dirección del usuario de la cuenta empresa/bar"></i></label>
                            <input type="text" class="form-control form-control-sm    mantainer-input" placeholder="Ingrese la dirección del usuario" v-model="user.address" name="address">
                            <span class="errors" v-if="errors && errors.address">{{errors.address[0] }}</span>
                        </div>
                    </div> 
                </form>
            </div>
        </div>
    </div>      
</template>
<script>
    import Company from '../mixins/Company.js'
        import Utilities from '../mixins/Utilities.js'

    export default {
        name: 'update-user-company',
        mixins: [Company, Utilities],
        data() {
            return {
                company_id : this.$route.params.company_id,
                user_id : this.$route.params.id,
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                errors: {},
                profile_list: {},
                user: {}                
            }
        },
        created() {
            this.getUserCompany()
            this.getProfiles()
            this.getCompany(this.company_id)
        },
        methods: {
            getUserCompany() {
            var self = this
                this.$http.get('/company-get-user', {
                    params: {
                        company_id: self.company_id,
                        user_id: self.user_id
                    }
                }).then(function(response) {
                    self.user = response.body
                    self.loader = false
                }, function() {
                    this.$toasted.global.APP_GENERAR_ERROR()
                    self.loader = false
                })
            },
            getProfiles ()  {
                var self = this  
                this.$http.get('/profile-list').then(function(response){
                    self.profile_list = response.body
                    }, function(){
                        this.$toasted.global.APP_GENERAR_ERROR()
                    })           
            },
             
            postCreate() {
                event.preventDefault()
                this.loader = true
                var data = {
                    _token: this.csrf,
                    id        : this.user.id,
                    rut       : this.user.rut,
                    name      : this.user.name,
                    phone     : this.user.phone,
                    email     : this.user.email,
                    address   : this.user.address,
                    profile_id : this.user.profile_id
                }
                var self = this
                this.$http.post('/user-update', data)
                    .then(response => {
                        self.$toasted.global.APP_GENERAL_SUCCESS()
                        self.errors = {}
                        self.$router.push({
                            path: "/company/"+this.company_id+"/users"
                        })
                        self.loader = false
                    }, response => {
                        if (response.status === 422) {
                            self.$toasted.global.APP_GENERAL_ERROR_FORM()
                            self.errors = response.body.errors
                        } else {
                            self.$toasted.global.APP_GENERAL_ERROR()
                        }
                        self.loader = false
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
