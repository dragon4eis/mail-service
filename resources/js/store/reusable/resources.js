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
            setAll(state, newDataSet) {
                state.all = newDataSet
            },
            setLoadingResource(state, newState) {
                state.isAllLoading = newState
            },
            addNewResource(state, newResource) {
                state.all.unshift(newResource)
            },
            updateExistingResource(state, resource){
                state.all.forEach((original, index) => {
                    if (resource.id === original.id) {
                        Vue.set(state.all, index, resource)
                    }
                })
            }
        },
        actions: {
            all({commit}, search_name = "") {
                commit('setLoadingResource', true);
                return axios
                    .get(urlAddress,  {params: {search_name}})
                    .then(response => commit('setAll', response.data.data))
                    .catch(console.error)
                    .finally(() => commit('setLoadingResource', false))
            }
        }
    }
}
