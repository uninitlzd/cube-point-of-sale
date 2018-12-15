<template>
    <router-view></router-view>
</template>

<script>

    export default {
        name: "App",
        created() {

        },
        mounted() {
            this.$on('offline', () => {
                this.$alert('This is a message', 'Title')
            })
        }
    }
</script>

<style scoped>

</style>
