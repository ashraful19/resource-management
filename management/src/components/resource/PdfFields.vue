<template>
    <div class="block">
        <div class="px-4 py-3 bg-white space-y-2 sm:px-6">
            <label class="block text-sm font-medium text-gray-700">
                PDF File
            </label>
            <div
                class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md"
                :class="{ 'border-red-500': errors['pdf.fileRaw'] }"
                @drop.prevent="pdfFileDropped"
                @dragover.prevent
            >
                <div class="space-y-1 text-center">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="mx-auto h-12 w-12 text-gray-400"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z"
                            clip-rule="evenodd"
                        />
                    </svg>
                    <div class="flex text-sm text-gray-600">
                        <label
                            for="file-upload"
                            class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500"
                        >
                            <span>Upload a file</span>
                            <input
                                ref="pdfFileInput"
                                id="file-upload"
                                name="file-upload"
                                type="file"
                                class="sr-only"
                                @change="pdfFileChanged"
                            />
                        </label>
                        <p class="pl-1">or drag and drop</p>
                        <p v-if="operation == 'edit'" class="pl-1 text-red-500">
                            to replace the previous file
                        </p>
                    </div>
                    <p class="text-xs text-gray-500">PDF up to 10MB</p>
                    <p
                        v-if="value.fileRaw"
                        class="text-sm text-purple-500 text-bold border-2 rounded-lg inline-flex justify-between pl-2"
                    >
                        {{ value.fileRaw.name }}
                        <button
                            @click.prevent="removeSelectedPdf"
                            type="button"
                            class="ml-2 px-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                        </button>
                    </p>
                </div>
            </div>
            <p v-if="errors['pdf.fileRaw']" class="mt-2 text-sm text-red-500">
                {{ errors["pdf.fileRaw"].join(",") }}
            </p>
        </div>
    </div>
</template>

<script>
export default {
    name: 'pdf-fields',
    props: {
        value: {
            type: Object,
            required: true,
        },
        errors: {
            type: Object,
        },
        operation: {
            type: String,
            required: true,
        },
    },
    methods: {
        pdfFileChanged(e) {
            this.$set(this.value, "fileRaw", e.target.files[0]);
        },
        pdfFileDropped(e) {
            this.$set(this.value, "fileRaw", e.dataTransfer.files[0]);
        },
        removeSelectedPdf() {
            this.$set(this.value, "fileRaw", null);
            this.$refs.pdfFileInput.value = null;
        },
    },
    watch: {
        value() {
            this.$emit("input", this.value);
        },
    },
}
</script>