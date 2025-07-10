<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Post, User, UserFilter, type BreadcrumbItem } from '@/types';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { toast } from 'vue-sonner'

import {
    Table,
    TableBody,
    TableCaption,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table'
import { onMounted, ref, watch } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Users',
        href: '/users',
    },
];

interface Flash {
    success?: string | null;
    error?: string | null;
}

onMounted(() => {
    watch(() => usePage<{ flash: Flash }>().props.flash,
        (flash: Flash) => {
            if (flash.success) {
                toast.success(flash.success);
                flash.success = null;
            }
        }, { immediate: true });
});

const props = defineProps<{
    users: {
        data: User[],
        meta: {
            current_page: number,
            last_page: number,
            per_page: number,
            total: number
        }
    },
    filters?: {
        search?: string,
    }
}>();

const search = ref(props.filters?.search || '');

const applyFilters = () => {
    router.get(route('users.index'), {
        search: search.value,
    }, {
        preserveScroll: true,
        preserveState: true,
        replace: true
    });
};

const resetFilters = () => {
    search.value = '';
    applyFilters();
};

</script>

<template>

    <Head title="Users" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
            <div class="flex justify-end">
                <Link :href="route('users.create')" class="text-indigo-400 hover:text-indigo-600">Create User</Link>
            </div>
            <div
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                <div class="flex items-center gap-4 mb-4 mt-4 p-3">
                    <input v-model="search" type="text" placeholder="Search by name, email"
                        class="px-3 py-2 border rounded w-1/2 dark:bg-gray-800 dark:text-white" />

                    <button @click="applyFilters"
                        class="px-4 py-2 bg-indigo-500 text-white rounded hover:bg-indigo-600">
                        Apply
                    </button>
                    <button @click="resetFilters"
                        class="ml-2 px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 dark:bg-yellow-600 dark:text-white">
                        Reset
                    </button>

                </div>

                <Table>
                    <TableCaption>A list of your recent users.</TableCaption>
                    <TableHeader>
                        <TableRow>
                            <TableHead class="w-[100px]">
                                S.No
                            </TableHead>
                            <TableHead>Name</TableHead>
                            <TableHead>Email</TableHead>
                            <TableHead class="text-right">
                                Action
                            </TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="user in users.data" :key="user.id">
                            <TableCell class="font-medium">
                                {{ user.id }}
                            </TableCell>
                            <TableCell>{{ user.name }}</TableCell>
                            <TableCell>{{ user.email }}</TableCell>
                            <TableCell class="flex justify-end gap-2">
                                <Link :href="route('users.edit', user.id)"
                                    class="text-indigo-400 hover:text-indigo-500">Edit</Link>
                                <Link :href="route('users.delete', user.id)" class="text-red-400 hover:text-red-500">
                                Delete</Link>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
                <div class="flex items-center justify-between mt-6">
                    <button class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 dark:bg-gray-900"
                        :disabled="users.meta.current_page <= 1"
                        @click="$inertia.visit(`?page=${users.meta.current_page - 1}`)">
                        Previous
                    </button>

                    <span class="text-sm text-gray-700 dark:text-white">
                        Page {{ users.meta.current_page }} of {{ users.meta.last_page }}
                    </span>

                    <button class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 dark:bg-gray-900"
                        :disabled="users.meta.current_page >= users.meta.last_page"
                        @click="$inertia.visit(`?page=${users.meta.current_page + 1}`)">
                        Next
                    </button>
                </div>
                <p class="text-sm text-gray-500 dark:text-white">
                    Showing
                    {{ (users.meta.current_page - 1) * users.meta.per_page + 1 }}
                    to
                    {{
                        Math.min(
                            users.meta.current_page * users.meta.per_page,
                            users.meta.total
                        )
                    }}
                    of {{ users.meta.total }} entries
                </p>
            </div>
        </div>
    </AppLayout>
</template>
