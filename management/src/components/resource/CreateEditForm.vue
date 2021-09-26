<template>
    <form @submit.prevent="formSubmitHandler">
        <div class="px-4 pt-6 pb-3 bg-white space-y-2 sm:px-6">
            <label
                for="title"
                class="block text-sm font-medium text-gray-700"
                :class="{ 'text-red-500': errors.title }"
            >
                Title
            </label>
            <input
                v-model="formModel.title"
                type="text"
                name="title"
                id="title"
                autocomplete="title"
                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                :class="{ 'border-red-500': errors.title }"
            />
            <p v-if="errors.title" class="mt-2 text-sm text-red-500">
                {{ errors.title.join(",") }}
            </p>
        </div>
        <div
            v-if="operation == 'create'"
            class="px-4 py-3 bg-white space-y-2 sm:px-6"
        >
            <label
                for="type"
                class="block text-sm font-medium text-gray-700"
                :class="{ 'text-red-500': errors.type }"
            >
                Resource Type
            </label>
            <select
                v-model="formModel.type"
                id="type"
                name="type"
                autocomplete="type"
                class="block w-full px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                :class="{ 'border-red-500': errors.type }"
            >
                <option :value="null">None</option>
                <option value="pdf">PDF</option>
                <option value="html">HTML</option>
                <option value="link">LINK</option>
            </select>
            <p v-if="errors.type" class="mt-2 text-sm text-red-500">
                {{ errors.type.join(",") }}
            </p>
        </div>
        <pdf-fields 
            v-if="formModel.type == 'pdf'"
            v-model="formModel.pdf"
            :errors="errors"
            :operation="operation"
        />
        <html-fields 
            v-else-if="formModel.type == 'html'"
            v-model="formModel.html"
            :errors="errors"
        />
        <link-fields 
            v-else-if="formModel.type == 'link'"
            v-model="formModel.link"
            :errors="errors"
        />
        <div class="border-t-2 px-4 py-3 bg-gray-50 text-center sm:px-6">
            <button
                type="submit"
                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            >
                Save
            </button>
        </div>
    </form>
</template>


<script>
import PdfFields from '@/components/resource/PdfFields';
import HtmlFields from '@/components/resource/HtmlFields';
import LinkFields from '@/components/resource/LinkFields';
export default {
    name: "resource-create-edit-form",
    components: {
        PdfFields, HtmlFields, LinkFields
    },
    props: {
        operation: String,
    },
    data() {
        return {
            formModel: {
                type: null,
                pdf: {},
                html: {},
                link: {},
            },
            errors: {},
        };
    },
    mounted() {
        if (this.operation == "create") {
            this.initCreate();
        }
        if (this.operation == "edit") {
            this.initEdit();
        }
    },
    methods: {
        async initCreate() {
            //Doe something if needed on create operation
        },
        async initEdit() {
            let { data: response } = await this.axios.get(
                "/v1/manage/resources/" + this.$route.params.id
            );
            this.formModel = response.data.resource;
        },
        async formSubmitHandler() {
            if (this.operation == "create") {
                this.create();
            }
            if (this.operation == "edit") {
                this.update();
            }
        },
        prepareRequest() {
            let formData = this.formModel;
            let requestConfig = {};
            if(this.formModel.pdf && this.formModel.pdf.fileRaw){
                formData = new FormData();
                requestConfig = {
                    headers: {'content-type': 'multipart/form-data'}
                };
                this.buildFormData(formData, this.formModel);
                if(this.operation == 'edit'){
                    //because when formData is an instanceof FormData object, it cannot sent PUT/PATCH/DELETE request directly
                    formData.append('_method', 'PUT');
                }
            }else{
                if(this.operation == 'edit'){
                    formData._method = 'PUT';
                }
            }
            return {formData: formData, requestConfig: requestConfig};
        },
        async create() {
            this.errors = {};
            try {
                let {formData, requestConfig} = this.prepareRequest();
                let { data: response } = await this.axios.post(
                    "v1/manage/resources",
                    formData,
                    requestConfig
                );
                if (response.success) {
                    this.$toasted.clear();
                    this.$toasted.success(response.message);
                    this.$router.push('/');
                } else {
                    this.$toasted.clear();
                    this.$toasted.error(response.error);
                }
            } catch (error) {
                this.errors = error.response.data.error;
                this.$toasted.clear();
                this.$toasted.error("Operation Failed");
                setTimeout(() => {
                    this.$scrollTo(".border-red-500", {
                        offset: -100,
                    });
                }, 250);
            }
        },
        async update() {
            this.errors = {};
            try {
                let {formData, requestConfig} = this.prepareRequest();
                let { data: response } = await this.axios.post(
                    "v1/manage/resources/" + this.$route.params.id,
                    formData,
                    requestConfig
                );
                if (response.success) {
                    this.$toasted.clear();
                    this.$toasted.success(response.message);
                    this.$router.push('/');
                } else {
                    this.$toasted.clear();
                    this.$toasted.error(response.error);
                }
            } catch (error) {
                this.errors = error.response.data.error;
                this.$toasted.clear();
                this.$toasted.error("Operation Failed");
                setTimeout(() => {
                    this.$scrollTo(".border-red-500", {
                        offset: -100,
                    });
                }, 250);
            }
        },
        buildFormData(formData, data, parentKey) {
            if (
                data &&
                typeof data === "object" &&
                !(data instanceof Date) &&
                !(data instanceof File)
            ) {
                Object.keys(data).forEach((key) => {
                    this.buildFormData(
                        formData,
                        data[key],
                        parentKey ? `${parentKey}[${key}]` : key
                    );
                });
            } else {
                const value = data == null ? "" : data;
                formData.append(parentKey, value);
            }
        },
    },
};
</script>