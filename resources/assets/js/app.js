/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

let store = {
    debug: true,
    state: {
        user: {}
    },
    setUserAction(newUser) {
        if (this.debug) console.log('setUserAction triggered with ', newUser);
        this.state.user = newUser;
    }
};

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import VoerroTagsInput from '@voerro/vue-tagsinput';

Vue.component('tags-input', VoerroTagsInput);

Vue.component('add-video', require('./components/AddVideoComponent.vue'));
Vue.component('nav-bar', require('./components/NavBarComponent.vue'));
Vue.component('add-missing-video', require('./components/AddMissingVideoComponent.vue'));
Vue.component('categorize-form', require('./components/CategorizeFormComponent.vue'));
/*Vue.component('check-url', require('./components/CheckUrlComponent.vue'));
Vue.component('found-video-from-url', require('./components/FoundVideoFromUrlComponent.vue'));
Vue.component('url-not-found', require('./components/UrlNotFoundComponent.vue'));*/

const app = new Vue({
    el: '#app',
    data() {
        return {
            store: store
        }
    },
});
