/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

// window.Vue = require('vue');

import Vue from 'vue';
import Vuetify from 'vuetify';
import 'vuetify/dist/vuetify.min.css';
import colors from 'vuetify/es5/util/colors';
import { Emoji, Picker } from 'emoji-mart-vue'

Vue.use(Vuetify, {
    theme: {
        primary: colors.teal.darken1,
        secondary: colors.red.lighten1,
        accent: colors.amber.base,
        disabled: colors.grey.base,
    },
});

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('emoji', Emoji);
Vue.component('emoji-picker', Picker);
Vue.component('side-nav',            require('./components/SideNav.vue').default);
Vue.component('loading',             require('./components/Loading.vue').default);
Vue.component('emotion-popper',      require('./components/EmotionPopper.vue').default);
Vue.component('month-selector',      require('./components/MonthSelector.vue').default);
Vue.component('sub-team-form-modal', require('./components/SubTeamFormModal.vue').default);
Vue.component('sub-team-user-list',  require('./components/SubTeamUserList.vue').default);
Vue.component('team-user-me',        require('./components/TeamUserMe.vue').default);
Vue.component('not-joined-sub-team-list', require('./components/NotJoinedSubTeamList.vue').default);

Vue.component('sub-team-info-modal',  require('./components/SubTeams/SettingModal.vue').default);
Vue.component('sub-team-emotion-calendar-table',  require('./components/SubTeams/EmotionCalendarTable.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app'
});