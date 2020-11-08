import Vue from 'vue';
import Vuex from 'vuex';
// import {modules} from "./config";

Vue.use(Vuex);

const files = require.context('./modules', true, /\.js$/i);

export const modules = files.keys().reduce((modules, file) => {
    const id = file
        .split('/')
        .pop()
        .split('.')[0];
    modules[id] = files(file).default;
    return modules
}, {})

export default new Vuex.Store({
    strict: process.env.NODE_ENV !== 'production',
    modules
})
