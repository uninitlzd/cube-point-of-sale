<template>
    <dashboard-shell>
        <el-col :span="24" class="pr-0">
            <el-scrollbar class="h-100 scrollbar-component">
                <el-row type="flex">
                    <el-col :span="24" class="px-4 py-4">
                        <h2>Material</h2>
                    </el-col>
                </el-row>
            </el-scrollbar>
        </el-col>
    </dashboard-shell>
</template>

<script>
    import DashboardShell from "../DashboardShell";
    export default {
        name: "Material",
        components: {DashboardShell}
    }
</script>

<style scoped>

</style>
