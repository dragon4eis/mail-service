<template>
    <tr>
        <th scope="row" v-text="log.created_at"></th>
        <td v-text="log.recourse"></td>
        <td v-text="log.operation"></td>
        <td :title="log.description"  v-text="log.description">
        </td>
    </tr>
</template>

<script>
export default {
    name: "mailer-service-log-row",
    props: {
        log: {
            type: Object,
            required: true
        }
    }
}
</script>

<style scoped>
</style>