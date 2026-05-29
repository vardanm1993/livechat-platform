<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthShell from '@/Components/Auth/AuthShell.vue';

defineProps<{
  status?: string | null;
}>();

const form = useForm({
  email: '',
  password: '',
});

const submit = (): void => {
  form.post('/login', {
    onFinish: () => {
      form.password = '';
    },
  });
};
</script>

<template>
  <Head title="Sign In" />

  <AuthShell
    title="Sign In"
    heading="Sign in"
    description="Access your secure communication workspace."
  >
    <div
      v-if="status"
      class="mb-6 rounded-xl border border-emerald-500/30 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-200"
    >
      {{ status }}
    </div>

    <form class="space-y-5" @submit.prevent="submit">
      <div>
        <label for="email" class="block text-sm font-medium text-slate-200">
          Email address
        </label>
        <input
          id="email"
          v-model="form.email"
          name="email"
          type="email"
          required
          autofocus
          autocomplete="email"
          class="mt-2 block w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-white outline-none transition focus:border-sky-400 focus:ring-2 focus:ring-sky-400/20"
        >
        <p v-if="form.errors.email" class="mt-2 text-sm text-red-300">
          {{ form.errors.email }}
        </p>
      </div>

      <div>
        <label for="password" class="block text-sm font-medium text-slate-200">
          Password
        </label>
        <input
          id="password"
          v-model="form.password"
          name="password"
          type="password"
          required
          autocomplete="current-password"
          class="mt-2 block w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-white outline-none transition focus:border-sky-400 focus:ring-2 focus:ring-sky-400/20"
        >
        <p v-if="form.errors.password" class="mt-2 text-sm text-red-300">
          {{ form.errors.password }}
        </p>
      </div>

      <div class="text-sm">
        <Link href="/forgot-password" class="font-medium text-sky-300 hover:text-sky-200">
          Forgot password?
        </Link>
      </div>

      <button
        type="submit"
        :disabled="form.processing"
        class="w-full rounded-xl bg-sky-400 px-4 py-3 text-sm font-semibold text-slate-950 transition hover:bg-sky-300 disabled:cursor-not-allowed disabled:opacity-70"
      >
        Sign in
      </button>

      <p class="text-center text-sm text-slate-400">
        New here?
        <Link href="/register" class="font-medium text-sky-300 hover:text-sky-200">
          Create an account
        </Link>
      </p>
    </form>
  </AuthShell>
</template>
