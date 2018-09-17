window.Vue = require('vue');
Vue.component('laravel_gallery_system', require('./components/laravel_gallery_system/gallery/laravel_gallery_system.vue'));
window.onload = function () {
    const gallery = new Vue({
        el: '#gallery',
    });
}