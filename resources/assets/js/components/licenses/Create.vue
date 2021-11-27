<template>
    <div class="mantainer">   
        <div v-if="loader" class="loader"></div>      
        <div class="">
            <div class="head">       
                <div class="head-div1">
                    <h1 class="mantainer-title">
                        Ingresar nueva licencia<br>
                        <span class="mantainer-navegation">               
                            <span @click="go('/home')"  title="Volver a inicio"><i class="fas fa-home mantainer-btn-navigation"></i></span>
                             /  
                            <span @click="go('/staff')" class="mantainer-pointer"> licencias </span> 
                             /  
                            <span class="mantainer-in-here"> ingresar </span> 
                        </span>     
                    </h1> 
                </div>
                <div class="head-div2">
                    <div class="head-div2">   
                        <span @click="postCreate()" title="Ingresar" class="mantainer-btn-check-event"> <i class="far fa-check-circle"></i></span>            
                        <span @click="go('/staff')" title="Cancelar y volver atras" class="mantainer-btn-cancel-event"> <i class="fas fa-ban"></i></span>  
                    </div> 
                </div>     
            </div>
        </div>   
        <hr class="mantainer-divisor"/>
        <div class="mantainer-container-table" >
            <div class="">
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
    </div>  
</template>
<script>
    import Utilities from '../mixins/Utilities.js'
    export default {
        name   : 'create',
        mixins : [ Utilities],
        data() {
            return {
                csrf         : document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                errors       : {},
                name           : "",
                code           : "",
                qty_user       : "",
                qty_staff      : "",
                qty_work_month : "",
                value          : ""
            }
        },
        created() {
            this.loader = false
        },
        methods: {
            postCreate() {
                this.loader = true
                event.preventDefault()
                var data = {
                    _token: this.csrf,
                    name           : this.name,
                    code           : this.code,
                    qty_user       : this.qty_user,
                    qty_staff      : this.qty_staff,
                    qty_work_month : this.qty_work_month,
                    value          : this.value  
                }
                var self = this
                this.$http.post('/license-store', data)
                    .then(response => {                        
                        self.$toasted.global.APP_GENERAL_SUCCESS()
                        self.errors = {}
                        self.loader = false
                        self.$router.push({
                            path: "/license"
                        })
                    }, response => {
                        if (response.status === 422) {
                            self.$toasted.global.APP_GENERAL_ERROR_FORM()
                            self.errors = response.body.errors
                        } else {
                            self.$toasted.global.APP_GENERAL_ERROR()
                        }
                        self.loader = false
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
    .simple-root {
        margin-top: 20%;
        margin-left: auto;
        margin-right: auto;
    }    
    .help.is-danger {
        color: red;
    }    
    .form-control.is-danger {
        border: 1px solid red;
    }
    .submit { 
        display: grid; 
        grid-template-columns: repeat(2, 1fr); 
        grid-template-rows: 1fr; 
        grid-column-gap: 0px;
        grid-row-gap: 0px; 
    }
    .div1 { grid-area: 1 / 1 / 2 / 2; } 
    .div2 { grid-area: 1 / 2 / 2 / 3; margin-top:0px!important} 
      
</style>
@endsection