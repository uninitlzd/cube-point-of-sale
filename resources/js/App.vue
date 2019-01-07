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
                this.$alert('Please check your internet connection', 'You are offline!')
            })
        }
    }
</script>

<style scoped>

</style>
