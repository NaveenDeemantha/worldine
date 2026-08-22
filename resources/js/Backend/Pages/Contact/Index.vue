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
    landline_phone: props.settings.landline_phone || '',
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
    notification_email: props.settings.notification_email || '',
    notification_cc_emails: props.settings.notification_cc_emails || '',
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
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
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

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                                Landline Phone No
                            </label>
                            <input 
                                v-model="form.landline_phone"
                                type="text"
                                placeholder="+94 11 263 6558"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:border-[#0D47A1] focus:ring-2 focus:ring-[#0D47A1]/20 text-xs font-medium text-slate-900 outline-none"
                            />
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                                Mobile Hotline 1
                            </label>
                            <input 
                                v-model="form.primary_phone"
                                type="text"
                                placeholder="+94 766 834 881"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:border-[#0D47A1] focus:ring-2 focus:ring-[#0D47A1]/20 text-xs font-medium text-slate-900 outline-none"
                            />
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                                Mobile Hotline 2
                            </label>
                            <input 
                                v-model="form.outbound_phone"
                                type="text"
                                placeholder="+94 718 834 881"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:border-[#0D47A1] focus:ring-2 focus:ring-[#0D47A1]/20 text-xs font-medium text-slate-900 outline-none"
                            />
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                                Mobile Hotline 3
                            </label>
                            <input 
                                v-model="form.inbound_phone"
                                type="text"
                                placeholder="+94 778 692 229"
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

                <!-- SECTION 5: INQUIRY & LEAD EMAIL ALERT SETTINGS -->
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 space-y-4">
                    <div class="border-b border-slate-100 pb-3 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                        <div>
                            <div class="flex items-center space-x-2">
                                <span class="px-2.5 py-0.5 rounded-md bg-blue-100 text-[#0D47A1] text-[10px] font-black uppercase tracking-wider">BREVO SMTP</span>
                                <h2 class="text-lg font-black text-slate-900">5. Email Alerts & Notification Recipients</h2>
                            </div>
                            <p class="text-xs text-slate-500 font-medium mt-1">Configure where instant email alerts are sent when a customer submits a Tour Booking or Contact Form.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                                Primary Alert Email Address <span class="text-red-500">*</span>
                            </label>
                            <input 
                                v-model="form.notification_email"
                                type="email"
                                placeholder="e.g. alerts@worldinedestinations.com or inquiries@yourdomain.com"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:border-[#0D47A1] focus:ring-2 focus:ring-[#0D47A1]/20 text-xs font-medium text-slate-900 outline-none"
                            />
                            <p class="text-[11px] text-slate-400 mt-1">Main inbox that receives all instant inquiry and booking alert emails.</p>
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                                CC Email Recipients (Optional)
                            </label>
                            <input 
                                v-model="form.notification_cc_emails"
                                type="text"
                                placeholder="e.g. manager@worldinedestinations.com, tours@worldinedestinations.com"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:border-[#0D47A1] focus:ring-2 focus:ring-[#0D47A1]/20 text-xs font-medium text-slate-900 outline-none"
                            />
                            <p class="text-[11px] text-slate-400 mt-1">Add multiple emails separated by commas to receive a CC copy of every lead alert.</p>
                        </div>
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
