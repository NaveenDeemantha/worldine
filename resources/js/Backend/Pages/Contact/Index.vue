<script setup>
import { ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Backend/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    settings: {
        type: Object,
        default: () => ({})
    }
});

const form = useForm({
    hero_badge: props.settings.hero_badge || '',
    hero_title: props.settings.hero_title || '',
    hero_subtitle: props.settings.hero_subtitle || '',
    primary_phone: props.settings.primary_phone || '',
    outbound_phone: props.settings.outbound_phone || '',
    inbound_phone: props.settings.inbound_phone || '',
    primary_email: props.settings.primary_email || '',
    tours_email: props.settings.tours_email || '',
    office_address: props.settings.office_address || '',
    office_hours_weekday: props.settings.office_hours_weekday || '',
    office_hours_saturday: props.settings.office_hours_saturday || '',
    office_hours_sunday: props.settings.office_hours_sunday || '',
    google_maps_url: props.settings.google_maps_url || '',
    form_title: props.settings.form_title || '',
    form_subtitle: props.settings.form_subtitle || '',
});

const successMessage = ref('');

const submitSettings = () => {
    form.put(route('admin.contact.update'), {
        preserveScroll: true,
        onSuccess: () => {
            successMessage.value = 'Contact Page content successfully updated!';
            setTimeout(() => {
                successMessage.value = '';
            }, 4000);
        }
    });
};
</script>

