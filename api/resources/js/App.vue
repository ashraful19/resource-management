<template>
    <div>
        <default-header></default-header>
        <page-header></page-header>
        <main class="shadow">
            <transition name="fade" mode="out-in">
                <router-view></router-view>
            </transition>
        </main>
        <default-footer></default-footer>
    </div>
</template>

<script>
import DefaultHeader from "./components/layout/DefaultHeader";
import PageHeader from "./components/layout/PageHeader";
import DefaultFooter from "./components/layout/DefaultFooter";
export default {
    name: 'App',
    components: {
        DefaultHeader,
        PageHeader,
        DefaultFooter,
    },
    data() {
        return {};
    },
    computed: {},
    methods: {},
};
</script>

<style>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.5s;
}

.fade-enter,
.fade-leave-active {
    opacity: 0;
}
</style>