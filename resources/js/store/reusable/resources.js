import axios from 'axios';
import Vue from 'vue';

export default function (urlAddress) {
    return {
        state() {
            return {
                all: [],
                isAllLoading: false
            }
        },
        mutations: {
            SET_ALL(state, newDataSet) {
                state.all = newDataSet
            },
            SET_LOADING_RESOURCE(state, newState) {
                state.isAllLoading = newState
            },
            ADD_NEW_RESOURCE(state, newResource) {
                state.all.unshift(newResource)
            },
            UPDATE_EXISTING_RESOURCE(state, resource){
                state.all.forEach((original, index) => {
                    if (resource.id === original.id) {
                        Vue.set(state.all, index, resource)
                    }
                })
            }
        },
        actions: {
            all({commit}, search_name = "") {
                commit('SET_LOADING_RESOURCE', true);
                return axios
                    .get(urlAddress,  {params: {search_name}})
                    .then(response => commit('SET_ALL', response.data.data))
                    .catch(console.error)
                    .finally(() => commit('SET_LOADING_RESOURCE', false))
            }
        }
    }
}
