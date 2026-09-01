<script setup>
import { ref } from 'vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Backend/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    testimonials: {
        type: Array,
        default: () => []
    }
});

const isModalOpen = ref(false);
const isEditing = ref(false);
const editingId = ref(null);
const successMessage = ref('');
const imagePreview = ref(null);
const fileInputRef = ref(null);

const form = useForm({
    name: '',
    location: '',
    destination: '',
    rating: 5,
    image: null,
    avatar: '',
    text: '',
    is_active: true,
});

const triggerFileInput = () => {
    if (fileInputRef.value) {
        fileInputRef.value.click();
    }
};

const handleImageUpload = (e) => {
    const file = e.target.files?.[0];
    if (file) {
        form.image = file;
        const reader = new FileReader();
        reader.onload = (event) => {
            imagePreview.value = event.target.result;
        };
        reader.readAsDataURL(file);
    }
};

const removeImage = () => {
    form.image = null;
    imagePreview.value = null;
    form.avatar = '';
    if (fileInputRef.value) {
        fileInputRef.value.value = '';
    }
};

const openAddModal = () => {
    isEditing.value = false;
    editingId.value = null;
    form.reset();
    form.rating = 5;
    form.is_active = true;
    imagePreview.value = null;
    isModalOpen.value = true;
};

const openEditModal = (t) => {
    isEditing.value = true;
    editingId.value = t.id;
    form.name = t.name || '';
    form.location = t.location || '';
    form.destination = t.destination || '';
    form.rating = t.rating || 5;
    form.image = null;
    form.avatar = t.avatar || '';
    form.text = t.text || '';
    form.is_active = Boolean(t.is_active);
    imagePreview.value = t.avatar || null;
    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
    form.reset();
    imagePreview.value = null;
};

const saveTestimonial = () => {
    if (isEditing.value && editingId.value) {
        form.transform((data) => ({
            ...data,
            _method: 'PUT'
        })).post(route('admin.testimonials.update', editingId.value), {
            preserveScroll: true,
            forceFormData: true,
            onSuccess: () => {
                closeModal();
                showSuccess('Traveller story updated successfully!');
            }
        });
    } else {
        form.transform((data) => ({
            ...data,
            _method: 'POST'
        })).post(route('admin.testimonials.store'), {
            preserveScroll: true,
            forceFormData: true,
            onSuccess: () => {
                closeModal();
                showSuccess('Traveller story added successfully!');
            }
        });
    }
};

const toggleVisibility = (t) => {
    router.patch(route('admin.testimonials.toggle', t.id), {}, {
        preserveScroll: true,
        onSuccess: () => {
            const status = !t.is_active ? 'visible on site' : 'hidden from site';
            showSuccess(`"${t.name}" is now ${status}.`);
        }
    });
};

const deleteTestimonial = (t) => {
    if (confirm(`Are you sure you want to delete the story from "${t.name}"?`)) {
        router.delete(route('admin.testimonials.destroy', t.id), {
            preserveScroll: true,
            onSuccess: () => {
                showSuccess('Traveller story deleted successfully.');
            }
        });
    }
};

const showSuccess = (msg) => {
    successMessage.value = msg;
    setTimeout(() => {
        successMessage.value = '';
    }, 4000);
};
</script>

