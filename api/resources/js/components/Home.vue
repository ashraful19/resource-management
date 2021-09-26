<template>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div
                    class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8"
                >
                    <div
                        class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg"
                    >
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Title
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Type
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Details
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Created At
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr
                                    v-for="(resource, index) in resources"
                                    :key="resource.id"
                                >
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="ml-4">
                                                <div
                                                    class="text-sm font-medium text-gray-900"
                                                >
                                                    {{ resource.title }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800"
                                        >
                                            {{ resource.type.toUpperCase() }}
                                        </span>
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"
                                    >
                                        <resource-list-pdf-details v-if="resource.type == 'pdf'" :resource="resource "/>
                                        <resource-list-html-details v-else-if="resource.type == 'html'" :resource="resource "/>
                                        <resource-list-link-details v-else-if="resource.type == 'link'" :resource="resource "/>
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm font-medium"
                                    >
                                        {{ resource.created_at }}
                                    </td>
                                </tr>
                                <!-- More people... -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ResourceListHtmlDetails from './resource/ResourceListHtmlDetails.vue';
import ResourceListPdfDetails from './resource/ResourceListPdfDetails.vue';
import ResourceListLinkDetails from './resource/ResourceListLinkDetails.vue';
export default {
    name: "Home",
    components: {
        ResourceListHtmlDetails, ResourceListPdfDetails, ResourceListLinkDetails
    },
    data() {
        return {
            resources: [],
        };
    },
    created() {
        this.loadResources();
    },
    methods: {
        async loadResources() {
            try {
                let { data: response } = await this.axios.get(
                    "v1/manage/resources"
                );
                this.resources = response.data.resources;
            } catch (error) {
                this.$toasted.error("Failed loading Resources");
                console.log(error);
            }
        },
    },
};
</script>

