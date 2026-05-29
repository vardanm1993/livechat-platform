<script setup lang="ts">
defineProps<{
  title: string;
  heading: string;
  description?: string;
}>();
</script>

<template>
  <main class="flex min-h-screen items-center justify-center bg-slate-950 px-6 py-12 text-slate-100">
    <section class="w-full max-w-md rounded-2xl border border-slate-800 bg-slate-900/80 p-8 shadow-2xl shadow-black/30">
      <div class="mb-8">
        <p class="text-sm font-semibold uppercase tracking-[0.3em] text-sky-400">
          Livechat Platform
        </p>

        <h1 class="mt-3 text-2xl font-semibold tracking-tight text-white">
          {{ heading }}
        </h1>

        <p
          v-if="description"
          class="mt-3 text-sm leading-6 text-slate-400"
        >
          {{ description }}
        </p>
      </div>

      <slot />
    </section>
  </main>
</template>
