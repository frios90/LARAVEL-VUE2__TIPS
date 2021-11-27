<template>
    <div class="mantainer">    
        <div v-if="loader" class="loader"></div>      
                         
        <div class="">
            <div class="head">       
                <div class="head-div1">
                    <h1 class="mantainer-title">
                        Editar staff<br>
                        <span class="mantainer-navegation">               
                            <span @click="go('/home')"  title="Volver a inicio"><i class="fas fa-home mantainer-btn-navigation"></i></span>
                             /  
                            <span @click="go('/staff')" class="mantainer-pointer"> staff </span> 
                             /  
                            <span class="mantainer-in-here"> editar </span> 
                        </span>     
                    </h1> 
                </div>
                <div class="head-div2">
                    <div class="head-div2">   
                        <span @click="postUpdate()" title="Editar" class="mantainer-btn-check-event"> <i class="far fa-check-circle"></i></span>            
                        <span @click="go('/staff')" title="Cancelar y volver atras" class="mantainer-btn-cancel-event"> <i class="fas fa-ban"></i></span>  
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
                            <label for="">Rut <i class="fas fa-info-circle mantainer-info" title="ingrese el rut del nuevo usaurio"></i></label>
                            <input disabled type="text" class="form-control form-control-sm mantainer-input" v-model="rut" name="rut" v-rut:live maxlength="12">
                            <span class="errors" v-if="errors && errors.rut">{{errors.rut[0] }}</span>
                        </div>
                        <div class="form-group col-md-8">
                            <label for="">Nombre <i class="fas fa-info-circle mantainer-info" title="Ingrese el nombre completo del usuario"></i></label>
                            <input type="text" class="form-control form-control-sm mantainer-input" v-model="name" name="name">
                            <span class="errors" v-if="errors && errors.name">{{errors.name[0] }}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="">Teléfono / celular <i class="fas fa-info-circle mantainer-info" title="Ingrese un número de contacto del usuario"></i></label>
                            <input type="text" class="form-control form-control-sm mantainer-input" v-model="phone" name="phone" maxlength="9" @keypress="isNumber($event)">
                            <span class="errors" v-if="errors && errors.phone">{{errors.phone[0] }}</span>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">Correo <i class="fas fa-info-circle mantainer-info" title="Ingrese el correo de contacto del usuario"></i></label>
                            <input type="text" class="form-control form-control-sm mantainer-input" v-model="email" name="email">
                            <span class="errors" v-if="errors && errors.email">{{errors.email[0] }}</span>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">Nacionalidad <i class="fas fa-info-circle mantainer-info" title="Seleccione una nacionalidad"></i></label>
                            <select class="form-control form-control-sm mantainer-input" v-model="country" name="country">
                                <option value="Chilena/o">Chilena/o</option>
                                <option value="Argentina/o">Argentina/o</option>
                                <option value="Venezolana/o">Venezolana/o</option>
                                <option value="Colombiana/o">Colombiana/o</option>
                                <option value="Haitiana/o">Haitiana/o</option>
                                <option value="Otra/o">Otra/o</option>
                            </select>
                            <span class="errors" v-if="errors && errors.area_id">{{errors.area_id[0] }}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="">Región <i class="fas fa-info-circle mantainer-info" title="Seleccione una región"></i></label>
                            <select class="form-control form-control-sm mantainer-input" v-model="region_id" name="region_id" @change="getCommunes()">
                                <option value="0" selected>Seleccione una región</option>
                                <option v-for="(list, index) in region_list" :key="index" :value="list.id">
                                    {{ list.name }}
                                </option>
                            </select>
                            <span class="errors" v-if="errors && errors.region_id">{{errors.region_id[0] }}</span>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">Comuna <i class="fas fa-info-circle mantainer-info" title="Seleccione una comuna"></i></label>
                            <select class="form-control form-control-sm mantainer-input" v-model="commune_id">
                                <option value="0" selected>Seleccione una comuna</option>
                                <option v-for="(list, index) in commune_list" :key="index" :value="list.id" name="commune_id">
                                    {{ list.name }}</option>
                            </select>
                            <span class="errors" v-if="errors && errors.commune_id">{{errors.commune_id[0] }}</span>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">Dirección <i class="fas fa-info-circle mantainer-info" title="Ingrese la dirección del usuario"></i></label>
                            <input type="text" class="form-control form-control-sm mantainer-input" placeholder="Ingrese la dirección del usuario" v-model="address" name="address">
                            <span class="errors" v-if="errors && errors.address">{{errors.address[0] }}</span>
                        </div>
                    </div>                                       
                   
                </form>
            </div>
        </div>
    </div>               
</template>
<script>

    import Utilities from '../mixins/Utilities.js'

    export default {
        name   : 'create-request',
        mixins : [ Utilities],

        data () {
            return {
                id           : this.$route.params.id,
                csrf         : document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                errors       : {},
                region_list  : {},
                commune_list : {},
                area_list    : {},
                profile_list : {},
                rut          : "",
                name         : "",
                email        : "",
                cash         : "",
                phone        : "",
                address      : "",               
                commune_id   : "",
                region_id    : "",
                country      : ""
            }
        },       
        created() {          
          this.getRegions()         
          this.getStaff()
        },
        methods: {
            getStaff () {
                var self = this
                this.$http.get('/get-staff', {params: {id: self.id}})
                .then(response => {                    
                    self.rut        = response.body.rut
                    self.name       = response.body.name
                    self.address    = response.body.address
                    self.phone      = response.body.phone
                    self.email      = response.body.email
                    self.country    = response.body.country
                    self.region_id  = response.body.commune.region.id
                    self.loader     = false
                    this.getCommunes()
                    self.commune_id = response.body.commune_id

                }, response => {                 
                    self.$toasted.global.APP_GENERAL_ERROR()
                })
            },            
            getRegions ()  {
                var self = this  
                this.$http.get('/region-list').then(function(response){
                    self.region_list = response.body
                    }, function(){
                        this.$toasted.global.APP_GENERAR_ERROR()
                    })           
            },
            getCommunes ()  {
                this.commune_id = ''
                var self = this  
                    this.$http.get('/commune-list', {params: {region: self.region_id}}).then(function(response){
                        self.commune_list = response.body
                        }, function(){
                            this.$toasted.global.APP_GENERAR_ERROR()
                        })           
            },
            postUpdate () {
                event.preventDefault()
                this.loader = true

                var data = {
                    _token     : this.csrf,
                    id         : this.id,
                    rut        : this.rut,
                    name       : this.name,
                    address    : this.address,
                    phone      : this.phone,
                    email      : this.email,
                    country    : this.country,
                    region_id  : this.region_id, 
                    commune_id : this.commune_id               
                }
                var self = this  
                this.$http.post('/staff-update', data)
                .then(response => {
                    self.$toasted.global.APP_GENERAL_SUCCESS()
                    self.errors = {}
                    self.$router.push({ path: "/staff"})
                    self.loader = false
                }, response => {                 
                    if (response.status === 422) {
                        self.$toasted.global.APP_GENERAL_ERROR_FORM()
                        self.errors = response.body.errors
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
          upper: function (value) {
              return value.toUpperCase();
          }
        }
    }
</script>
<style>

</style>
@endsection
