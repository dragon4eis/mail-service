<template>
    <fieldset>
        <div class="form-group row required">
            <label class="col-sm-2 col-form-label" for="subject">Subject:</label>
            <div class="col-sm-10">
                <input id="subject" v-model="mail.subject" :class="{'is-invalid': $store.getters['mails/hasError']('subject')}" :disabled="disabled"
                       class="form-control"
                       type="text"
                       placeholder="Set email subject"
                       @keydown="$store.commit('mails/clearError','subject')"/>
                <div v-if="$store.getters['mails/hasError']('subject')" class="invalid-feedback d-block">
                    <strong v-text="$store.getters['mails/getError']('subject')"></strong>
                </div>
            </div>
        </div>
        <div class="form-group row required">
            <label class="col-sm-2 col-form-label">Type:</label>
            <div class="col-sm-10">
                <mailer-service-email-type id="type" v-model="mail.type"
                                           :disabled="disabled"></mailer-service-email-type>
                <div v-if="$store.getters['mails/hasError']('type')" class="invalid-feedback d-block">
                    <strong v-text="$store.getters['mails/getError']('type')"></strong>
                </div>
            </div>
        </div>
        <div v-for="(recipient, index) in mail.recipients" :key="index" class="form-group row required">
            <label class="col-sm-2 col-form-label" for="type">To:</label>
            <div class="col-sm-10">
                <input v-model="recipient.name" :class="{'is-invalid': $store.getters['mails/hasError'](`recipients.${index}.name`)}" :disabled="disabled"
                       class="form-control"
                       type="text"
                       placeholder="Add name"
                       @keydown="$store.commit('mails/clearError',`recipients.${index}.name`)"/>
                <div v-if="$store.getters['mails/hasError'](`recipients.${index}.name`)"
                     class="invalid-feedback d-block">
                    <strong v-text="$store.getters['mails/getError'](`recipients.${index}.name`)"></strong>
                </div>
            </div>
            <div class="offset-2 col-sm-10 pt-2">
                <input v-model="recipient.address" :class="{'is-invalid': $store.getters['mails/hasError'](`recipients.${index}.address`)}" :disabled="disabled"
                       class="form-control"
                       type="text"
                       placeholder="Add email address"
                       @keydown="$store.commit('mails/clearError',`recipients.${index}.address`)"/>
                <div v-if="$store.getters['mails/hasError'](`recipients.${index}.address`)"
                     class="invalid-feedback d-block">
                    <strong
                        v-text="$store.getters['mails/getError'](`recipients.${index}.address`)"></strong>
                </div>
            </div>
        </div>
        <div class="form-group row required">
            <label class="col-sm-2 col-form-label" for="message">Message:</label>
            <div class="col-sm-10">
                            <textarea id="message" v-model="mail.message" :class="{'is-invalid': $store.getters['mails/hasError']('message')}" :disabled="disabled"
                                      class="form-control"
                                      placeholder="Type the message you want to send ..."
                                      type="text"
                                      @keydown="$store.commit('mails/clearError','subject')"/>
                <div v-if="$store.getters['mails/hasError']('message')" class="invalid-feedback d-block">
                    <strong v-text="$store.getters['mails/getError']('message')"></strong>
                </div>
            </div>
        </div>
    </fieldset>
</template>

<script>
import MailerServiceEmailType from "../selectors/EmailType";

export default {
    name: "mailer-service-create-form",
    components: {
        MailerServiceEmailType
    },
    props:{
        value: {
            required: true
        },
        disabled: {
            type: Boolean,
            default: false
        }
    },
    data(){
        return {
            mail: {
                name: "",
                address: "",
                type: "text",
                message: "",
                recipients: []
            }
        }
    },
    mounted() {
        this.mail = this.value
    },
    watch:{
        mail(newValue, oldValue){
            if(newValue !== oldValue)
                this.$emit('input',newValue)
        },
        value(newValue){
            this.mail = newValue
        }
    }
}
</script>

<style scoped>
    textarea {
        min-height: 150px;
    }
</style>