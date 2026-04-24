<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3'

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
})

const submit = (): void => {
    form.post('/register', {
        onFinish: () => form.reset('password', 'password_confirmation'),
    })
}
</script>

<template>
    <Head title="Register" />

    <main class="min-h-screen bg-slate-950 text-white">
        <section class="mx-auto flex min-h-screen w-full max-w-md flex-col justify-center px-6 py-12">
            <div class="mb-8">
                <p class="text-sm font-medium uppercase tracking-[0.3em] text-sky-400">
                    Livechat Platform
                </p>

                <h1 class="mt-4 text-3xl font-bold">
                    Create account
                </h1>

                <p class="mt-3 text-sm text-slate-400">
                    Start building your live chat workspace.
                </p>
            </div>

            <form
                class="space-y-5 rounded-2xl border border-white/10 bg-white/5 p-6 shadow-2xl"
                @submit.prevent="submit"
            >
                <div>
                    <label class="block text-sm font-medium text-slate-200" for="name">
                        Name
                    </label>

                    <input
                        id="name"
                        v-model="form.name"
                        class="mt-2 w-full rounded-xl border border-white/10 bg-slate-900 px-4 py-3 text-sm outline-none ring-sky-500 transition focus:ring-2"
                        type="text"
                        autocomplete="name"
                        autofocus
                    >

                    <p v-if="form.errors.name" class="mt-2 text-sm text-red-400">
                        {{ form.errors.name }}
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-200" for="email">
                        Email
                    </label>

                    <input
                        id="email"
                        v-model="form.email"
                        class="mt-2 w-full rounded-xl border border-white/10 bg-slate-900 px-4 py-3 text-sm outline-none ring-sky-500 transition focus:ring-2"
                        type="email"
                        autocomplete="username"
                    >

                    <p v-if="form.errors.email" class="mt-2 text-sm text-red-400">
                        {{ form.errors.email }}
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-200" for="password">
                        Password
                    </label>

                    <input
                        id="password"
                        v-model="form.password"
                        class="mt-2 w-full rounded-xl border border-white/10 bg-slate-900 px-4 py-3 text-sm outline-none ring-sky-500 transition focus:ring-2"
                        type="password"
                        autocomplete="new-password"
                    >

                    <p v-if="form.errors.password" class="mt-2 text-sm text-red-400">
                        {{ form.errors.password }}
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-200" for="password_confirmation">
                        Confirm password
                    </label>

                    <input
                        id="password_confirmation"
                        v-model="form.password_confirmation"
                        class="mt-2 w-full rounded-xl border border-white/10 bg-slate-900 px-4 py-3 text-sm outline-none ring-sky-500 transition focus:ring-2"
                        type="password"
                        autocomplete="new-password"
                    >
                </div>

                <button
                    class="w-full rounded-xl bg-sky-500 px-4 py-3 text-sm font-semibold text-white transition hover:bg-sky-400 disabled:cursor-not-allowed disabled:opacity-60"
                    type="submit"
                    :disabled="form.processing"
                >
                    Create account
                </button>

                <p class="text-center text-sm text-slate-400">
                    Already registered?

                    <Link class="font-medium text-sky-400 hover:text-sky-300" href="/login">
                        Log in
                    </Link>
                </p>
            </form>
        </section>
    </main>
</template>