<template>
    <Head title="Contact Page Content Editor - Admin Panel" />

    <AuthenticatedLayout>
        <div class="space-y-6 max-w-6xl mx-auto font-aptos">
            
            <!-- HEADER BAR -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
                <div>
                    <span class="text-xs font-black uppercase tracking-wider text-[#0D47A1]">CMS CONTENT MANAGEMENT</span>
                    <h1 class="text-2xl sm:text-3xl font-black text-slate-900 mt-0.5">Contact Page Settings</h1>
                    <p class="text-xs sm:text-sm text-slate-500 font-medium mt-1">
                        Edit phone hotlines, emails, office address, opening hours, and banner text displayed on the public Contact Us page.
                    </p>
                </div>
                
                <a 
                    href="/contact" 
                    target="_blank"
                    class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition-all flex items-center space-x-2 self-start sm:self-auto border border-slate-200"
                >
                    <span>👁️</span>
                    <span>Preview Live Page →</span>
                </a>
            </div>

            <!-- SUCCESS FEEDBACK TOAST -->
            <div v-if="successMessage" class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-900 font-bold text-xs flex items-center justify-between animate-fade-in">
                <div class="flex items-center space-x-2">
                    <span class="w-5 h-5 rounded-full bg-emerald-500 text-white flex items-center justify-center text-xs font-black">✓</span>
                    <span>{{ successMessage }}</span>
                </div>
                <button @click="successMessage = ''" class="text-emerald-700 font-extrabold text-sm">✕</button>
            </div>

            <!-- MAIN FORM CONTAINER -->
            <form @submit.prevent="submitSettings" class="space-y-6">
                
                <!-- SECTION 1: HERO BANNER TEXT -->
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 space-y-4">
                    <div class="border-b border-slate-100 pb-3">
                        <h2 class="text-lg font-black text-slate-900">1. Hero Banner Content</h2>
                        <p class="text-xs text-slate-500 font-medium">Text displayed in the main top banner of the Contact page.</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                                Top Badge Text
                            </label>
                            <input 
                                v-model="form.hero_badge"
                                type="text"
                                required
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:border-[#0D47A1] focus:ring-2 focus:ring-[#0D47A1]/20 text-xs font-medium text-slate-900 outline-none"
                            />
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                                Main Heading Title
                            </label>
                            <input 
                                v-model="form.hero_title"
                                type="text"
                                required
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:border-[#0D47A1] focus:ring-2 focus:ring-[#0D47A1]/20 text-xs font-medium text-slate-900 outline-none"
                            />
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                            Banner Subtitle / Description
                        </label>
                        <textarea 
                            v-model="form.hero_subtitle"
                            required
                            rows="2"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:border-[#0D47A1] focus:ring-2 focus:ring-[#0D47A1]/20 text-xs font-medium text-slate-900 outline-none"
                        ></textarea>
                    </div>
                </div>

                <!-- SECTION 2: PHONE HOTLINES & EMAIL SUPPORT -->
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 space-y-4">
                    <div class="border-b border-slate-100 pb-3">
                        <h2 class="text-lg font-black text-slate-900">2. Phone Hotlines & Email Channels</h2>
                        <p class="text-xs text-slate-500 font-medium">Contact phone numbers and email addresses.</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                                Primary Phone / WhatsApp
                            </label>
                            <input 
                                v-model="form.primary_phone"
                                type="text"
                                required
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:border-[#0D47A1] focus:ring-2 focus:ring-[#0D47A1]/20 text-xs font-medium text-slate-900 outline-none"
                            />
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                                Outbound Expeditions Phone
                            </label>
                            <input 
                                v-model="form.outbound_phone"
                                type="text"
                                required
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:border-[#0D47A1] focus:ring-2 focus:ring-[#0D47A1]/20 text-xs font-medium text-slate-900 outline-none"
                            />
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                                Inbound Sri Lanka Phone
                            </label>
                            <input 
                                v-model="form.inbound_phone"
                                type="text"
                                required
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:border-[#0D47A1] focus:ring-2 focus:ring-[#0D47A1]/20 text-xs font-medium text-slate-900 outline-none"
                            />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                                General Support Email
                            </label>
                            <input 
                                v-model="form.primary_email"
                                type="email"
                                required
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:border-[#0D47A1] focus:ring-2 focus:ring-[#0D47A1]/20 text-xs font-medium text-slate-900 outline-none"
                            />
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                                Tour Quotations Email
                            </label>
                            <input 
                                v-model="form.tours_email"
                                type="email"
                                required
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:border-[#0D47A1] focus:ring-2 focus:ring-[#0D47A1]/20 text-xs font-medium text-slate-900 outline-none"
                            />
                        </div>
                    </div>
                </div>

                <!-- SECTION 3: OFFICE ADDRESS & HOURS -->
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 space-y-4">
                    <div class="border-b border-slate-100 pb-3">
                        <h2 class="text-lg font-black text-slate-900">3. Office Address & Service Timings</h2>
                        <p class="text-xs text-slate-500 font-medium">Headquarter address details and business hours.</p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                            Head Office Address
                        </label>
                        <input 
                            v-model="form.office_address"
                            type="text"
                            required
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:border-[#0D47A1] focus:ring-2 focus:ring-[#0D47A1]/20 text-xs font-medium text-slate-900 outline-none"
                        />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                                Weekday Hours (Mon – Fri)
                            </label>
                            <input 
                                v-model="form.office_hours_weekday"
                                type="text"
                                required
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:border-[#0D47A1] focus:ring-2 focus:ring-[#0D47A1]/20 text-xs font-medium text-slate-900 outline-none"
                            />
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                                Saturday Hours
                            </label>
                            <input 
                                v-model="form.office_hours_saturday"
                                type="text"
                                required
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:border-[#0D47A1] focus:ring-2 focus:ring-[#0D47A1]/20 text-xs font-medium text-slate-900 outline-none"
                            />
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                                Sunday Hours / Status
                            </label>
                            <input 
                                v-model="form.office_hours_sunday"
                                type="text"
                                required
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:border-[#0D47A1] focus:ring-2 focus:ring-[#0D47A1]/20 text-xs font-medium text-slate-900 outline-none"
                            />
                        </div>
                    </div>
                </div>

                <!-- SECTION 4: INQUIRY FORM HEADINGS & MAP -->
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 space-y-4">
                    <div class="border-b border-slate-100 pb-3">
                        <h2 class="text-lg font-black text-slate-900">4. Form Headings & Google Maps Embed</h2>
                        <p class="text-xs text-slate-500 font-medium">Customize the form headers and embedded Google Map iframe URL.</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                                Form Heading Title
                            </label>
                            <input 
                                v-model="form.form_title"
                                type="text"
                                required
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:border-[#0D47A1] focus:ring-2 focus:ring-[#0D47A1]/20 text-xs font-medium text-slate-900 outline-none"
                            />
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                                Form Subtitle / Instructions
                            </label>
                            <input 
                                v-model="form.form_subtitle"
                                type="text"
                                required
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:border-[#0D47A1] focus:ring-2 focus:ring-[#0D47A1]/20 text-xs font-medium text-slate-900 outline-none"
                            />
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                            Google Maps Embed Iframe URL
                        </label>
                        <textarea 
                            v-model="form.google_maps_url"
                            rows="3"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:border-[#0D47A1] focus:ring-2 focus:ring-[#0D47A1]/20 text-xs font-mono text-slate-900 outline-none"
                        ></textarea>
                    </div>
                </div>

                <!-- SAVE BUTTON -->
                <div class="flex justify-end pt-2">
                    <button 
                        type="submit"
                        :disabled="form.processing"
                        class="px-8 py-3.5 rounded-xl bg-[#0D47A1] hover:bg-[#1565C0] text-white font-extrabold text-xs uppercase tracking-wider shadow-md transition-all flex items-center space-x-2"
                    >
                        <span v-if="form.processing" class="inline-block w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></span>
                        <span>{{ form.processing ? 'Saving Changes...' : 'Save & Publish Contact Content →' }}</span>
                    </button>
                </div>

            </form>

        </div>
    </AuthenticatedLayout>
</template>
