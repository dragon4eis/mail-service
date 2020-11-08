<template>
    <table class="table table-striped ">
        <thead>
        <tr>
            <th scope="col">Date</th>
            <th scope="col">Resource</th>
            <th scope="col">Operation</th>
            <th scope="col">Description</th>
        </tr>
        </thead>
        <tbody>
            <mailer-service-log-row v-for="log in logs" :key="log.id" :log="log"></mailer-service-log-row>
        </tbody>
    </table>
</template>

<script>
import MailerServiceLogRow from "./rows/LogRow";
export default {
    name: "mailer-service-email-log-table",
    components: {MailerServiceLogRow},
    props: {
        logs: {
            type: Array,
            required: true
        }
    }
}
</script>

<style scoped>

</style>