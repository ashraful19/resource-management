<template>
    <div class="block">
        <div class="px-4 py-3 bg-white space-y-2 sm:px-6">
            <label
                for="url"
                class="block text-sm font-medium text-gray-700"
                :class="{ 'text-red-500': errors['link.url'] }"
            >
                Url
            </label>
            <input
                v-model="value.url"
                type="text"
                name="url"
                id="url"
                autocomplete="url"
                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                :class="{ 'border-red-500': errors['link.url'] }"
            />
            <p v-if="errors['link.url']" class="mt-2 text-sm text-red-500">
                {{ errors["link.url"].join(",") }}
            </p>
        </div>
        <div class="flex items-start px-4 py-3 bg-white sm:px-6">
            <div class="flex items-center h-5">
                <input
                    v-model="value.new_tab"
                    id="new_tab"
                    name="new_tab"
                    type="checkbox"
                    true-value="1"
                    false-value="0"
                    class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded"
                />
            </div>
            <div class="ml-3 text-sm">
                <label
                    for="new_tab"
                    class="font-medium text-gray-700"
                    :class="{ 'text-red-500': errors['link.new_tab'] }"
                >
                    Open in New Tab
                </label>
                <p class="text-gray-500">
                    If checked, clicking this link will open in a new tab in
                    browser
                </p>
                <p
                    v-if="errors['link.new_tab']"
                    class="mt-2 text-sm text-red-500"
                >
                    {{ errors["link.new_tab"].join(",") }}
                </p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'link-fields',
    props: {
        value: {
            type: Object,
            required: true,
        },
        errors: {
            type: Object,
        },
    },
    watch: {
        value() {
            this.$emit("input", this.value);
        },
    },
}
</script>