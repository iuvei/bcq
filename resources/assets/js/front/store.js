import Vue from 'vue';
import Vuex from 'vuex';
Vue.use(Vuex);

const state = {
    user_info : '',
    mail_count : 0
};

const mutations = {
    authCheck(state, payload){
        state.user_info = payload.user_info;
    },
    resetName(state, payload){
        state.user_info.username = payload.username;
    },
    mailCheck(state,payload){
        state.mail_count = payload.mail_count;
    }
}

export default new Vuex.Store({
    state,
    mutations
});