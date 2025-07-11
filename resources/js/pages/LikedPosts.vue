<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { Post, type BreadcrumbItem } from '@/types'
import { Head, router } from '@inertiajs/vue3'

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Liked Posts',
        href: '/liked-posts',
    },
]

const props = defineProps<{
    posts: Post[]
}>()

</script>

<template>

    <Head title="Liked Posts" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div v-for="post in props.posts" :key="post.id"
                class="border rounded-xl p-4 bg-white dark:bg-gray-800 dark:border-gray-700 shadow-sm">
                <div class="flex items-center mb-2">
                    <div
                        class="h-10 w-10 rounded-full bg-gray-300 dark:bg-neutral-700 flex items-center justify-center text-white font-bold">
                        {{ post?.user?.name.charAt(0).toUpperCase() }}
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">
                            {{ post?.user?.name }}
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
                    <svg class="w-6 h-6 text-red-500 fill-red-500" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5
                            2 5.42 4.42 3 7.5 3c1.74 0 3.41 0.81 4.5 2.09
                            C13.09 3.81 14.76 3 16.5 3
                            19.58 3 22 5.42 22 8.5
                            c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                    </svg>
                    <span class="text-sm text-gray-600 dark:text-gray-300">{{ post.likes_count }}</span>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
