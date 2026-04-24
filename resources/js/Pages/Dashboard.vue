<script setup lang="ts">
import { Head, router, usePage } from '@inertiajs/vue3'

type AuthUser = {
    id: number
    name: string
    email: string
}

type PageProps = {
    auth: {
        user: AuthUser | null
    }
}

const page = usePage<PageProps>()

const logout = (): void => {
    router.post('/logout')
}
</script>

<template>
    <Head title="Dashboard" />

    <main class="min-h-screen bg-slate-950 text-white">
        <section class="mx-auto w-full max-w-5xl px-6 py-10">
            <header class="flex items-center justify-between border-b border-white/10 pb-6">
                <div>
                    <p class="text-sm font-medium uppercase tracking-[0.3em] text-sky-400">
                        Livechat Platform
                    </p>

                    <h1 class="mt-3 text-3xl font-bold">
                        Dashboard
                    </h1>
                </div>

                <button
                    class="rounded-xl border border-white/10 px-4 py-2 text-sm font-medium text-slate-200 transition hover:bg-white/10"
                    type="button"
                    @click="logout"
                >
                    Log out
                </button>
            </header>

            <div class="mt-8 rounded-2xl border border-white/10 bg-white/5 p-6 shadow-2xl">
                <p class="text-sm text-slate-400">
                    Signed in as
                </p>

                <h2 class="mt-2 text-xl font-semibold">
                    {{ page.props.auth.user?.name }}
                </h2>

                <p class="mt-1 text-sm text-slate-400">
                    {{ page.props.auth.user?.email }}
                </p>
            </div>
        </section>
    </main>
</template>
