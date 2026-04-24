<script setup lang="ts">
import type {PageProps} from '@inertiajs/core';
import {Head, usePage} from '@inertiajs/vue3';

import AppShell from '@/Layouts/AppShell.vue';
import type {SharedPageProps} from '@/Types/app';

interface HomeProps extends PageProps, SharedPageProps {
    stats: {
        stack: string[];
        pillars: string[];
    };
}

const page = usePage<HomeProps>();
</script>

<template>
    <Head title="Home"/>

    <AppShell
        eyebrow="Livechat Platform"
        title="Frontend foundation built for scale, not just for first render."
        lead="Laravel, Inertia, Vue 3, TypeScript, and Vite are now wired together with shared page data, lazy page resolution, and a cleaner application shell."
    >
        <div class="grid gap-6 lg:grid-cols-[1.4fr_0.9fr]">
            <section
                class="rounded-3xl border border-black/6 bg-white/85 p-6 shadow-[0_24px_80px_-48px_rgba(15,23,42,0.35)] backdrop-blur">
                <div class="flex items-center justify-between gap-4 border-b border-black/6 pb-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Application</p>
                        <p class="mt-1 text-2xl font-semibold tracking-tight">{{ page.props.app.name }}</p>
                    </div>

                    <div class="rounded-full bg-brand-50 px-3 py-1 text-sm font-medium text-brand-700">
                        {{ page.props.app.locale.toUpperCase() }}
                    </div>
                </div>

                <div class="mt-6 grid gap-5 sm:grid-cols-2">
                    <article class="rounded-2xl bg-surface-50 p-5">
                        <p class="text-sm font-medium text-gray-500">Core stack</p>
                        <ul class="mt-4 space-y-3">
                            <li
                                v-for="item in page.props.stats.stack"
                                :key="item"
                                class="flex items-center gap-3 text-sm font-medium text-gray-700"
                            >
                                <span class="h-2.5 w-2.5 rounded-full bg-brand-500"/>
                                {{ item }}
                            </li>
                        </ul>
                    </article>

                    <article class="rounded-2xl bg-ink-950 p-5 text-white">
                        <p class="text-sm font-medium text-white/65">Foundation pillars</p>
                        <ul class="mt-4 space-y-3">
                            <li
                                v-for="item in page.props.stats.pillars"
                                :key="item"
                                class="text-sm font-medium text-white/90"
                            >
                                {{ item }}
                            </li>
                        </ul>
                    </article>
                </div>
            </section>

            <aside class="space-y-6">
                <section class="rounded-3xl border border-black/6 bg-white/80 p-6 shadow-sm backdrop-blur">
                    <p class="text-sm font-medium text-gray-500">Shared page data</p>
                    <p class="mt-3 text-sm leading-7 text-gray-600">
                        Global app context and authenticated user data are available through Inertia middleware, so new
                        pages start from a consistent contract.
                    </p>
                </section>

                <section class="rounded-3xl border border-black/6 bg-white/80 p-6 shadow-sm backdrop-blur">
                    <p class="text-sm font-medium text-gray-500">Next baseline</p>
                    <p class="mt-3 text-sm leading-7 text-gray-600">
                        This structure is ready for dedicated layouts, composables, services, form flows, and feature
                        modules without reworking the entry point.
                    </p>
                </section>
            </aside>
        </div>
    </AppShell>
</template>
