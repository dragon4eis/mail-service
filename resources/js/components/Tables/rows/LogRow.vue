<template>
    <tr>
        <th scope="row" v-text="log.created_at"></th>
        <td v-text="log.recourse"></td>
        <td v-text="log.operation"></td>
        <td class="description" :title="log.description">
            <span v-text="log.description" ></span>
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
    td.description {
        width: 150px;
        max-width: 300px;
    }
</style>