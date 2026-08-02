<script setup>
import GuestLayout from '@/Backend/Layouts/GuestLayout.vue';
import InputError from '@/Backend/Components/InputError.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const showPassword = ref(false);

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Sign In - Worldine Destinations Admin Portal" />

        <!-- Status Message Banner -->
        <div v-if="status" class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-xs font-bold text-emerald-700 flex items-center space-x-2">
            <span>✓</span>
            <span>{{ status }}</span>
        </div>

        <form @submit.prevent="submit" class="space-y-5 font-aptos">
            <!-- Email Field -->
            <div>
                <label for="email" class="block text-xs font-black uppercase tracking-wider text-slate-700 mb-1.5">
                    Email Address
                </label>

                <div class="relative rounded-2xl shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                        </svg>
                    </div>

                    <input
                        id="email"
                        type="email"
                        class="w-full pl-11 pr-4 py-3.5 bg-white border-2 border-slate-200 hover:border-slate-300 rounded-2xl text-sm font-bold text-slate-900 placeholder-slate-400 focus:border-[#2196F3] focus:ring-4 focus:ring-[#2196F3]/15 transition-all outline-none"
                        placeholder="admin@worldine.com"
                        v-model="form.email"
                        required
                        autofocus
                        autocomplete="username"
                    />
                </div>

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <!-- Password Field -->
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label for="password" class="block text-xs font-black uppercase tracking-wider text-slate-800">
                        Password
                    </label>

                    <Link
                        v-if="canResetPassword"
                        :href="route('password.request')"
                        class="text-xs font-bold text-[#2196F3] hover:text-[#0D47A1] transition-colors"
                    >
                        Forgot password?
                    </Link>
                </div>

                <div class="relative rounded-2xl shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>

                    <input
                        id="password"
                        :type="showPassword ? 'text' : 'password'"
                        class="w-full pl-11 pr-16 py-3.5 bg-white border-2 border-slate-200 hover:border-slate-300 rounded-2xl text-sm font-bold text-slate-900 placeholder-slate-400 focus:border-[#2196F3] focus:ring-4 focus:ring-[#2196F3]/15 transition-all outline-none"
                        placeholder="••••••••••••"
                        v-model="form.password"
                        required
                        autocomplete="current-password"
                    />

                    <!-- Password Toggle Button -->
                    <button 
                        type="button" 
                        @click="showPassword = !showPassword"
                        class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-500 hover:text-[#0D47A1] focus:outline-none transition-colors font-mono text-xs font-black uppercase tracking-wider"
                    >
                        {{ showPassword ? 'HIDE' : 'SHOW' }}
                    </button>
                </div>

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between pt-1">
                <label class="inline-flex items-center cursor-pointer select-none">
                    <input 
                        type="checkbox" 
                        v-model="form.remember" 
                        class="w-4 h-4 rounded text-[#2196F3] border-slate-300 focus:ring-[#2196F3]" 
                    />
                    <span class="ml-2.5 text-xs font-bold text-slate-600">
                        Remember this device for 30 days
                    </span>
                </label>
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
                <button
                    type="submit"
                    class="w-full py-4 rounded-2xl bg-gradient-to-r from-[#2196F3] via-[#2B70B4] to-[#0D47A1] text-white font-extrabold text-sm uppercase tracking-widest shadow-xl hover:shadow-2xl hover:brightness-110 active:scale-[0.99] transition-all duration-300 flex items-center justify-center space-x-2 disabled:opacity-50"
                    :disabled="form.processing"
                >
                    <span v-if="form.processing" class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></span>
                    <span>{{ form.processing ? 'Signing in...' : 'Sign In To Dashboard' }}</span>
                    <span v-if="!form.processing">→</span>
                </button>
            </div>
        </form>
    </GuestLayout>
</template>
