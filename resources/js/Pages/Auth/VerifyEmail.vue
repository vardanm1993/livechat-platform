<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import AuthShell from '@/Components/Auth/AuthShell.vue';

defineProps<{
  message?: string | null;
}>();

const verificationForm = useForm({});
const logoutForm = useForm({});

const resendVerification = (): void => {
  verificationForm.post('/email/verification-notification');
};

const logout = (): void => {
  logoutForm.post('/logout');
};
</script>

<template>
  <Head title="Verify Email" />

  <AuthShell
    title="Verify Email"
    heading="Verify your email"
    description="Before using trusted communication features, verify the email address connected to your account."
  >
    <div
      v-if="message"
      class="mb-6 rounded-xl border border-sky-500/30 bg-sky-500/10 px-4 py-3 text-sm text-sky-200"
    >
      {{ message }}
    </div>

    <div class="space-y-5">
      <button
        type="button"
        :disabled="verificationForm.processing"
        class="w-full rounded-xl bg-sky-400 px-4 py-3 text-sm font-semibold text-slate-950 transition hover:bg-sky-300 disabled:cursor-not-allowed disabled:opacity-70"
        @click="resendVerification"
      >
        Send verification link
      </button>

      <button
        type="button"
        :disabled="logoutForm.processing"
        class="w-full rounded-xl border border-slate-700 px-4 py-3 text-sm font-semibold text-slate-200 transition hover:border-slate-500 hover:bg-slate-800 disabled:cursor-not-allowed disabled:opacity-70"
        @click="logout"
      >
        Sign out
      </button>
    </div>
  </AuthShell>
</template>
