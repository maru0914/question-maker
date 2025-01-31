<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-50">
            <nav class="border-b border-gray-100 bg-white">
                <!-- Primary Navigation Menu -->
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="flex h-16 justify-between">
                        <div class="flex flex-1">
                            <!-- Logo -->
                            <div class="flex shrink-0 items-center">
                                <Link :href="route('books.index')">
                                    <ApplicationLogo
                                        class="block h-9 w-auto fill-current text-gray-800"
                                    />
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div
                                class="hidden justify-between sm:flex sm:flex-1"
                            >
                                <div
                                    class="flex flex-1 space-x-8 sm:-my-px sm:ms-10"
                                >
                                    <NavLink
                                        :href="route('books.index')"
                                        :active="route().current('books.index')"
                                    >
                                        問題集
                                    </NavLink>
                                    <NavLink
                                        v-if="$page.props.auth.user"
                                        :href="route('books.create')"
                                        :active="
                                            route().current('books.create')
                                        "
                                    >
                                        問題集作成
                                    </NavLink>
                                </div>
                                <div
                                    class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex"
                                >
                                    <Dropdown
                                        class="self-center"
                                        v-if="$page.props.auth.user"
                                        align="right"
                                        width="48"
                                    >
                                        <template #trigger>
                                            <span
                                                class="inline-flex rounded-md"
                                            >
                                                <button
                                                    type="button"
                                                    class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none"
                                                >
                                                    {{
                                                        $page.props.auth.user
                                                            .username
                                                    }}

                                                    <svg
                                                        class="-me-0.5 ms-2 h-4 w-4"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 20 20"
                                                        fill="currentColor"
                                                    >
                                                        <path
                                                            fill-rule="evenodd"
                                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                            clip-rule="evenodd"
                                                        />
                                                    </svg>
                                                </button>
                                            </span>
                                        </template>

                                        <template #content>
                                            <DropdownLink
                                                :href="route('profile.edit')"
                                            >
                                                アカウント</DropdownLink
                                            >
                                            <DropdownLink
                                                :href="route('logout')"
                                                method="post"
                                                as="button"
                                            >
                                                ログアウト
                                            </DropdownLink>
                                        </template>
                                    </Dropdown>
                                    <div v-else class="flex">
                                        <NavLink :href="route('login')">
                                            ログイン</NavLink
                                        >
                                        <NavLink :href="route('register')">
                                            新規登録</NavLink
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-me-2 flex items-center sm:hidden">
                            <button
                                @click="
                                    showingNavigationDropdown =
                                        !showingNavigationDropdown
                                "
                                class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 transition duration-150 ease-in-out hover:bg-gray-100 hover:text-gray-500 focus:bg-gray-100 focus:text-gray-500 focus:outline-none"
                            >
                                <svg
                                    class="h-6 w-6"
                                    stroke="currentColor"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex':
                                                !showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex':
                                                showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div
                    :class="{
                        block: showingNavigationDropdown,
                        hidden: !showingNavigationDropdown,
                    }"
                    class="sm:hidden"
                >
                    <div class="space-y-1 pb-3 pt-2">
                        <ResponsiveNavLink
                            :href="route('books.index')"
                            :active="route().current('books.index')"
                        >
                            問題集
                        </ResponsiveNavLink>
                        <!-- Responsive Settings Options -->
                        <div v-if="$page.props.auth.user">
                            <div class="px-4">
                                <div
                                    class="text-base font-medium text-gray-800"
                                >
                                    {{ $page.props.auth.user.username }}
                                </div>
                                <div class="text-sm font-medium text-gray-500">
                                    {{ $page.props.auth.user.email }}
                                </div>
                            </div>

                            <div class="space-y-1">
                                <ResponsiveNavLink
                                    :href="route('profile.edit')"
                                >
                                    アカウント</ResponsiveNavLink
                                >
                                <ResponsiveNavLink
                                    :href="route('logout')"
                                    method="post"
                                    as="button"
                                >
                                    ログアウト
                                </ResponsiveNavLink>
                            </div>
                        </div>
                        <div v-else>
                            <div class="space-y-1">
                                <ResponsiveNavLink :href="route('login')">
                                    ログイン</ResponsiveNavLink
                                >
                                <ResponsiveNavLink :href="route('register')">
                                    新規登録</ResponsiveNavLink
                                >
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <div class="mx-auto max-w-7xl px-4 text-gray-600 sm:px-6 lg:px-8">
                <!-- Page Heading -->
                <header v-if="$slots.header" class="text-center">
                    <h2 class="py-3 text-xl font-semibold">
                        <slot name="header" />
                    </h2>
                    <p v-if="$slots.subtitle" class="mb-3">
                        <slot name="subtitle" />
                    </p>
                </header>

                <!-- Page Content -->
                <main class="pb-10 pt-3">
                    <slot />
                </main>
            </div>
        </div>
    </div>
</template>
