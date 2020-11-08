<template>
    <div class="row justify-content-center">
        <div class="col-md-5  mb-1">
            <div class="card">
                <div class="card-header">
                    <h3 class="d-inline">Mails</h3>
                    <router-link :to="{name: 'mail-create'}"
                                 class="btn btn-success float-right"
                                 tag="button"> NEW
                    </router-link>
                </div>
                <div class="">
                    <ul class="list-group list-group-flush">
                        <mailer-service-email-message-list-item
                            v-for="mail in mails"
                            :mail="mail"
                            :key="mail.id">
                        </mailer-service-email-message-list-item>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
import MailerServiceEmailMessageListItem from "./Lists/EmailMessageListItem";

export default {
    name: "mailer-service-mail-list-page",
    components: {MailerServiceEmailMessageListItem},
    computed: {
        mails() {
            return this.$store.state.mails.resources.all || []
        }
    }
}
</script>

<style scoped>

</style>