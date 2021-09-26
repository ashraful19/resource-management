<template>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0 md:grid md:grid-cols-4">
            <div
                class="col-span-2 col-start-2 border-4 border-solid border-gray-200 rounded-lg shadow sm:rounded-md"
            >
                <create-form
                    operation="create"
                />
            </div>
        </div>
    </div>
</template>

<script>
import CreateForm from '@/components/resource/CreateEditForm';
export default {
    name: 'resource-create',
    components: {
        CreateForm
    },
    data() {
        return {
            
        };
    },
};
</script>