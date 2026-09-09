<x-filament-panels::page>
    <div 
        x-data="{ 
            device: 'desktop',
            isRefreshing: false,
            refreshIframe() {
                this.isRefreshing = true;
                const iframe = document.getElementById('site-live-preview-iframe');
                if (iframe) {
                    iframe.src = iframe.src;
                }
                setTimeout(() => { this.isRefreshing = false; }, 800);
            }
        }"
        @site-content-saved.window="refreshIframe()"
        class="w-full"
    >
        <!-- Split-Screen Grid: Left Form, Right Sticky Preview Canvas -->
        <div class="grid grid-cols-1 xl:grid-cols-12 gap-8 items-start">
            
            <!-- Left Side: Form Editor -->
            <div class="xl:col-span-6 2xl:col-span-7 space-y-6">
                <form wire:submit="save" class="space-y-6">
                    {{ $this->form }}

                    <!-- Sticky Save Action Bar -->
                    <div class="sticky bottom-4 z-10 p-4 bg-white/95 dark:bg-gray-900/95 backdrop-blur-md rounded-2xl border border-gray-200 dark:border-gray-800 shadow-xl flex items-center justify-between">
                        <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                            <span class="inline-block w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span class="text-xs sm:text-sm font-medium">Live Canvas aktif di sebelah kanan</span>
                        </div>
                        <x-filament::button type="submit" size="lg" icon="heroicon-m-check" color="primary">
                            Simpan Semua Perubahan
                        </x-filament::button>
                    </div>
                </form>
            </div>

            <!-- Right Side: Sticky Live Preview Canvas -->
            <div class="xl:col-span-6 2xl:col-span-5 sticky top-6 z-20">
                <div class="bg-gray-950 text-white rounded-2xl p-4 shadow-2xl border border-gray-800 space-y-3">
                    
                    <!-- Preview Toolbar -->
                    <div class="flex items-center justify-between pb-3 border-b border-gray-800">
                        <!-- Status indicator -->
                        <div class="flex items-center gap-2">
                            <span class="relative flex h-2.5 w-2.5">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                            </span>
                            <span class="text-xs font-semibold tracking-wider uppercase text-gray-200">Live Canvas Preview</span>
                        </div>

                        <!-- Device Switcher & Controls -->
                        <div class="flex items-center gap-1.5">
                            <!-- Desktop Button -->
                            <button 
                                type="button" 
                                @click="device = 'desktop'" 
                                :class="device === 'desktop' ? 'bg-white/20 text-white shadow-sm ring-1 ring-white/30' : 'text-gray-400 hover:text-white hover:bg-white/10'"
                                class="flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-medium transition-all"
                                title="Tampilan Komputer (Desktop)"
                            >
                                <x-filament::icon icon="heroicon-m-computer-desktop" class="w-4 h-4" />
                                <span class="hidden sm:inline">Desktop</span>
                            </button>

                            <!-- Mobile Button -->
                            <button 
                                type="button" 
                                @click="device = 'mobile'" 
                                :class="device === 'mobile' ? 'bg-white/20 text-white shadow-sm ring-1 ring-white/30' : 'text-gray-400 hover:text-white hover:bg-white/10'"
                                class="flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-medium transition-all"
                                title="Tampilan Smartphone (Mobile)"
                            >
                                <x-filament::icon icon="heroicon-m-device-phone-mobile" class="w-4 h-4" />
                                <span class="hidden sm:inline">Mobile</span>
                            </button>

                            <!-- Divider -->
                            <div class="h-4 w-px bg-gray-800 mx-1"></div>

                            <!-- Refresh Button -->
                            <button 
                                type="button" 
                                @click="refreshIframe()" 
                                class="p-1.5 text-gray-400 hover:text-white hover:bg-white/10 rounded-lg transition-all"
                                title="Segarkan Tampilan Preview"
                            >
                                <x-filament::icon icon="heroicon-m-arrow-path" class="w-4 h-4" x-bind:class="{ 'animate-spin': isRefreshing }" />
                            </button>

                            <!-- Open external link -->
                            <a 
                                href="{{ $frontendUrl }}" 
                                target="_blank" 
                                rel="noopener noreferrer" 
                                class="p-1.5 text-gray-400 hover:text-white hover:bg-white/10 rounded-lg transition-all"
                                title="Buka Website di Tab Baru"
                            >
                                <x-filament::icon icon="heroicon-m-arrow-top-right-on-square" class="w-4 h-4" />
                            </a>
                        </div>
                    </div>

                    <!-- Iframe Viewport Area -->
                    <div class="w-full flex justify-center items-center py-2 bg-black/40 rounded-xl overflow-hidden min-h-[640px]">
                        <div 
                            :class="device === 'mobile' ? 'w-[375px] h-[680px] rounded-[36px] ring-8 ring-gray-800 shadow-2xl overflow-hidden' : 'w-full h-[700px] rounded-xl overflow-hidden'"
                            class="transition-all duration-300 ease-in-out bg-[#0f0e0d]"
                        >
                            <iframe 
                                id="site-live-preview-iframe"
                                src="{{ $frontendUrl }}" 
                                class="w-full h-full border-0"
                                loading="lazy"
                            ></iframe>
                        </div>
                    </div>

                    <!-- Footnote / Tip -->
                    <div class="flex items-center justify-between text-[11px] text-gray-400 pt-1">
                        <span class="truncate">Preview Target: <code class="text-amber-300/90 font-mono">{{ $frontendUrl }}</code></span>
                        <span>Auto-refresh saat disimpan</span>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-filament-panels::page>
