<template>
    <div id="app">
        <default-header></default-header>
        <page-header v-if="!noPageHeader"></page-header>
        <main class="shadow">
            <transition name="fade" mode="out-in">
                <router-view></router-view>
            </transition>
        </main>
        <default-footer></default-footer>
    </div>
</template>

<script>
import DefaultHeader from "@/components/layout/DefaultHeader";
import PageHeader from "@/components/layout/PageHeader";
import DefaultFooter from "@/components/layout/DefaultFooter";
export default {
    name: "App",
    components: {
        DefaultHeader,
        PageHeader,
        DefaultFooter,
    },
    computed: {
        noPageHeader(){
            return this.$route.meta.noPageHeader || !this.$route.meta.title;
        }
    },
};
</script>

<style>
    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s
    }

    .fade-enter, .fade-leave-active {
        opacity: 0
    }
</style>