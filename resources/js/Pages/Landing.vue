<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';

const productName = 'Livechat Platform';
</script>

<template>
  <Head title="Trusted realtime communication foundation" />

  <main class="min-h-screen bg-slate-950 text-slate-100">
    <section class="mx-auto flex min-h-screen w-full max-w-5xl flex-col justify-center px-6 py-16">
      <p class="text-sm font-semibold uppercase tracking-[0.35em] text-sky-400">
        {{ productName }}
      </p>

      <h1 class="mt-6 max-w-3xl text-4xl font-semibold tracking-tight text-white md:text-6xl">
        Trusted realtime communication foundation.
      </h1>

      <p class="mt-6 max-w-2xl text-base leading-8 text-slate-300">
        A Laravel, Inertia, and Vue foundation for secure messaging, groups, realtime
        collaboration, verification, password recovery, and security event tracking.
      </p>

      <div class="mt-10 flex flex-wrap gap-3">
        <Link
          href="/register"
          class="rounded-xl bg-sky-400 px-5 py-3 text-sm font-semibold text-slate-950 transition hover:bg-sky-300"
        >
          Create account
        </Link>

        <Link
          href="/login"
          class="rounded-xl border border-slate-700 px-5 py-3 text-sm font-semibold text-slate-200 transition hover:border-slate-500 hover:bg-slate-900"
        >
          Sign in
        </Link>
      </div>
    </section>
  </main>
</template>