<template>
    <Head title="Real Traveller Stories Management - Admin Panel" />

    <AuthenticatedLayout>
        <div class="space-y-6 max-w-7xl mx-auto font-aptos">
            
            <!-- HEADER BAR -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
                <div>
                    <span class="text-xs font-black uppercase tracking-wider text-[#0D47A1]">TESTIMONIAL CMS</span>
                    <h1 class="text-2xl sm:text-3xl font-black text-slate-900 mt-0.5">Real Traveller Stories</h1>
                    <p class="text-xs sm:text-sm text-slate-500 font-medium mt-1">
                        Manage traveller stories submitted from the website. Show or hide individual reviews on the public home page with one click.
                    </p>
                </div>
                
                <button 
                    @click="openAddModal"
                    class="px-5 py-3 rounded-xl bg-[#0D47A1] hover:bg-[#1565C0] text-white font-extrabold text-xs uppercase tracking-wider shadow-md transition-all flex items-center space-x-2 self-start sm:self-auto"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    <span>Add New Story</span>
                </button>
            </div>

            <!-- SUCCESS FEEDBACK TOAST -->
            <div v-if="successMessage" class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-900 font-bold text-xs flex items-center justify-between animate-fade-in">
                <div class="flex items-center space-x-2">
                    <span class="w-5 h-5 rounded-full bg-emerald-500 text-white flex items-center justify-center text-xs font-black">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                    </span>
                    <span>{{ successMessage }}</span>
                </div>
                <button @click="successMessage = ''" class="text-emerald-700 font-extrabold text-sm hover:opacity-80">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- STORIES LIST GRID -->
            <div v-if="testimonials.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div 
                    v-for="t in testimonials" 
                    :key="t.id"
                    :class="[
                        'bg-white rounded-2xl border p-6 flex flex-col justify-between space-y-4 shadow-xs transition-all relative',
                        t.is_active ? 'border-slate-200/90 hover:border-blue-300' : 'border-amber-200/80 bg-amber-50/20'
                    ]"
                >
                    <div class="space-y-3">
                        <!-- Top Header: Rating & Visibility Badge -->
                        <div class="flex items-center justify-between">
                            <div class="flex text-amber-400 space-x-1 text-sm">
                                <span v-for="star in (t.rating || 5)" :key="star">★</span>
                            </div>

                            <!-- Show/Hide Badge -->
                            <button 
                                @click="toggleVisibility(t)"
                                :class="[
                                    'px-3 py-1 rounded-full text-[11px] font-black uppercase tracking-wider transition-all border flex items-center space-x-1.5 cursor-pointer',
                                    t.is_active 
                                        ? 'bg-emerald-50 border-emerald-300 text-emerald-800 hover:bg-emerald-100' 
                                        : 'bg-slate-100 border-slate-300 text-slate-600 hover:bg-slate-200'
                                ]"
                                :title="t.is_active ? 'Click to Hide from site' : 'Click to Show on site'"
                            >
                                <span :class="['w-2 h-2 rounded-full', t.is_active ? 'bg-emerald-500 animate-pulse' : 'bg-slate-400']"></span>
                                <span>{{ t.is_active ? 'Visible on Site' : 'Hidden from Site' }}</span>
                            </button>
                        </div>

                        <!-- Story Quote -->
                        <p class="text-slate-700 text-xs sm:text-sm italic leading-relaxed">
                            "{{ t.text }}"
                        </p>

                        <!-- Attached Trip Photo (Shown directly after review text) -->
                        <div v-if="t.avatar" class="mt-2 rounded-2xl overflow-hidden h-36 w-full bg-slate-100 border border-slate-200 shadow-xs">
                            <img 
                                :src="t.avatar" 
                                :alt="t.name + ' travel memory'" 
                                class="w-full h-full object-cover"
                                loading="lazy"
                            />
                        </div>
                    </div>

                    <!-- Author Info & Action Buttons -->
                    <div class="pt-4 border-t border-slate-100 space-y-3">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-full bg-slate-100 border border-slate-200 text-slate-500 flex items-center justify-center shadow-xs flex-shrink-0">
                                <svg class="w-5 h-5 text-slate-400" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M12 4a4 4 0 100 8 4 4 0 000-8zm-2 9a6 6 0 00-6 6v1h16v-1a6 6 0 00-6-6h-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="overflow-hidden">
                                <div class="font-black text-slate-900 text-xs sm:text-sm truncate">{{ t.name }}</div>
                                <div class="text-[11px] text-slate-500 truncate">
                                    {{ t.location }} • <span class="text-[#0D47A1] font-bold">{{ t.destination }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Action Bar: Toggle, Edit, Delete -->
                        <div class="flex items-center justify-between pt-1">
                            <button 
                                @click="toggleVisibility(t)" 
                                :class="[
                                    'text-xs font-extrabold flex items-center space-x-1.5 px-3 py-1.5 rounded-lg transition-all border',
                                    t.is_active ? 'text-amber-700 bg-amber-50 border-amber-200 hover:bg-amber-100' : 'text-emerald-700 bg-emerald-50 border-emerald-200 hover:bg-emerald-100'
                                ]"
                            >
                                <svg v-if="t.is_active" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a10.05 10.05 0 013.682-.782c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21M3 3l18 18"/></svg>
                                <svg v-else class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <span>{{ t.is_active ? 'Hide Story' : 'Show Story' }}</span>
                            </button>

                            <div class="flex items-center space-x-1">
                                <button 
                                    @click="openEditModal(t)"
                                    class="px-2.5 py-1.5 text-slate-600 hover:text-[#0D47A1] hover:bg-slate-100 rounded-lg text-xs font-bold transition-all flex items-center space-x-1"
                                    title="Edit Story"
                                >
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    <span>Edit</span>
                                </button>
                                <button 
                                    @click="deleteTestimonial(t)"
                                    class="px-2.5 py-1.5 text-rose-600 hover:text-rose-800 hover:bg-rose-50 rounded-lg text-xs font-bold transition-all flex items-center space-x-1"
                                    title="Delete Story"
                                >
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    <span>Delete</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- EMPTY STATE -->
            <div v-else class="bg-white rounded-2xl border border-slate-200 p-12 text-center space-y-4">
                <svg class="w-12 h-12 text-slate-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                <h3 class="text-lg font-black text-slate-900">No Traveller Stories Found</h3>
                <p class="text-xs sm:text-sm text-slate-500 max-w-md mx-auto">
                    No traveller stories have been submitted yet. You can manually add traveller stories or wait for visitors to submit them from the front site.
                </p>
                <button 
                    @click="openAddModal"
                    class="px-6 py-3 rounded-xl bg-[#0D47A1] text-white font-extrabold text-xs uppercase tracking-wider inline-flex items-center space-x-2"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    <span>Add First Traveller Story</span>
                </button>
            </div>

            <!-- ADD / EDIT MODAL -->
            <div v-if="isModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/60 backdrop-blur-xs">
                <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 space-y-6 shadow-2xl border border-slate-100 max-h-[90vh] overflow-y-auto no-scrollbar">
                    
                    <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                        <div>
                            <span class="text-xs font-black uppercase text-[#0D47A1] tracking-wider">MODAL EDITOR</span>
                            <h3 class="text-xl font-black text-slate-900">
                                {{ isEditing ? 'Edit Traveller Story' : 'Add New Traveller Story' }}
                            </h3>
                        </div>
                        <button @click="closeModal" class="text-slate-400 hover:text-slate-700 font-bold text-lg">✕</button>
                    </div>

                    <form @submit.prevent="saveTestimonial" class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                                Traveller / Guest Name *
                            </label>
                            <input 
                                v-model="form.name"
                                type="text"
                                required
                                placeholder="e.g. Samantha & Richard Vance"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:border-[#0D47A1] focus:ring-2 focus:ring-[#0D47A1]/20 text-xs font-medium text-slate-900 outline-none"
                            />
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                                    Location / Origin
                                </label>
                                <input 
                                    v-model="form.location"
                                    type="text"
                                    placeholder="e.g. London, UK"
                                    class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:border-[#0D47A1] focus:ring-2 focus:ring-[#0D47A1]/20 text-xs font-medium text-slate-900 outline-none"
                                />
                            </div>

                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                                    Destination / Tour Name
                                </label>
                                <input 
                                    v-model="form.destination"
                                    type="text"
                                    placeholder="e.g. Sri Lanka 8D7N Tour"
                                    class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:border-[#0D47A1] focus:ring-2 focus:ring-[#0D47A1]/20 text-xs font-medium text-slate-900 outline-none"
                                />
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                                Rating (Stars) *
                            </label>
                            <div class="flex items-center space-x-2">
                                <button 
                                    v-for="s in 5" 
                                    :key="s"
                                    type="button"
                                    @click="form.rating = s"
                                    :class="[
                                        'text-2xl transition-all transform hover:scale-110',
                                        s <= form.rating ? 'text-amber-400' : 'text-slate-300'
                                    ]"
                                >
                                    ★
                                </button>
                                <span class="text-xs font-extrabold text-slate-600 pl-2">({{ form.rating }} Stars)</span>
                            </div>
                        </div>

                        <!-- Image File Upload / Photo Section -->
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5 flex items-center justify-between">
                                <span>Traveller Photo / Avatar (Optional)</span>
                                <span class="text-[10px] text-slate-400 font-medium">PNG, JPG, WebP up to 5MB</span>
                            </label>

                            <!-- Permanent File Input -->
                            <input 
                                id="admin_testimonial_file_input"
                                ref="fileInputRef"
                                type="file" 
                                accept="image/jpeg,image/png,image/webp,image/gif,image/jpg"
                                class="hidden" 
                                @change="handleImageUpload" 
                            />

                            <!-- Preview if image selected or existing avatar -->
                            <div v-if="imagePreview" class="relative rounded-2xl border-2 border-blue-200 bg-blue-50/50 p-2.5 flex items-center justify-between gap-3 mb-2 shadow-xs">
                                <div class="flex items-center space-x-3 min-w-0">
                                    <img :src="imagePreview" alt="Story preview" class="w-14 h-14 rounded-xl object-cover border border-slate-200 flex-shrink-0 shadow-sm" />
                                    <div class="min-w-0">
                                        <p class="text-xs font-bold text-slate-800 truncate">{{ form.image ? form.image.name : 'Current Photo' }}</p>
                                        <p class="text-[11px] text-emerald-600 font-semibold flex items-center space-x-1 mt-0.5">
                                            <span>✓</span>
                                            <span>Image selected</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-1.5 flex-shrink-0">
                                    <button 
                                        type="button" 
                                        @click="triggerFileInput"
                                        class="px-2.5 py-1 rounded-lg bg-white hover:bg-slate-100 text-slate-700 font-bold text-[11px] border border-slate-200 transition-colors shadow-2xs"
                                    >
                                        Change
                                    </button>
                                    <button 
                                        type="button" 
                                        @click="removeImage"
                                        class="px-2.5 py-1 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold text-[11px] border border-rose-200 transition-colors shadow-2xs"
                                        title="Remove photo"
                                    >
                                        Remove
                                    </button>
                                </div>
                            </div>

                            <!-- Dropzone button when no image is selected -->
                            <label 
                                v-else
                                for="admin_testimonial_file_input"
                                class="border-2 border-dashed border-slate-200 hover:border-[#0D47A1] bg-slate-50 hover:bg-blue-50/30 rounded-2xl p-3.5 text-center cursor-pointer transition-all duration-200 group flex items-center justify-center space-x-2 text-slate-500 group-hover:text-[#0D47A1] text-xs font-bold mb-2"
                            >
                                <svg class="w-4 h-4 text-slate-500 group-hover:text-[#0D47A1]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span>Upload Photo File</span>
                            </label>

                            <input 
                                v-model="form.avatar"
                                type="text"
                                placeholder="Or enter Image URL (https://...)"
                                class="w-full px-4 py-2 rounded-xl border border-slate-200 focus:border-[#0D47A1] focus:ring-2 focus:ring-[#0D47A1]/20 text-[11px] font-medium text-slate-700 outline-none"
                            />
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                                Story / Experience Review Text *
                            </label>
                            <textarea 
                                v-model="form.text"
                                required
                                rows="4"
                                placeholder="Share the traveller's feedback, experience, or review..."
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:border-[#0D47A1] focus:ring-2 focus:ring-[#0D47A1]/20 text-xs font-medium text-slate-900 outline-none"
                            ></textarea>
                        </div>

                        <div class="flex items-center space-x-3 pt-2">
                            <input 
                                id="is_active_check"
                                v-model="form.is_active"
                                type="checkbox"
                                class="w-4 h-4 text-[#0D47A1] rounded border-slate-300 focus:ring-[#0D47A1]"
                            />
                            <label for="is_active_check" class="text-xs font-extrabold text-slate-800 cursor-pointer">
                                Visible on Live Website immediately
                            </label>
                        </div>

                        <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-100">
                            <button 
                                type="button"
                                @click="closeModal"
                                class="px-5 py-2.5 rounded-xl bg-slate-100 text-slate-700 font-bold text-xs"
                            >
                                Cancel
                            </button>
                            <button 
                                type="submit"
                                :disabled="form.processing"
                                class="px-7 py-2.5 rounded-xl bg-[#0D47A1] hover:bg-[#1565C0] text-white font-extrabold text-xs uppercase tracking-wider shadow-md"
                            >
                                {{ form.processing ? 'Saving...' : (isEditing ? 'Update Story →' : 'Save Story →') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </AuthenticatedLayout>
</template>
