<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { User, UserForm, type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import InputError from '@/components/InputError.vue';
import { LoaderCircle } from 'lucide-vue-next';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Create User',
        href: '/users',
    },
];

const { currentUser } = defineProps<{
    currentUser: User;
}>();

const form = useForm<UserForm>({
    name: currentUser.name,
    email: currentUser.email,
    password: '',
    _method: 'put'
});

const submit = () => {
    form.post(route('users.update', currentUser.id));
};

</script>

<template>

    <Head title="Create User" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
            <div class="flex justify-end">
                <Link :href="route('posts.index')" class="text-indigo-400 hover:text-indigo-600">View Posts</Link>
            </div>
            <div class="min-w-md mx-auto p-6 mt-8 shadow-lg rounded-2xl bg-white dark:bg-slate-950">
                <form @submit.prevent="submit" class="flex flex-col gap-6">
                    <div class="grid gap-6">

                        <div class="grid gap-2">
                            <Label for="name">Name</Label>
                            <Input id="name" type="name" autofocus :tabindex="1" autocomplete="name" v-model="form.name"
                                placeholder="Name..." />
                            <InputError :message="form.errors.name" />
                        </div>

                        <div class="grid gap-2">
                            <Label for="email">Email</Label>
                            <Input id="email" type="email" autofocus :tabindex="2" autocomplete="email"
                                v-model="form.email" placeholder="abc@example.com" />
                            <InputError :message="form.errors.email" />
                        </div>

                        <div class="grid gap-2">
                            <Label for="password">Password</Label>
                            <Input id="password" type="password" autofocus :tabindex="3" autocomplete="password"
                                v-model="form.password" placeholder="password" />
                            <InputError :message="form.errors.password" />
                        </div>

                        <Button type="submit" class="mt-4 w-full" :tabindex="4" :disabled="form.processing">
                            <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                            Update User
                        </Button>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
