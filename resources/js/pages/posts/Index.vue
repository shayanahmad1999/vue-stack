<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Post, type BreadcrumbItem } from '@/types';
import { Head, Link, usePage } from '@inertiajs/vue3';
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
import { onMounted, watch } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Posts',
        href: '/posts',
    },
];

interface Flash {
  success?: string | null;
  error?: string | null;
}

onMounted(() => {
watch(() => usePage<{flash: Flash}>().props.flash, 
(flash: Flash) => {
  if(flash.success) {
    toast.success(flash.success);
    flash.success = null;
  }
}, {immediate: true});
});

defineProps<{
  posts: {
    data: Post[],
    meta: {
      current_page: number,
      last_page: number,
      per_page: number,
      total: number
    }
  }
}>();


</script>

<template>
    <Head title="Posts" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
            <div class="flex justify-end">
                <Link :href="route('posts.create')" class="text-indigo-400 hover:text-indigo-600">Create Post</Link>
            </div>
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                <Table>
                  <TableCaption>A list of your recent posts.</TableCaption>
                  <TableHeader>
                    <TableRow>
                      <TableHead class="w-[100px]">
                        S.No
                      </TableHead>
                      <TableHead>Title</TableHead>
                      <TableHead>Image</TableHead>
                      <TableHead>Content</TableHead>
                      <TableHead class="text-right">
                        Action
                      </TableHead>
                    </TableRow>
                  </TableHeader>
                  <TableBody>
                    <TableRow v-for="post in posts.data" :key="post.id">
                      <TableCell class="font-medium">
                        {{post.id}}
                      </TableCell>
                      <TableCell>{{post.title}}</TableCell>
                      <TableCell><img :src="post.image" alt="img" class="h-12 w-12 rounded object-cover"></TableCell>
                      <TableCell>{{post.content}}</TableCell>
                      <TableCell class="flex justify-end gap-2">
                        <Link :href="route('posts.edit', post.id)" class="text-indigo-400 hover:text-indigo-500">Edit</Link>
                        <Link :href="route('posts.delete', post.id)" class="text-red-400 hover:text-red-500">Delete</Link>
                      </TableCell>
                    </TableRow>
                  </TableBody>
                </Table>
                <div class="flex items-center justify-between mt-6">
              <button
                class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 dark:bg-gray-900"
                :disabled="posts.meta.current_page <= 1"
                @click="$inertia.visit(`?page=${posts.meta.current_page - 1}`)"
              >
                Previous
              </button>

              <span class="text-sm text-gray-700 dark:text-white">
                Page {{ posts.meta.current_page }} of {{ posts.meta.last_page }}
              </span>

              <button
                class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 dark:bg-gray-900"
                :disabled="posts.meta.current_page >= posts.meta.last_page"
                @click="$inertia.visit(`?page=${posts.meta.current_page + 1}`)"
              >
                Next
              </button>
            </div>
            <p class="text-sm text-gray-500 dark:text-white">
              Showing
              {{ (posts.meta.current_page - 1) * posts.meta.per_page + 1 }}
              to
              {{
                Math.min(
                  posts.meta.current_page * posts.meta.per_page,
                  posts.meta.total
                )
              }}
              of {{ posts.meta.total }} entries
            </p>
            </div>
        </div>
    </AppLayout>
</template>
