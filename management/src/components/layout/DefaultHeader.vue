<template>
    <nav class="bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <router-link to="/">
                            <img
                                class="h-16 w-16"
                                src="@/assets/images/logo.png"
                                alt="Logo"
                            />
                        </router-link>
                    </div>
                    <div class="md:block hidden ml-10 flex items-baseline space-x-4">
                        <router-link to="/">
                            <h2 class="text-white font-bold text-2xl">Resource Management</h2>
                        </router-link>
                    </div>
                </div>

                <div class="ml-4 flex items-center md:ml-6">
                    <router-link
                        :to="{ name: 'home' }"
                        class="bg-gray-900 text-white px-3 py-2 rounded-md text-sm font-bold mx-1"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 inline"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                clip-rule="evenodd"
                            />
                        </svg>
                        Home
                    </router-link>
                    <router-link
                        :to="{ name: 'create' }"
                        class="bg-purple-600 text-white hover:bg-purple-800 hover:text-white px-3 py-2 rounded-md text-sm font-bold mx-1"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 inline"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                clip-rule="evenodd"
                            />
                        </svg>
                        Create New
                    </router-link>
                </div>
            </div>
        </div>
    </nav>
</template>