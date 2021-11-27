<template>
    <div class="mantainer">    
        <div v-if="loader" class="loader"></div>      
                         
        <div class="">
            <div class="head">       
                <div class="head-div1">
                    <h1 class="mantainer-title">
                        Editar licencia<br>
                        <span class="mantainer-navegation">               
                            <span @click="go('/home')"  title="Volver a inicio"><i class="fas fa-home mantainer-btn-navigation"></i></span>
                             /  
                            <span @click="go('/license')" class="mantainer-pointer"> licencias </span> 
                             /  
                            <span class="mantainer-in-here"> editar </span> 
                        </span>     
                    </h1> 
                </div>
                <div class="head-div2">
                    <div class="head-div2">   
                        <span @click="postUpdate()" title="Editar" class="mantainer-btn-check-event"> <i class="far fa-check-circle"></i></span>            
                     
                        <span @click="go('/license')" title="Cancelar y volver atras" class="mantainer-btn-cancel-event"> <i class="fas fa-ban"></i></span>  
                    </div> 
                </div>     
            </div>
        </div>  
        <hr class="mantainer-divisor"/> 
        <div class="mantainer-container-table" >
            <div class="">
                <form action="" class="tm-edit-product-form">
                    <div class="row">
                        <div class="form-group col-md-8">
                            <label for="">Nombre <i class="fas fa-info-circle mantainer-info" title="Ingrese el nombre"></i></label>
                            <input type="text" class="form-control form-control-sm mantainer-input" v-model="name" name="name">
                            <span class="errors" v-if="errors && errors.name">{{errors.name[0] }}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-8">
                            <label for="">Código <i class="fas fa-info-circle mantainer-info" title="Ingrese el código"></i></label>
                            <input type="text" class="form-control form-control-sm mantainer-input" v-model="code" name="code">
                            <span class="errors" v-if="errors && errors.code">{{errors.code[0] }}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-8">
                            <label for="">Cantidad de Staff <i class="fas fa-info-circle mantainer-info" title="Ingrese el número de staff permitidos"></i></label>
                            <input type="text" class="form-control form-control-sm mantainer-input" v-model="qty_staff" name="qty_staff">
                            <span class="errors" v-if="errors && errors.qty_staff">{{errors.qty_staff[0] }}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-8">
                            <label for="">Cantidad de Usuarios <i class="fas fa-info-circle mantainer-info" title="Ingrese el número de usuarios permitidos"></i></label>
                            <input type="text" class="form-control form-control-sm mantainer-input" v-model="qty_user" name="qty_user">
                            <span class="errors" v-if="errors && errors.qty_user">{{errors.qty_user[0] }}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-8">
                            <label for="">Cantidad de Solicitudes <i class="fas fa-info-circle mantainer-info" title="Ingrese el número de solicitudes permitidas"></i></label>
                            <input type="text" class="form-control form-control-sm mantainer-input" v-model="qty_work_month" name="qty_work_month">
                            <span class="errors" v-if="errors && errors.qty_work_month">{{errors.qty_work_month[0] }}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-8">
                            <label for="">Valor <i class="fas fa-info-circle mantainer-info" title="Ingrece el valor de la licencia"></i></label>
                            <input type="text" class="form-control form-control-sm mantainer-input" v-model="value" name="value">
                            <span class="errors" v-if="errors && errors.value">{{errors.value[0] }}</span>
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
                id             : this.$route.params.id,
                csrf           : document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                errors         : {},                
                name           : "",
                code           : "",
                qty_user       : "",
                qty_staff      : "",
                qty_work_month : "",
                value          : ""
            }
        },       
        created() {             
          this.getLicense()
        },
        methods: {
            getLicense () {
                var self = this
                this.$http.get('/get-license', {params: {id: this.id}})
                .then(response => {    
                    console.log(response.body)
                    self.name           = response.body.name,
                    self.code           = response.body.code,
                    self.qty_user       = response.body.qty_user,
                    self.qty_staff      = response.body.qty_staff,
                    self.qty_work_month = response.body.qty_work_month,
                    self.value          = response.body.value 
                    self.loader = false
                }, response => {                 
                    self.$toasted.global.APP_GENERAL_ERROR()
                })
            },
            postUpdate () {
                event.preventDefault()
                this.loader = true
                var data = {
                    _token         : this.csrf,
                    id           : this.id,
                    name           : this.name,
                    code           : this.code,
                    qty_user       : this.qty_user,
                    qty_staff      : this.qty_staff,
                    qty_work_month : this.qty_work_month,
                    value          : this.value            
                }
                var self = this  
                this.$http.post('/license-update', data)
                .then(response => {
                    self.$toasted.global.APP_GENERAL_SUCCESS()
                    self.errors = {}
                    self.$router.push({ path: "/license"})
                    self.loader = false
                }, response => {                 
                    if (response.status === 422) {
                        self.$toasted.global.APP_GENERAL_ERROR_FORM()
                        self.errors = response.body.errors
                    }
                    self.loader = false
                })
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
