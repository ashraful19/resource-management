<template>
    <div class="block">
        <p class="text-gray-600 mb-2">{{ resource.link.url }}</p>
        <a
            :href="resource.link.url"
            :target="resource.link.new_tab ? '_blank' : '_self'"
            class="inline-flex justify-center py-1 px-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
        >
            Open Link
        </a>
    </div>
</template>

<script>
export default {
    name: "resource-list-link-details",
    props: {
        resource: {
            type: Object,
            required: true,
        },
    },
}
</script>