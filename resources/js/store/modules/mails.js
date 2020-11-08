import resources from "../reusable/resources";
import errors from "../reusable/errors";

export default {
    namespaced: true,
    modules: {
        errors,
        resources: resources('/api/mail')
    },
    state: {
        loading: false,
    },
    mutations: {
        setElementLoading(state, loading) {
            state.loading = loading
        },
    },
    getters: {},
    actions:{
        submit({state, commit, dispatch}, form) {
            commit('setElementLoading', true);
            let requestType = (form.id) ? "put" : "post";
            let url = `/api/mail/${(requestType === "post" ? '' : form.id)}`;
            return new Promise(((resolve, reject, ) => {
                axios[requestType](url, form)
                    .then(response => {
                        commit('clearErrors');
                        // dispatch('all');
                        console.log( response.data.resource)
                        commit(requestType === "post" ? 'addNewResource' : 'updateExistingResource', response.data.resource);
                        resolve(response);
                    })
                    .catch(error => {
                        console.error(error);
                        if (error.response.status === 422) {
                            commit('addErrors', error.response.data.errors);
                        }
                        reject(error)
                    })
                    .finally(() => {
                        commit('setElementLoading', false);
                    })
            }))
        },
    }
}