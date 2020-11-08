import Vue from 'vue';

export default {
    state() {
        return {
            errors: {}
        }
    },
    getters: {
        hasErrors(state) {
            return Object.keys(state.errors).length !== 0
        },
        hasError(state) {
            return function (name) {
                return state.errors.hasOwnProperty(name)
            }
        },
        getError(state) {
            return function (name) {
                return state.errors[name].join(' ')
            }
        }
    },
    mutations: {
        addErrors(state, errors) {
            state.errors = errors
        },
        addError(state, [name, message]) {
            if (!state.errors.hasOwnProperty(name)) {
                state.errors[name] = []
            }
            state.errors[name].push(message)
        },
        clearErrors(state) {
            state.errors = {}
        },
        clearError(state, name) {
            Vue.delete(state.errors, name)
        }
    }
}
