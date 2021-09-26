<template>
    <div class="block">
        <button
            @click.prevent="downloadPdf(resource)"
            type="button"
            class="inline-flex justify-center py-1 px-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-600"
        >
            Download
        </button>
    </div>
</template>

<script>
export default {
    name: "resource-list-pdf-details",
    props: {
        resource: {
            type: Object,
            required: true,
        },
    },
    methods: {
        downloadPdf(resource) {
            this.axios
                .get("/v1/manage/resources/" + resource.id + "/pdf-download", {
                    responseType: "arraybuffer",
                })
                .then((response) => {
                    let url = window.URL.createObjectURL(
                        new Blob([response.data], { type: "application/pdf" })
                    );
                    let link = document.createElement("a");
                    link.href = url;
                    link.setAttribute("download", resource.title + ".pdf"); //or any other extension
                    document.body.appendChild(link);
                    link.click();
                    link.remove();
                })
                .catch((error) => {
                    console.log(error);
                    this.$toasted.error("Download Failed");
                });
        },        
    },
}
</script>