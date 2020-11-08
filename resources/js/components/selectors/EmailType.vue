<template>
    <select class="form-control custom-select" :disabled="disabled" v-model="type"
            :class="{'is-invalid': $store.getters['mails/hasError']('type')}"
            @keydown="$store.commit('mails/clearError','type')">
        <option v-for="type in types" :value="type.key" :key="type.key" v-text="type.label"></option>
    </select>
</template>

<script>
export default {
    name: "mailer-service-email-type",
    props: {
        disabled:{
            type: Boolean,
            default: false
        },
        value:{
            required: true
        },
        types: {
            type: Array,
            default(){
                return [
                    {key: "text", label: "Text"},
                    {key: "html", label: "HTML"},
                    {key: "markdown", label: "Markdown"}
                ]
            }
        }
    },
    data(){
        return {
            type: "text"
        }
    },
    mounted() {
        this.type = this.value
    },
    watch:{
        type(newValue, oldValue){
            if(newValue !== oldValue)
                this.$emit('input',newValue)
        },
        value(newValue){
            this.type = newValue
        }
    }
}
</script>

<style scoped>

</style>