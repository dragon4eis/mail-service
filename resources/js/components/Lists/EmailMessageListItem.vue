<template>
    <router-link
        :to="{name:'todo-select', params:{mail_id: mail.id}}"
        class="list-group-item"
        tag="li">
        <div class="d-inline" v-text="mail.subject"></div>
        <span class="badge float-right" :class="status.class" v-text="status.label"></span>
    </router-link>
</template>

<script>
import {mail_preview} from "../../mixins";

export default {
    name: "mailer-service-email-message-list-item",
    mixins:[mail_preview],
    props: {
        mail: {
            type: Object,
            required: true
        }
    },
}
</script>

<style scoped>

</style>