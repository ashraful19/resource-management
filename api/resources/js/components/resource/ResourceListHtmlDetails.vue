<template>
    <div class="block">
        <p class="text-sm font-medium text-gray-900 truncate w-64 mb-2">
            {{ stripHtml(resource.html.description) }}
        </p>
        <button
            type="button"
            class="inline-flex justify-center mx-1 py-1 px-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-pink-800 hover:bg-pink-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-700"
            @click.prevent="viewSnippet(resource.html.snippet)"
        >
            View Snippet
        </button>
        <button
            type="button"
            class="inline-flex justify-center mx-1 py-1 px-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-700"
            @click.prevent="$swal({ html: resource.html.description })"
        >
            View Description
        </button>
    </div>
</template>

<script>
export default {
    name: "resource-list-html-details",
    props: {
        resource: {
            type: Object,
            required: true,
        },
    },
    methods: {
        copySnippet(snippet) {
            navigator.clipboard.writeText(snippet);
            this.$toasted.success("HTML snippet copied Successfully.");
        },
        stripHtml(html) {
            let tmp = document.createElement("div");
            tmp.innerHTML = html;
            return tmp.textContent || tmp.innerText || "";
        },
        viewSnippet(snippet) {
            this.$swal({
                html: '<pre class="bg-gray-500 text-gray-100 overflow-auto"><code>' + snippet.replaceAll('&', '&amp;').replaceAll('<', '&lt;').replaceAll('>', '&gt;') + '</code></pre>',
                showCancelButton: true,
                confirmButtonText: "Copy Snippet",
                CancelButtonText: "Close",
            }).then(async (result) => {
                if (result.isConfirmed) {
                    this.copySnippet(snippet);
                }
            });
        },
    },
};
</script>
