require('./bootstrap')

window.Vue = require('vue')
window.VueResource = require('vue-resource')

/**
 * Para modales dinamicos
 */
import VModal from 'vue-js-modal'
 
Vue.use(VModal)
Vue.use(VModal, { dialog: true })


 /**
 * Uso de filtro para formado de moneda en campos requeridos
 */
    import VueCurrencyFilter from 'vue-currency-filter'
    Vue.use(VueCurrencyFilter,
        {
          symbol : '$',
          thousandsSeparator: '.',
          fractionCount: 0,
          fractionSeparator: '',
          symbolPosition: 'front',
          symbolSpacing: true
        })

/**Uso de libreria toast para alertas */
    import Toasted from 'vue-toasted';
    Vue.use(Toasted)
    Vue.toasted.register('APP_GENERAL_ERROR', 'Algo a salido mal. Vuelva a intentarlo.', {
        type : 'error',
        icon : 'Error',
        duration: 3000,
        singleton: true
    })
    Vue.toasted.register('APP_GENERAL_ERROR_FORM', 'Errores en el llenado del formulario', {
        type : 'error',
        icon : 'Error',
        duration: 3000,
        singleton: true
    })
    Vue.toasted.register('APP_GENERAL_SUCCESS', 'Operación realizada con exito.', {
        type : 'success',
        icon : 'Bien',
        duration: 3000,
        singleton: false
    })

/** Uso de vue-table-2 para la creación de tablas dinamicas*/
    import {ServerTable, ClientTable, Event} from 'vue-tables-2';
    Vue.use(ClientTable, {}, false, 'bootstrap4');

    import { rutValidator, rutFilter, rutInputDirective } from 'vue-dni';
    Vue.directive('rut', rutInputDirective);

/*PARA MENSAJES INTERACTIVOS */
    import VueSweetalert2 from 'vue-sweetalert2';
 
    // If you don't need the styles, do not connect
     
    Vue.use(VueSweetalert2);

/** Uso de vue-route para el enrutamiento de vistas 
 * con esto pretendo quitar el trabajo a los controladores
 * de laravel sobre las tareas de ruteo de vistas.
 * */    
    
        Vue.component('app', require('./master/AppComponent'))
        Vue.component('app-footer', require('./master/FooterComponent')) 
        Vue.component('app-nav', require('./master/NavComponent')) 
        Vue.component('modal-list', require('./master/ModalListComponent')) 

        import router from './router'

        
    const app = new Vue({
        router,
        el: '#app'
    })