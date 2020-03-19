
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import * as VueGoogleMaps from 'vue2-google-maps';
// import VueRouter from 'vue-router'

// Vue.use(VueRouter)

Vue.use(VueGoogleMaps, {
    load: {
      key: 'AIzaSyCheUi_teeeCbBHW3niSAj3QaTvJgTNTRk',
      libraries: 'places', // This is required if you use the Autocomplete plugin

    },
  })



/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('gmap-component', require('./components/MapComponent.vue').default);
Vue.component('sidebar-component', require('./components/SidebarComponent.vue').default);
Vue.component('list-component', require('./components/AdminListLocationComponent.vue').default);

// import App from './components/AdminListLocationComponent.vue';

// import Map from './components/AdminMapComponent.vue';
// import Location from './components/AdminLocationComponent.vue'

// // Vue router
// const router = new VueRouter({
//     mode: 'history',
//     routes: [
//         {
//             path: '/',
//             name: 'map',
//             component: Map
//         },
//         {
//             path: '/location',
//             name: 'location',
//             component: Location,
//         },
//     ],
// });

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
const app = new Vue({
    el: '#warder',
    
    // components: { Map,Location },
    // router,

    data() {
        return {
            items:['login','register'],
            initialization:'login',
            mapPosition:'',
            locationInfo:null,
            images:null,
            comments:null,
            actionForm:false,
            locationId:999,
            locationMarker:null,
            locationNew:[],
            newMarker:false,
        }
    },
    methods: {
        insertPosition: function(e) {
            this.actionForm = false;
            
            axios
            .get('/images/'+e)
            .then(data => (this.images = data['data']));
            axios
            .get('/location/'+e)
            .then(data => (this.locationInfo = data['data']));
            axios
            .get('/comments/'+e)
            .then(data => (this.comments = data['data']));
            
        },
        openForm:function(e) {
            this.mapPosition = e;
            this.actionForm = true;
        },
        addNewLocation:function(e) {
            this.newMarker = false;
            this.locationNew.push(e);
            $('.sidebar').removeClass('active');
        },
        task:function() {
        },
        removeData: function(e) {
            
            $.ajax({
                url:"/user/"+e,
                type:"delete",
                success: function(){
                    
                    $('.sidebar').removeClass('active');
                }
            });
            this.locationMarker = this.locationInfo.marker;
        },
        revLocation: function(e) {
            this.locationId = e;
        },
        insertForm: function(){
            this.actionForm = true;
        },
        actForm:function(e) {
            this.actionForm = false;
            if(e == true) {
                this.newMarker = true;
            }
        },
        removeMark:function() {
            this.newMarker = false;
        }
    },
    watch: {
        locationId: function() {
            $('.removeButton').click();
        }
    }
});
// const app2 = new Vue({
//     el:'#admin',
//     data() {
//         return{
//             'data':'log'
//         }
//     }
// });
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
