<template>
<div>
    <NavBar />
    <router-view v-slot="{ Component }">
        <component :is="Component" />
    </router-view>
</div>
</template>

<script>
import NavBar from "./components/NavBar.vue";

export default {
    data() {
        return {};
    },
    components: {
        NavBar
    }
};
</script>

<style>
</style>

