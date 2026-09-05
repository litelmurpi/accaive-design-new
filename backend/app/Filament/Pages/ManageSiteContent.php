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
use Filament\Notifications\Notification;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Cache;

class ManageSiteContent extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Pengaturan';
    protected static ?string $navigationLabel = 'Kelola Konten Website';
    protected static ?string $title = 'Kelola Konten Website';
    protected static ?string $slug = 'manage-site-content';
    protected static ?int $navigationSort = 0;

    protected static string $view = 'filament.pages.manage-site-content';

    public ?array $data = [];

    public function mount(): void
    {
        $settings = SiteSetting::all()->pluck('value', 'key')->toArray();
        $this->form->fill($settings);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Konten Website')
                    ->tabs([
                        Tabs\Tab::make('Beranda (Homepage)')
                            ->icon('heroicon-o-home')
                            ->schema([
                                Section::make('Hero Section')
                                    ->description('Bagian pembuka di halaman utama website')
                                    ->schema([
                                        TextInput::make('hero_headline')
                                            ->label('Headline Hero (HTML didukung)')
                                            ->helperText("Contoh: a creation that <br /> <span class='italic'>craves</span> <br /> <span class='italic'>creative</span> design.")
                                            ->placeholder("a creation that <br /> <span class='italic'>craves</span> <br /> <span class='italic'>creative</span> design.")
                                            ->columnSpanFull(),
                                        TextInput::make('hero_award_subtitle')
                                            ->label('Subjudul Penghargaan')
                                            ->placeholder('7x Agency of the Year'),
                                        TextInput::make('hero_awards')
                                            ->label('Daftar Penghargaan (pisahkan dengan koma)')
                                            ->placeholder('( ArchDaily 2024 ), ( Pritzker Mention 2023 ), ( Dezeen Awards 2024 ), ( AIA Firm of Year 2025 )')
                                            ->columnSpanFull(),
                                        TextInput::make('hero_video_url')
                                            ->label('URL Video Hero (Opsional)')
                                            ->helperText('Kosongkan untuk tetap memakai video bawaan studio.')
                                            ->placeholder('https://.../video.mp4'),
                                        TextInput::make('hero_video_poster')
                                            ->label('URL Gambar Poster Video (Opsional)')
                                            ->placeholder('https://images.unsplash.com/...'),
                                    ])->columns(2),

                                Section::make('Section Layanan (Services) di Beranda')
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

                                Section::make('Section Proyek (WorkGrid) di Beranda')
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

                                Section::make('Section Tim di Beranda')
                                    ->schema([
                                        TextInput::make('home_team_label')
                                            ->label('Label Kecil')
                                            ->placeholder('Team'),
                                        TextInput::make('home_team_heading')
                                            ->label('Judul Section Tim')
                                            ->placeholder('Meet the makers.'),
                                        Textarea::make('home_team_description')
                                            ->label('Deskripsi Pengantar Tim')
                                            ->placeholder('We asked our team to choose a piece of architecture that represents them. From brutalist monuments to sustainable dwellings. Different backgrounds, same high standards.')
                                            ->rows(3)
                                            ->columnSpanFull(),
                                    ])->columns(2),

                                Section::make('Banner Ajakan Kolaborasi (CTA Banner)')
                                    ->description('Banner penutup sebelum footer di beranda dan sub-halaman')
                                    ->schema([
                                        TextInput::make('home_cta_heading')
                                            ->label('Judul Banner (HTML didukung)')
                                            ->placeholder('Have an idea? <br /> <span class="italic opacity-50">Let\'s build it.</span>')
                                            ->columnSpanFull(),
                                        Textarea::make('home_cta_description')
                                            ->label('Deskripsi Banner')
                                            ->placeholder('We collaborate with ambitious brands and people. Let\'s make something great together.')
                                            ->rows(2)
                                            ->columnSpanFull(),
                                        TextInput::make('home_cta_button_text')
                                            ->label('Teks Tombol')
                                            ->placeholder('Start a Project'),
                                    ]),
                            ]),

                        Tabs\Tab::make('Sub-Halaman (Subpages)')
                            ->icon('heroicon-o-squares-2x2')
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
                                        Textarea::make('programs_impacts')
                                            ->label('Daftar Poin Dampak (satu per baris)')
                                            ->placeholder("Establish Market Distinction\nCreate Cultural Relevance\nCommand Premium Pricing\nOptimize Portfolios\nAccelerate Growth\nOpen Market Opportunity")
                                            ->rows(6)
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

                        Tabs\Tab::make('Kontak & Media Sosial')
                            ->icon('heroicon-o-chat-bubble-left-right')
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

                        Tabs\Tab::make('Footer & Identitas')
                            ->icon('heroicon-o-identification')
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

    public function save(): void
    {
        $state = $this->form->getState();

        foreach ($state as $key => $value) {
            SiteSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        Cache::forget('site_settings');

        Notification::make()
            ->title('Konten website berhasil disimpan!')
            ->body('Semua pembaruan telah tersimpan dan langsung aktif di frontend.')
            ->success()
            ->send();
    }
}
