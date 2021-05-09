require('./bootstrap');

window.Vue = require('vue').default;

const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('main-content', require('./components/MainContent.vue').default);
Vue.component('message-input', require('./components/MessageInput.vue').default);
Vue.component('message', require('./components/Message.vue').default);

const app = new Vue({
    el: '#app',
});
