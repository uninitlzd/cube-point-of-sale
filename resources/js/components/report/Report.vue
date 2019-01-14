<template>
    <dashboard-shell>
        <el-col :span="24" class="pr-0">
            <el-scrollbar class="h-100 scrollbar-component">
                <el-row type="flex">
                    <el-col :span="24" class="px-4 py-4">
                        <h2>Report</h2>
                        <bars
                                :data="[{value: 0, title: ''}, {value: 1, title: 'test1'}, {value: 5, title: 'test5'}, {value: 2, title: 'test2'}, {value: 1, title: 'test1'}]"
                                :gradient="['#ffbe88', '#ff93df']"
                                :barWidth="5"
                                :growDuration="1">
                        </bars>
                    </el-col>
                </el-row>
            </el-scrollbar>
        </el-col>
    </dashboard-shell>
</template>

<script>
    import DashboardShell from "../DashboardShell";
    export default {
        name: "Report",
        components: {DashboardShell}
    }
</script>

<style scoped>

</style>
