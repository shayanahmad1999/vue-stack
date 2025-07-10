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
  posts: Post[],
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
                    <TableRow v-for="post in posts" :key="post.id">
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
            </div>
        </div>
    </AppLayout>
</template>
