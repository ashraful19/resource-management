<template>
    <div class="block">
        <div class="px-4 py-3 bg-white space-y-2 sm:px-6">
            <label
                for="description"
                class="block text-sm font-medium text-gray-700"
                :class="{ 'text-red-500': errors['html.description'] }"
            >
                Description
            </label>
            <div class="mt-1">
                <quill-editor
                    v-model="value.description"
                    :options="editorOption"
                    class="h-64 mb-12"
                />
                <!-- <textarea
                    v-model="value.description"
                    id="description"
                    name="description"
                    rows="3"
                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md"
                    :class="{
                        'border-red-500': errors['html.description'],
                    }"
                ></textarea> -->
            </div>
            <p
                v-if="errors['html.description']"
                class="mt-2 text-sm text-red-500"
            >
                {{ errors["html.description"].join(",") }}
            </p>
        </div>
        <div class="px-4 py-3 bg-white space-y-2 sm:px-6">
            <label
                for="snippet"
                class="block text-sm font-medium text-gray-700"
                :class="{ 'text-red-500': errors['html.snippet'] }"
            >
                Snippet
            </label>
            <div class="mt-1">
                <AceEditor
                    v-model="value.snippet"
                    @init="editorInit"
                    lang="html"
                    theme="monokai"
                    width="100%"
                    height="300px"
                    :options="{
                        enableBasicAutocompletion: true,
                        enableLiveAutocompletion: true,
                        fontSize: 14,
                        highlightActiveLine: true,
                        enableSnippets: true,
                        showLineNumbers: true,
                        tabSize: 2,
                        showPrintMargin: false,
                        showGutter: true,
                    }"
                    :commands="[
                        {
                            name: 'save',
                            bindKey: { win: 'Ctrl-s', mac: 'Command-s' },
                            exec: dataSumit,
                            readOnly: true,
                        },
                    ]"
                />
            </div>
            <p v-if="errors['html.snippet']" class="mt-2 text-sm text-red-500">
                {{ errors["html.snippet"].join(",") }}
            </p>
        </div>
    </div>
</template>

<script>
import AceEditor from "vuejs-ace-editor";
import { quillEditor } from 'vue-quill-editor';
import 'quill/dist/quill.core.css';
import 'quill/dist/quill.snow.css';
import 'quill/dist/quill.bubble.css';
export default {
    name: "html-fields",
    props: {
        value: {
            type: Object,
            required: true,
        },
        errors: {
            type: Object,
        },
    },
    components: {
        AceEditor, quillEditor
    },
    data() {
        return {
            editorOption: {
                modules: {
                    toolbar: [
                        ["bold", "italic", "underline"],
                        ["blockquote"],
                        [{ list: "ordered" }, { list: "bullet" }],
                        [{ header: [1, 2, 3, 4, 5, 6, false] }],
                        [{ color: [] }, { background: [] }],
                        [{ align: [] }],
                        ["clean"],
                        ["link"],
                    ],
                },
            }
        }
    },
    methods: {
        dataSumit() {
            //code here
        },
        editorInit: function () {
            require("brace/ext/language_tools"); //language extension prerequsite...
            require("brace/mode/html");
            require("brace/theme/monokai");
        },
    },
    watch: {
        value() {
            this.$emit("input", this.value);
        },
    },
};
</script>