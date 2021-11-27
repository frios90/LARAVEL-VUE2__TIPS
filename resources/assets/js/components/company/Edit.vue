<template>
    <div class="mantainer">    
        <div v-if="loader" class="loader"></div>                         
        <div class="">
            <div class="head">       
                <div class="head-div1">
                    <h1 class="mantainer-title">
                        Editar datos del bar {{ name }}<br>
                        <span class="mantainer-navegation">               
                            <span @click="go('/home')"  title="Volver a inicio"><i class="fas fa-home mantainer-btn-navigation"></i></span>
                             /  
                            <span @click="go('/company')" class="mantainer-pointer"> bares </span> 
                             /  
                            <span class="mantainer-in-here"> ingresar </span> 
                        </span>     
                    </h1> 
                </div>
                <div class="head-div2">
                    <div class="head-div2">   
                        <span @click="postUpdate()" title="Actualizar" class="mantainer-btn-check-event"> <i class="far fa-check-circle"></i></span>            
                        <span @click="go('/company')" title="Cancelar y volver atras" class="mantainer-btn-cancel-event"> <i class="fas fa-ban"></i></span>  
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
                            <label for="">Convenio desde <i class="fas fa-info-circle mantainer-info" title="Fecha de inicio de contrato"></i></label>
                            <input type="date" class="form-control from-control-sm  mantainer-input"  v-model="since" name="since">
                            <span class="errors" v-if="errors && errors.since">{{errors.since[0] }}</span>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">Licencia <i class="fas fa-info-circle mantainer-info" title="Licencia contratada"></i></label>
                            <select class="form-control form-control-sm  mantainer-input" v-model="license_id" name="license_id">
                                <option value="0" selected>Seleccione una licencia</option>
                                <option v-for="(list, index) in licenses_list" :key="index" :value="list.id">
                                    {{ list.name }}
                                </option>
                            </select>
                            <span class="errors" v-if="errors && errors.region_id">{{errors.region_id[0] }}</span>
                        </div>                                                               
                    </div> 
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="">Rut <i class="fas fa-info-circle mantainer-info" title="Rut de la empresa o bar"></i></label>
                            <input type="text" class="form-control from-control-sm  mantainer-input" v-model="rut" name="rut" v-rut:live maxlength="12">
                            <span class="errors" v-if="errors && errors.rut">{{errors.rut[0] }}</span>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">Nombre legal <i class="fas fa-info-circle mantainer-info" title="Nombre para gestiones tributarias"></i></label>
                            <input type="text" class="form-control from-control-sm  mantainer-input"  v-model="legal_name" name="legal_name">
                            <span class="errors" v-if="errors && errors.legal_name">{{errors.legal_name[0] }}</span>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">Nombre <i class="fas fa-info-circle mantainer-info" title="Nombre de la empresa o bar"></i></label>
                            <input type="text" class="form-control from-control-sm  mantainer-input"  v-model="name" name="name">
                            <span class="errors" v-if="errors && errors.name">{{errors.name[0] }}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="">Contacto <i class="fas fa-info-circle mantainer-info" title="Nombre del contacto directo con la empresa"></i></label>
                            <input type="text" class="form-control from-control-sm  mantainer-input"  v-model="contact" name="contact">
                            <span class="errors" v-if="errors && errors.contact">{{errors.contact[0] }}</span>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">teléfo de contacto <i class="fas fa-info-circle mantainer-info" title="Número de teléfono del contacto directo con la empresa"></i></label>
                            <input type="text" class="form-control from-control-sm  mantainer-input" v-model="phone" name="phone" maxlength="9" @keypress="isNumber($event)">
                            <span class="errors" v-if="errors && errors.phone">{{errors.phone[0] }}</span>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">Correo de contacto <i class="fas fa-info-circle mantainer-info" title="Correo del contacto directo de la empresa"></i></label>
                            <input type="text" class="form-control from-control-sm  mantainer-input" placeholder="Ingrese el correo de contacto y acceso del usuario" v-model="email" name="email">
                            <span class="errors" v-if="errors && errors.email">{{errors.email[0] }}</span>
                        </div>                                           
                    </div>                                       
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="">Región <i class="fas fa-info-circle mantainer-info" title="Región en la que se ubica el bar o empresa"></i></label>
                            <select class="form-control from-control-sm  mantainer-input" v-model="region_id" name="region_id" @change="getCommunes()">
                                <option value="0" selected>Seleccione una región</option>
                                <option v-for="(list, index) in region_list" :key="index" :value="list.id">
                                    {{ list.name }}
                                </option>
                            </select>
                            <span class="errors" v-if="errors && errors.region_id">{{errors.region_id[0] }}</span>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">Comuna <i class="fas fa-info-circle mantainer-info" title="Comuna en la que se ubica el bar o empresa"></i></label>
                            <select class="form-control from-control-sm  mantainer-input" v-model="commune_id">
                                <option value="0" selected>Seleccione una comuna</option>
                                <option v-for="(list, index) in commune_list" :key="index" :value="list.id" name="commune_id">
                                    {{ list.name }}</option>
                            </select>
                            <span class="errors" v-if="errors && errors.commune_id">{{errors.commune_id[0] }}</span>

                        </div>
                        <div class="form-group col-md-4">
                            <label for="">Dirección <i class="fas fa-info-circle mantainer-info" title="Direccion del bar o empresa"></i></label>
                            <input type="text" class="form-control from-control-sm  mantainer-input" placeholder="Ingrese la dirección del usuario" v-model="address" name="address">
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
        name: 'create-request',
        mixins: [Utilities],
        data () {
            return {
                id : this.$route.params.id,
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                errors: {},
                region_list: {},
                commune_list: {},
                area_list: {},
                profile_list: {},
                licenses_list: {},
                rut: "",
                name: "",
                email: "",
                cash: "",
                phone: "",
                address: "",               
                commune_id: "",
                region_id: "",
                legal_name: "",
                since: "",
                contact: "",
                license_id: ""
            }
        },       
        created() {          
          this.getRegions()         
          this.getCompany()
          this.getLicenses()
          this.loader = false
        },
        methods: {
            getLicenses() {
                var self = this
                this.$http.get('/licenses-list').then(function(response) {
                    self.licenses_list = response.body
                }, function() {
                    this.$toasted.global.APP_GENERAR_ERROR()
                })
            },
            getCompany () {
                var self = this
                this.$http.get('/get-company', {params: {id: self.id}})
                .then(response => {                    
                    self.rut        = response.body.rut
                    self.name       = response.body.name
                    self.address    = response.body.address
                    self.phone      = response.body.phone
                    self.email      = response.body.email
                    self.country    = response.body.country
                    self.region_id  = response.body.commune.region.id
                    self.legal_name = response.body.legal_name
                    self.contact    = response.body.contact
                    self.since      = response.body.since
                    self.license_id = response.body.license_id
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
                    legal_name : this.legal_name,
                    region_id  : this.region_id, 
                    commune_id : this.commune_id,
                    since      : this.since, 
                    contact    : this.contact,
                     license_id : this.license_id        
                }
                var self = this  
                this.$http.post('/company-update', data)
                .then(response => {
                    self.$toasted.global.APP_GENERAL_SUCCESS()
                    self.errors = {}
                    self.$router.push({ path: "/company"})
                    self.laoder = false
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

@endsection
