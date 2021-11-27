<template>
    <nav class="navbar navbar-expand-xl">
            <div class="container h-100">
                 <router-link to="/home">
                    <a class="navbar-brand" href="#">
                        <div class="grid-logo">
                            <div class="grid-logo-div1">
                                <img src="/dolar.png" width="50" heght="50" alt="">
                            </div>
                            <div class="grid-logo-div2">
                                <h1 class="tm-site-title mb-0">
                            <span class="title-nav">
                                RAPITIPS
                            </span><br>
                            <span class="subtitle-nav">
                                Gestión de propinas
                            </span>
                        </h1>
                            </div>
                        </div>                       
                    </a>
                </router-link>                
                <button class="navbar-toggler ml-auto mr-0" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars tm-nav-icon"></i>
                </button>
                <div class="collapse navbar-collapse nav-font" id="navbarSupportedContent">
                    <ul class="navbar-nav mx-auto h-100">
                        <li class="nav-item">
                            <router-link to="/home">
                                <a v-if="link_active == 'home'" class="nav-link active" href="#">
                                    <i class="fas fa-tachometer-alt"></i>
                                    Inicio                                   
                                </a>
                                <a v-else class="nav-link" href="#" @click="changeLink('home')">
                                    <i class="fas fa-tachometer-alt"></i>
                                    Inicio                                   
                                </a>
                            </router-link>                            
                        </li>
                        
                        <li v-if="license_allowed.tip_work_allow.status"  class="nav-item">
                            <router-link to="/tips">
                                <a v-if="link_active == 'tips'" class="nav-link active" href="#">
                                    <i class="fas fa-hand-holding-usd"></i>
                                    Propinas
                                </a>
                                <a v-else class="nav-link" href="#"  @click="changeLink('tips')">
                                    <i class="fas fa-hand-holding-usd"></i>
                                    Propinas
                                </a>
                            </router-link>
                        </li>
                        <li v-else class="nav-item" >
                            <a title="Has alcanzado el límite de trabajos mensuales a realizar según tu licencia." class="nav-link" href="#">
                                <i class="fas fa-exclamation"></i>
                                Propinas
                            </a>                              
                        </li>

                        <li class="nav-item">
                            <router-link to="/staff">                               
                                <a v-if="link_active == 'staff'" class="nav-link active" href="#">
                                    <i class="fas fa-users"></i>
                                    Staff
                                </a>
                                <a v-else class="nav-link" href="#"  @click="changeLink('staff')">
                                    <i class="fas fa-users"></i>
                                    Staff
                                </a>
                            </router-link>
                        </li>                
                        
                        <li v-if="access_to_menu == 'true'" class="nav-item dropdown">
                            <a v-if="link_active == 'settings'" class="nav-link dropdown-toggle active" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-cog"></i>
                                <span>
                                    Configuración <i class="fas fa-angle-down"></i>
                                </span>
                            </a>
                            <a  v-else @click="changeLink('settings')" class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-cog"></i>
                                <span>
                                    Configuración <i class="fas fa-angle-down"></i>
                                </span>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">                              
                                <router-link to="/company">
                                    <a class="nav-link" href="#">                                      
                                        Bares
                                    </a>
                                </router-link>
                                <router-link to="/license">
                                    <a class="nav-link" href="#">                                      
                                        Licencias
                                    </a>
                                </router-link>
                            </div>
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                          <li class="nav-item">                           
                                <a class="nav-link" href="#" @click="logOut()">
                                    <i class="fas fa-power-off" ></i>
                                    Salir
                                </a>                            
                        </li>                       
                    </ul>
                </div>
            </div>
        </nav>
</template>
<script>
import Access    from '../components/mixins/Access.js';
import Utilities from '../components/mixins/Utilities.js'

    export default {
        name   : 'Nav',
        mixins : [Access, Utilities],
        data() {
            return {
                csrf: document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
                link_active: JSON.parse(localStorage.getItem("current_page")) ? JSON.parse(localStorage.getItem("current_page")).link : 'home'    
           }
        },
        created() {           
        },
        mounted () {
        },
        methods: {
            logOut () {   
                var data = {
                    _token : this.csrf
                }
                this.$http.post('/log-out', data)
                .then( response => {
                     window.location.href = window.location.origin
                }, response => {
                     self.$toasted.global.APP_GENERAL_ERROR()
                })
            }
            
        },
        filters: {
           
        }
    }
</script>
<style>
.grid-logo { 
    display: grid; 
    grid-template-columns: 0.1 1fr; 
    grid-template-rows: 1fr; 
    grid-column-gap: 0px;
    grid-row-gap: 0px; 
}

.grid-logo-div1 { grid-area: 1 / 1 / 2 / 2;} 
.grid-logo-div2 { grid-area: 1 / 2 / 2 / 3; } 
.navbar{
    background-color: #323f4f!important;
}

</style>