import {modules, home} from "./config";
import Vue from 'vue';
import VueRouter from 'vue-router';
import App from "../components/App";

Vue.use(VueRouter);

const routes = [
    {
        path: '/',
        name: 'app-home',
        redirect: home,
        component: App,
        children:[
            ... modules,
            {
                path: '*',
                redirect: home
            }
        ]
    }
]


export default new VueRouter({
    routes,
    linkActiveClass: 'active',
    linkExactActiveClass: 'active'
})
