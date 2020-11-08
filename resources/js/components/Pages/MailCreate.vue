<template>
    <div class="card">
        <div class="card-header"><h3>Create Mail</h3></div>
        <div class="card-body">
            <mailer-service-create-form v-model="form"></mailer-service-create-form>
        </div>
        <div class="card-footer">
            <div class="btn-group float-right">
                <button class="btn btn-primary" @click="addNewRecipient">New Recipient</button>
                <button class="btn btn-success" @click="submit">Save</button>
            </div>
        </div>
    </div>
</template>

<script>
import MailerServiceCreateForm from "../Forms/CreateForm";

export default {
    name: "mailer-service-mail-create",
    components:{
        MailerServiceCreateForm
    },
    data(){
      return {
          form:{
              name: "",
              address: "",
              type: "text",
              message: "",
              recipients:  [
                  { name: "", address: ""}
              ]
          }
      }
    },
    methods:{
        submit(){
            this.$store.dispatch('mails/submit', this.form)
                .then(response => {
                    this.$root.showSuccessMsg({message: response.data.message})
                    this.form = {
                        name: "",
                        address: "",
                        type: "text",
                        message: "",
                        recipients: [
                            { name: "", address: ""}
                        ]
                    }
                })
                .catch(error => {
                    this.$root.showErrorMsg({message: error.response.data.message})
                })
        },
        addNewRecipient(){
            this.form.recipients.push({'address': 'test@example.com'})
        }
    }
}
</script>

<style scoped>

</style>