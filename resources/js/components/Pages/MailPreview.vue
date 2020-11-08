<template>
    <div class="card">
        <div class="card-header"><h3>Preview</h3></div>
        <div class="card-body">
            <div v-if="loading" class="text-center text-muted">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <template v-else-if="mail">

                <h4>
                    <span class="d-inline" v-text="mail.subject"></span>
                    <span :class="status.class" class="badge float-right" v-text="status.label"></span>
                </h4>

                <mailer-service-create-form v-model="mail" :disabled="true"></mailer-service-create-form>

                <template v-if="mail.logs">
                    <h5>Logs</h5>
                    <mailer-service-email-log-table :logs="mail.logs"></mailer-service-email-log-table>
                </template>

            </template>
        </div>
    </div>
</template>

<script>
import {mail_preview} from "../../mixins";
import MailerServiceEmailLogTable from "../Tables/EmailLogTable";
import MailerServiceCreateForm from "../Forms/CreateForm";

let loadCancel;

export default {
    name: "mailer-service-mail-preview",
    components: {MailerServiceCreateForm, MailerServiceEmailLogTable},
    mixins: [mail_preview],
    props: {
        mail_id: {
            required: true
        }
    },
    data() {
        return {
            loading: false,
            mail: {}
        }
    },
    methods: {
        loadItem() {
            this.loading = true;
            if (loadCancel) {
                loadCancel.cancel('canceling previous request and making a new one...');
            }
            loadCancel = axios.CancelToken.source();
            void axios
                .get(`/api/mail/${this.mail_id}`, {cancelToken: loadCancel.token})
                .then(response => {
                    this.mail = response.data.data;
                })
                .catch(console.error)
                .finally(() => {
                    this.loading = false;
                })

        }
    },
    mounted() {
        this.loadItem()
    },
    watch: {
        mail_id(new_id, old) {
            if (new_id !== old) {
                this.loadItem();
            }
        }
    }
}
</script>

<style scoped>

</style>