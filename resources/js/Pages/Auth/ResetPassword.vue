<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import AuthShell from '@/Components/Auth/AuthShell.vue';

const props = defineProps<{
  token: string;
  email?: string | null;
}>();

const form = useForm({
  token: props.token,
  email: props.email ?? '',
  password: '',
  password_confirmation: '',
});

const submit = (): void => {
  form.post('/reset-password', {
    onFinish: () => {
      form.password = '';
      form.password_confirmation = '';
    },
  });
};
</script>

<template>
  <Head title="Set New Password" />

  <AuthShell
    title="Set New Password"
    heading="Set a new password"
    description="Choose a new password for your account."
  >
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
          New password
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
          Confirm new password
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
        Reset password
      </button>
    </form>
  </AuthShell>
</template>
