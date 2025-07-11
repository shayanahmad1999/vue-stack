<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Post, type BreadcrumbItem } from '@/types';
import { Head, router } from '@inertiajs/vue3';
import { HeartIcon } from 'lucide-vue-next';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

const props = defineProps<{
    posts: Post[]
}>();

function toggleLike(post: Post) {
    router.post(
        `/posts/${post.id}/like`,
        {},
        {
            preserveScroll: true,
            onSuccess: (page) => {
                const updated = page?.props?.posts?.find((p: Post) => p.id === post.id)
                Object.assign(post, updated)
            },
        }
    )
}

</script>

<template>

    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div v-for="post in props.posts" :key="post.id"
                    class="border rounded-xl p-4 bg-white dark:bg-gray-800 dark:border-gray-700 shadow-sm">
                    <div class="flex items-center mb-2">
                        <div
                            class="h-10 w-10 rounded-full bg-gray-300 dark:bg-neutral-700 flex items-center justify-center text-white font-bold">
                            {{ post.user?.name?.charAt(0).toUpperCase() }}
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ post.user?.name }}
                            </p>
                        </div>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-1">
                        {{ post.title }}
                    </h3>
                    <p class="text-gray-800 dark:text-gray-200 mb-3">
                        {{ post.content }}
                    </p>
                    <div class="mt-3 flex items-center gap-1">
                        <button @click="toggleLike(post)" class="focus:outline-none">
                            <HeartIcon class="h-6 w-6 transition"
                                :class="post.liked ? 'text-red-500 fill-red-500' : 'text-gray-400'" />
                        </button>
                        <span class="text-sm text-gray-600 dark:text-gray-300">{{ post.likes_count }}</span>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
