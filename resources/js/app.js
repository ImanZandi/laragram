/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('post-page', require('./pages/PostPage.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',

    methods: {

        /*
        // @uploaded attr in view
        uploaded(data) {
            // data == response from PostsController , record of saved image in db
            console.log(data); // Object { path: "images/CwmQbvr9S6JaK1hTqUfJORGb9yfdG6FWvNcZ3KsF.jpeg", updated_at: "2019-10-06 16:22:31", created_at: "2019-10-06 16:22:31", id: 6 }

        } */
    }
});
