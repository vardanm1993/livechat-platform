<script setup lang="ts">
interface Props {
    eyebrow?: string;
    title: string;
    lead: string;
}

defineProps<Props>();
</script>

<template>
    <div class="relative overflow-hidden">
        <div
            class="absolute inset-x-0 top-0 -z-10 h-64 bg-[radial-gradient(circle_at_top,rgba(83,155,245,0.18),transparent_60%)]"/>

        <main class="mx-auto flex min-h-screen max-w-6xl flex-col px-6 py-10 lg:px-10 lg:py-14">
            <header class="flex items-center justify-between border-b border-black/6 pb-6">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.32em] text-brand-700/80">
                        {{ eyebrow ?? 'Application Foundation' }}
                    </p>
                    <h1 class="mt-3 max-w-3xl text-4xl font-semibold tracking-tight text-balance sm:text-5xl">
                        {{ title }}
                    </h1>
                    <p class="mt-4 max-w-2xl text-base leading-7 text-gray-600 sm:text-lg">
                        {{ lead }}
                    </p>
                </div>

                <div
                    class="hidden rounded-full border border-black/8 bg-white/80 px-4 py-2 text-sm font-medium text-gray-600 shadow-sm backdrop-blur md:block">
                    Production-minded frontend baseline
                </div>
            </header>

            <section class="flex-1 py-8">
                <slot/>
            </section>
        </main>
    </div>
</template>
