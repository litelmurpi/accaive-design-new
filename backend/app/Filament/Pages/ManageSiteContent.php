<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Notifications\Notification;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Cache;

class ManageSiteContent extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-paint-brush';
    protected static ?string $navigationGroup = 'Pengaturan';
    protected static ?string $navigationLabel = 'Visual UI & Konten Editor';
    protected static ?string $title = 'Visual UI & Konten Editor';
    protected static ?string $slug = 'manage-site-content';
    protected static ?int $navigationSort = 0;

    protected static string $view = 'filament.pages.manage-site-content';

    public ?array $data = [];

    public function mount(): void
    {
        $settings = SiteSetting::all()->pluck('value', 'key')->toArray();

        // 1. Default Sections for Reorder & Visibility
        $defaultSections = [
            ['section_id' => 'hero', 'name' => '🎬 Hero Section (Video & Pembuka)', 'is_visible' => true],
            ['section_id' => 'projects', 'name' => '✨ Proyek Pilihan (Work Grid)', 'is_visible' => true],
            ['section_id' => 'services', 'name' => '🏛️ Layanan Studio (Services)', 'is_visible' => true],
            ['section_id' => 'team', 'name' => '👥 Tim Studio (Meet the Makers)', 'is_visible' => true],
            ['section_id' => 'cta', 'name' => '💬 Ajakan Kolaborasi (CTA Banner)', 'is_visible' => true],
        ];

        if (!empty($settings['home_sections'])) {
            $parsed = json_decode($settings['home_sections'], true);
            if (is_array($parsed)) {
                $nameMap = [
                    'hero' => '🎬 Hero Section (Video & Pembuka)',
                    'projects' => '✨ Proyek Pilihan (Work Grid)',
                    'services' => '🏛️ Layanan Studio (Services)',
                    'team' => '👥 Tim Studio (Meet the Makers)',
                    'cta' => '💬 Ajakan Kolaborasi (CTA Banner)',
                ];
                $merged = [];
                foreach ($parsed as $item) {
                    $id = $item['id'] ?? $item['section_id'] ?? null;
                    if ($id && isset($nameMap[$id])) {
                        $merged[] = [
                            'section_id' => $id,
                            'name' => $nameMap[$id],
                            'is_visible' => (bool)($item['is_visible'] ?? true),
                        ];
                    }
                }
                foreach ($defaultSections as $def) {
                    if (!collect($merged)->contains('section_id', $def['section_id'])) {
                        $merged[] = $def;
                    }
                }
                $settings['home_sections'] = $merged;
            } else {
                $settings['home_sections'] = $defaultSections;
            }
        } else {
            $settings['home_sections'] = $defaultSections;
        }

        // 2. Default Awards parsing for TagsInput
        if (!empty($settings['hero_awards'])) {
            $parsedAwards = json_decode($settings['hero_awards'], true);
            if (is_array($parsedAwards)) {
                $settings['hero_awards'] = $parsedAwards;
            } else {
                $clean = str_replace(['(', ')'], '', $settings['hero_awards']);
                $settings['hero_awards'] = array_filter(array_map('trim', explode(',', $clean)));
            }
        } else {
            $settings['hero_awards'] = ['ArchDaily 2024', 'Pritzker Mention 2023', 'Dezeen Awards 2024', 'AIA Firm of Year 2025'];
        }

        // 3. Default Impacts parsing for TagsInput
        if (!empty($settings['programs_impacts'])) {
            $parsedImpacts = json_decode($settings['programs_impacts'], true);
            if (is_array($parsedImpacts)) {
                $settings['programs_impacts'] = $parsedImpacts;
            } else {
                $settings['programs_impacts'] = array_filter(array_map('trim', explode("\n", $settings['programs_impacts'])));
            }
        } else {
            $settings['programs_impacts'] = [
                'Establish Market Distinction',
                'Create Cultural Relevance',
                'Command Premium Pricing',
                'Optimize Portfolios',
                'Accelerate Growth',
                'Open Market Opportunity',
            ];
        }

        // Defaults for layout presets if empty
        $settings['home_projects_layout'] = $settings['home_projects_layout'] ?? 'asymmetric';
        $settings['home_services_layout'] = $settings['home_services_layout'] ?? 'split';

        $this->form->fill($settings);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('UI & Konten Studio')
                    ->tabs([
                        // TAB 1: TATA LETAK BERANDA (LAYOUT BUILDER)
                        Tabs\Tab::make('Tata Letak Beranda')
                            ->icon('heroicon-o-squares-plus')
                            ->badge('Layout')
                            ->schema([
                                Section::make('Urutan & Visibilitas Bagian (Drag & Drop)')
                                    ->description('Tarik ikon pegangan (≡) ke atas/bawah untuk mengubah urutan tampilan di beranda, atau gunakan sakelar untuk menyembunyikan bagian tertentu.')
                                    ->schema([
                                        Repeater::make('home_sections')
                                            ->label('')
                                            ->schema([
                                                Hidden::make('section_id'),
                                                TextInput::make('name')
                                                    ->label('Bagian Halaman')
                                                    ->disabled()
                                                    ->dehydrated(true)
                                                    ->extraAttributes(['class' => 'font-semibold font-serif']),
                                                Toggle::make('is_visible')
                                                    ->label('Tampilkan')
                                                    ->default(true)
                                                    ->inline(false),
                                            ])
                                            ->columns(2)
                                            ->reorderable()
                                            ->reorderableWithButtons()
                                            ->addable(false)
                                            ->deletable(false),
                                    ]),

                                Section::make('Pilihan Gaya Grid & Tampilan (Layout Presets)')
                                    ->description('Pilih variasi tata letak yang sudah dirancang khusus untuk portofolio arsitektur.')
                                    ->schema([
                                        Select::make('home_projects_layout')
                                            ->label('Gaya Grid Proyek Pilihan')
                                            ->helperText('Pilih bagaimana kartu karya arsitektur disusun di beranda.')
                                            ->options([
                                                'asymmetric' => '🔲 Asimetris Editorial (Bervariasi Besar-Kecil - Khas Luxury Magazine)',
                                                'grid2' => '⏸️ Simetris 2 Kolom Sejajar (Rapi & Seimbang)',
                                                'grid3' => '⏹️ Grid 3 Kolom Kompak (Menampilkan Banyak Karya Sekaligus)',
                                            ])
                                            ->default('asymmetric')
                                            ->native(false),

                                        Select::make('home_services_layout')
                                            ->label('Gaya Tampilan Layanan')
                                            ->helperText('Pilih susunan informasi program dan layanan studio.')
                                            ->options([
                                                'split' => '🔄 Split 2 Kolom (Kiri Deskripsi, Kanan Accordion Interaktif)',
                                                'stacked' => '📜 Tumpuk 1 Kolom Penuh (Deskripsi di Atas, Accordion Melebar)',
                                            ])
                                            ->default('split')
                                            ->native(false),
                                    ])->columns(2),
                            ]),

                        // TAB 2: KONTEN TEKS BERANDA
                        Tabs\Tab::make('Teks Beranda')
                            ->icon('heroicon-o-pencil-square')
                            ->schema([
                                Section::make('Hero Section (Bagian Pembuka)')
                                    ->description('Teks judul besar pembuka studio (tanpa kode HTML).')
                                    ->schema([
                                        TextInput::make('hero_title_prefix')
                                            ->label('Teks Baris Pertama')
                                            ->placeholder('a creation that'),
                                        TextInput::make('hero_title_accent')
                                            ->label('Kata Aksen Miring / Italic')
                                            ->placeholder('craves')
                                            ->helperText('Kata ini akan otomatis dicetak miring mewah.'),
                                        TextInput::make('hero_title_suffix')
                                            ->label('Teks Baris Kedua')
                                            ->placeholder('creative design.')
                                            ->columnSpanFull(),

                                        TextInput::make('hero_award_subtitle')
                                            ->label('Subjudul Penghargaan')
                                            ->placeholder('7x Agency of the Year'),
                                        TagsInput::make('hero_awards')
                                            ->label('Daftar Penghargaan (Ketik lalu tekan Enter)')
                                            ->helperText('Contoh: ArchDaily 2024, Pritzker Mention 2023, Dezeen Awards 2024')
                                            ->placeholder('Tambah penghargaan...')
                                            ->columnSpanFull(),

                                        TextInput::make('hero_video_url')
                                            ->label('URL Video Hero (Opsional)')
                                            ->helperText('Biarkan kosong jika ingin memakai video bawaan Clip1.mp4 studio.')
                                            ->placeholder('https://.../video.mp4'),
                                        TextInput::make('hero_video_poster')
                                            ->label('URL Poster Gambar Video')
                                            ->placeholder('https://images.unsplash.com/...'),
                                    ])->columns(2),

                                Section::make('Teks Bagian Proyek (Work Grid)')
                                    ->schema([
                                        TextInput::make('home_projects_heading')
                                            ->label('Judul Section Proyek')
                                            ->placeholder('Our Projects'),
                                        TextInput::make('home_projects_subheading')
                                            ->label('Subjudul Deskripsi')
                                            ->placeholder('We design structures so compelling, their impact is inevitable.'),
                                        TextInput::make('home_projects_button_text')
                                            ->label('Teks Tombol')
                                            ->placeholder('View All Projects'),
                                    ])->columns(2),

                                Section::make('Teks Bagian Layanan (Services)')
                                    ->schema([
                                        TextInput::make('home_services_label')
                                            ->label('Label Kecil')
                                            ->placeholder('Programs & Services'),
                                        TextInput::make('home_services_heading')
                                            ->label('Judul Utama Layanan')
                                            ->placeholder('Eleven ways we help clients build and command their unique environments.')
                                            ->columnSpanFull(),
                                        TextInput::make('home_services_button_text')
                                            ->label('Teks Tombol')
                                            ->placeholder('Explore Programs'),
                                        TextInput::make('home_services_button_url')
                                            ->label('Tautan Tombol')
                                            ->placeholder('/programs'),
                                    ])->columns(2),

                                Section::make('Teks Bagian Tim (Team)')
                                    ->schema([
                                        TextInput::make('home_team_label')
                                            ->label('Label Kecil')
                                            ->placeholder('Team'),
                                        TextInput::make('home_team_heading')
                                            ->label('Judul Section Tim')
                                            ->placeholder('Meet the makers.'),
                                        Textarea::make('home_team_description')
                                            ->label('Deskripsi Filosofi Tim')
                                            ->placeholder('We asked our team to choose a piece of architecture that represents them...')
                                            ->rows(3)
                                            ->columnSpanFull(),
                                    ])->columns(2),

                                Section::make('Banner Ajakan Diskusi (CTA Banner)')
                                    ->description('Ajakan kolaborasi sebelum bagian footer.')
                                    ->schema([
                                        TextInput::make('home_cta_title')
                                            ->label('Judul Ajakan Baris 1')
                                            ->placeholder('Have an idea?'),
                                        TextInput::make('home_cta_accent')
                                            ->label('Teks Aksen Miring')
                                            ->placeholder("Let's build it."),
                                        Textarea::make('home_cta_description')
                                            ->label('Deskripsi Ajakan')
                                            ->placeholder("We collaborate with ambitious brands and people. Let's make something great together.")
                                            ->rows(2)
                                            ->columnSpanFull(),
                                        TextInput::make('home_cta_button_text')
                                            ->label('Teks Tombol')
                                            ->placeholder('Start a Project'),
                                    ])->columns(2),
                            ]),

                        // TAB 3: SUB-HALAMAN
                        Tabs\Tab::make('Sub-Halaman')
                            ->icon('heroicon-o-document-duplicate')
                            ->schema([
                                Section::make('Halaman Programs (/programs)')
                                    ->schema([
                                        TextInput::make('programs_hero_title')
                                            ->label('Label Halaman')
                                            ->placeholder('Programs'),
                                        TextInput::make('programs_hero_heading')
                                            ->label('Headline Utama')
                                            ->placeholder('Eleven ways we help brands find and command their unique premium.')
                                            ->columnSpanFull(),
                                        TextInput::make('programs_impact_title')
                                            ->label('Judul Dampak Program')
                                            ->placeholder('Our Programs Deliver Impact'),
                                        TagsInput::make('programs_impacts')
                                            ->label('Poin-Poin Dampak (Ketik lalu tekan Enter)')
                                            ->placeholder('Tambah poin dampak...')
                                            ->columnSpanFull(),
                                    ])->columns(2),

                                Section::make('Halaman Arts & Culture (/arts-culture)')
                                    ->schema([
                                        TextInput::make('arts_hero_title')
                                            ->label('Judul Halaman')
                                            ->placeholder('Arts & Culture'),
                                        Textarea::make('arts_hero_description')
                                            ->label('Deskripsi Pengantar')
                                            ->placeholder('Exploring the intersection of design, heritage, and modern artistic expression.')
                                            ->rows(2)
                                            ->columnSpanFull(),
                                    ]),

                                Section::make('Halaman Team (/team)')
                                    ->schema([
                                        TextInput::make('team_page_title')
                                            ->label('Judul Halaman')
                                            ->placeholder('Our Team'),
                                        TextInput::make('team_page_subtitle')
                                            ->label('Subjudul Pengantar')
                                            ->placeholder('The minds and makers behind Accaive.'),
                                        TextInput::make('team_join_title')
                                            ->label('Judul Banner Rekrutmen')
                                            ->placeholder('Join the Collective'),
                                        TextInput::make('team_join_button_text')
                                            ->label('Teks Tombol Rekrutmen')
                                            ->placeholder('View Openings'),
                                        Textarea::make('team_join_description')
                                            ->label('Deskripsi Rekrutmen')
                                            ->placeholder('We are always looking for visionary talent to join our multidisciplinary team.')
                                            ->rows(2)
                                            ->columnSpanFull(),
                                    ])->columns(2),

                                Section::make('Halaman Careers (/careers)')
                                    ->schema([
                                        TextInput::make('careers_hero_title')
                                            ->label('Judul Halaman')
                                            ->placeholder('Careers'),
                                        Textarea::make('careers_hero_description')
                                            ->label('Deskripsi Pengantar')
                                            ->placeholder('Join us in shaping the future of built environments.')
                                            ->rows(2)
                                            ->columnSpanFull(),
                                    ]),

                                Section::make('Halaman Press (/press)')
                                    ->schema([
                                        TextInput::make('press_hero_title')
                                            ->label('Judul Halaman')
                                            ->placeholder('Press'),
                                        Textarea::make('press_hero_description')
                                            ->label('Deskripsi Pengantar')
                                            ->placeholder('Latest news, awards, and features.')
                                            ->rows(2)
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        // TAB 4: KONTAK & MEDIA SOSIAL
                        Tabs\Tab::make('Kontak & Media Sosial')
                            ->icon('heroicon-o-chat-bubble-bottom-center-text')
                            ->schema([
                                Section::make('Informasi Kontak Studio')
                                    ->schema([
                                        TextInput::make('contact_email')
                                            ->label('Email Resmi')
                                            ->email()
                                            ->placeholder('hello@accaivedesign.com'),
                                        TextInput::make('contact_phone')
                                            ->label('Nomor Telepon / WhatsApp')
                                            ->placeholder('+62 812-3456-7890'),
                                        TextInput::make('contact_address')
                                            ->label('Alamat Kantor')
                                            ->placeholder('Jakarta, Indonesia')
                                            ->columnSpanFull(),
                                    ])->columns(2),

                                Section::make('Tautan Media Sosial')
                                    ->schema([
                                        TextInput::make('social_instagram')
                                            ->label('Instagram URL')
                                            ->placeholder('https://instagram.com/accaivedesign'),
                                        TextInput::make('social_linkedin')
                                            ->label('LinkedIn URL')
                                            ->placeholder('https://linkedin.com/company/accaivedesign'),
                                        TextInput::make('social_twitter')
                                            ->label('Twitter / X URL')
                                            ->placeholder('https://x.com/accaivedesign'),
                                    ])->columns(3),
                            ]),

                        // TAB 5: IDENTITAS & FOOTER
                        Tabs\Tab::make('Identitas & Footer')
                            ->icon('heroicon-o-sparkles')
                            ->schema([
                                Section::make('Identitas Brand & Footer')
                                    ->schema([
                                        TextInput::make('site_title')
                                            ->label('Nama Brand / Studio')
                                            ->placeholder('Accaive Design Studio'),
                                        TextInput::make('footer_tagline')
                                            ->label('Tagline Newsletter Footer')
                                            ->placeholder('Keep up to date'),
                                        TextInput::make('footer_copyright')
                                            ->label('Teks Hak Cipta')
                                            ->placeholder('Accaive Design Studio. All rights reserved.')
                                            ->columnSpanFull(),
                                    ])->columns(2),
                            ]),
                    ])
            ])
            ->statePath('data');
    }

    public function getFrontendUrl(): string
    {
        if (env('FRONTEND_URL')) {
            return env('FRONTEND_URL');
        }

        $host = request()->getHost();
        if (str_contains($host, 'accaivedesign.id') || str_contains($host, 'railway.app')) {
            return 'https://accaivedesign.id';
        }

        return 'http://localhost:5173';
    }

    protected function getViewData(): array
    {
        return [
            'frontendUrl' => $this->getFrontendUrl(),
        ];
    }

    public function save(): void
    {
        $state = $this->form->getState();

        // 1. Clean and encode home_sections for JSON storage
        if (isset($state['home_sections']) && is_array($state['home_sections'])) {
            $cleanSections = array_map(function ($item) {
                return [
                    'id' => $item['section_id'],
                    'is_visible' => (bool)($item['is_visible'] ?? true),
                ];
            }, $state['home_sections']);
            $state['home_sections'] = json_encode($cleanSections);
        }

        // 2. Encode hero_awards
        if (isset($state['hero_awards']) && is_array($state['hero_awards'])) {
            $state['hero_awards'] = json_encode($state['hero_awards']);
        }

        // 3. Encode programs_impacts
        if (isset($state['programs_impacts']) && is_array($state['programs_impacts'])) {
            $state['programs_impacts'] = json_encode($state['programs_impacts']);
        }

        foreach ($state as $key => $value) {
            SiteSetting::updateOrCreate(
                ['key' => $key],
                ['value' => is_array($value) ? json_encode($value) : $value]
            );
        }

        Cache::forget('site_settings');

        Notification::make()
            ->title('Antarmuka Website Berhasil Diperbarui!')
            ->body('Urutan bagian, gaya layout, dan teks telah tersimpan dan langsung aktif di website.')
            ->success()
            ->send();

        $this->dispatch('site-content-saved');
    }
}
