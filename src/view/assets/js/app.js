import Vue from 'vue';
import Hello from './components/Hello';
import UserProfile from './components/UserProfile';

new Vue({
    el: '.v-hello',
    components: {Hello}
});

new Vue({
    el: '.v-user-profile',
    components: {UserProfile}
});