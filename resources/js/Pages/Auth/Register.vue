<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthShell from '@/Components/Auth/AuthShell.vue';

const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
});

const submit = (): void => {
  form.post('/register', {
    onFinish: () => {
      form.password = '';
      form.password_confirmation = '';
    },
  });
};
</script>

<template>
  <Head title="Create Account" />

  <AuthShell
    title="Create Account"
    heading="Create your account"
    description="Start with a secure account foundation for trusted realtime communication."
  >
    <form class="space-y-5" @submit.prevent="submit">
      <div>
        <label for="name" class="block text-sm font-medium text-slate-200">
          Name
        </label>
        <input
          id="name"
          v-model="form.name"
          name="name"
          type="text"
          required
          autofocus
          autocomplete="name"
          class="mt-2 block w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-white outline-none transition focus:border-sky-400 focus:ring-2 focus:ring-sky-400/20"
        >
        <p v-if="form.errors.name" class="mt-2 text-sm text-red-300">
          {{ form.errors.name }}
        </p>
      </div>

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
          autocomplete="new-password"
          class="mt-2 block w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-white outline-none transition focus:border-sky-400 focus:ring-2 focus:ring-sky-400/20"
        >
        <p v-if="form.errors.password" class="mt-2 text-sm text-red-300">
          {{ form.errors.password }}
        </p>
      </div>

      <div>
        <label for="password_confirmation" class="block text-sm font-medium text-slate-200">
          Confirm password
        </label>
        <input
          id="password_confirmation"
          v-model="form.password_confirmation"
          name="password_confirmation"
          type="password"
          required
          autocomplete="new-password"
          class="mt-2 block w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-white outline-none transition focus:border-sky-400 focus:ring-2 focus:ring-sky-400/20"
        >
      </div>

      <button
        type="submit"
        :disabled="form.processing"
        class="w-full rounded-xl bg-sky-400 px-4 py-3 text-sm font-semibold text-slate-950 transition hover:bg-sky-300 disabled:cursor-not-allowed disabled:opacity-70"
      >
        Create account
      </button>

      <p class="text-center text-sm text-slate-400">
        Already have an account?
        <Link href="/login" class="font-medium text-sky-300 hover:text-sky-200">
          Sign in
        </Link>
      </p>
    </form>
  </AuthShell>
</template>
