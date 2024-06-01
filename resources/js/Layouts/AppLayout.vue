<script setup>
import {ref} from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import {Link} from '@inertiajs/vue3';

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-50">
            <nav class="bg-white border-b border-gray-200 shadow-sm">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <Link :href="route('books.index')">
                                    <ApplicationLogo class="block h-9 w-auto fill-current text-gray-800"/>
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden sm:flex sm:space-x-8 ml-10">
                                <NavLink :href="route('books.index')" :active="route().current('books.index')">
                                    問題集
                                </NavLink>
                                <NavLink v-if="$page.props.auth.user" :href="route('books.create')"
                                         :active="route().current('books.create')">
                                    問題集作成
                                </NavLink>
                            </div>
                        </div>

                        <!-- Settings Dropdown -->
                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                            <Dropdown v-if="$page.props.auth.user" align="right" width="48">
                                <template #trigger>
                                    <button
                                        class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 focus:outline-none transition duration-150 ease-in-out">
                                        {{ $page.props.auth.user.username }}
                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                             viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </button>
                                </template>
                                <template #content>
                                    <DropdownLink :href="route('profile.edit')">アカウント</DropdownLink>
                                    <DropdownLink :href="route('logout')" method="post" as="button">
                                        ログアウト
                                    </DropdownLink>
                                </template>
                            </Dropdown>
                            <div v-else class="flex space-x-8">
                                <NavLink :href="route('login')">ログイン</NavLink>
                                <NavLink :href="route('register')">新規登録</NavLink>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-mr-2 flex items-center sm:hidden">
                            <button @click="showingNavigationDropdown = !showingNavigationDropdown"
                                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none transition duration-150 ease-in-out">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path
                                        :class="{'hidden': showingNavigationDropdown, 'inline-flex': !showingNavigationDropdown}"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"/>
                                    <path
                                        :class="{'hidden': !showingNavigationDropdown, 'inline-flex': showingNavigationDropdown}"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{ 'block': showingNavigationDropdown, 'hidden': !showingNavigationDropdown }"
                     class="sm:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink :href="route('books.index')" :active="route().current('books.index')">
                            問題集
                        </ResponsiveNavLink>
                    </div>
                    <div v-if="$page.props.auth.user" class="pt-4 pb-1 border-t border-gray-200">
                        <div class="px-4">
                            <div class="font-medium text-base text-gray-800">{{ $page.props.auth.user.username }}</div>
                            <div class="font-medium text-sm text-gray-500">{{ $page.props.auth.user.email }}</div>
                        </div>
                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('profile.edit')">アカウント</ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('logout')" method="post" as="button">ログアウト
                            </ResponsiveNavLink>
                        </div>
                    </div>
                    <div v-else class="pt-4 pb-1 border-t border-gray-200">
                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('login')">ログイン</ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('register')">新規登録</ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-gray-600">
                <!-- Page Heading -->
                <header v-if="$slots.header" class="text-center">
                    <h2 class="py-3 font-semibold text-xl">
                        <slot name="header"/>
                    </h2>
                    <p v-if="$slots.subtitle" class="mb-3">
                        <slot name="subtitle"/>
                    </p>
                </header>

                <!-- Page Content -->
                <main class="pt-3 pb-10">
                    <slot/>
                </main>
            </div>
        </div>
    </div>
</template>
