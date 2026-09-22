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
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Cache;

class ManageAboutPage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-information-circle';
    protected static ?string $navigationGroup = 'Content';
    protected static ?string $navigationLabel = 'Tentang Studio';
    protected static ?string $title = 'Tentang Studio (Halaman About)';
    protected static ?string $slug = 'about-studio';
    protected static ?int $navigationSort = 4;

    protected static string $view = 'filament.pages.manage-about-page';

    public ?array $data = [];

    public function mount(): void
    {
        $settings = SiteSetting::all()->pluck('value', 'key')->toArray();

        $defaults = [
            'about_page_title' => 'About Accaive — Architecture & Built Environments',
            'about_hero_badge' => 'Accaive Design Studio — Est. Yogyakarta & Jakarta',
            'about_hero_heading' => 'Architecture as a dialogue between tectonic permanence and poetic restraint.',
            'about_hero_description' => 'We are an interdisciplinary studio exploring the thresholds between brutalist structural honesty, tropical climate consciousness, and contemporary understated luxury.',
            'about_hero_image' => 'https://images.unsplash.com/photo-1600607686527-6fb886090705?q=80&w=2727&auto=format&fit=crop',
            'about_hero_image_caption' => 'The Void House — Monolithic Form & Light',
            'about_manifesto_quote' => 'We do not build to decorate landscapes; we build to frame human existence with spatial truth and quiet dignity.',
            'about_manifesto_p1' => 'Founded with dual hearts in Kotagede (Yogyakarta) and Jakarta, Accaive navigates the continuous friction between timeless craftsmanship and high-density urban acceleration. In Kotagede, we study the longevity of ancient stone, hand-wrought silver, and traditional Javanese spatial hierarchy. In Jakarta, we test these principles against modern structural scale and forward-thinking sustainability.',
            'about_manifesto_p2' => 'Our approach is uncompromisingly tactile. Rather than covering surfaces with ephemeral veneers, we sculpt spaces from monolithic concrete, local andesite stone, repurposed teak, and floor-to-ceiling glass. The result is an architecture that does not shout for attention, but commands an enduring, contemplative presence.',
            'about_hub1_title' => 'Kotagede Atelier',
            'about_hub1_sub' => 'Yogyakarta, Indonesia — Material & Heritage Lab',
            'about_hub1_image' => 'https://images.unsplash.com/photo-1518998053901-5348d3969105?q=80&w=1200&auto=format&fit=crop',
            'about_hub2_title' => 'Jakarta Strategic Lab',
            'about_hub2_sub' => 'SCBD, Jakarta — Urban Scale & Masterplanning',
            'about_hub2_image' => 'https://images.unsplash.com/photo-1486718448742-163732cd1544?q=80&w=1200&auto=format&fit=crop',
            'about_seo_description' => 'Learn about Accaive Design Studio: our dual roots in Kotagede & Jakarta, brutalist luxury philosophy, core architectural pillars, and multidisciplinary practice.',
        ];

        foreach ($defaults as $key => $defaultVal) {
            $settings[$key] = $settings[$key] ?? $defaultVal;
        }

        $this->form->fill($settings);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Pengaturan Konten About')
                    ->tabs([
                        // TAB 1: HERO & MONUMEN VISUAL
                        Tabs\Tab::make('Hero & Visual')
                            ->icon('heroicon-o-camera')
                            ->schema([
                                Section::make('Bagian Pembuka (Hero Monument)')
                                    ->description('Teks utama dan foto monumen arsitektur besar di bagian atas halaman About.')
                                    ->schema([
                                        TextInput::make('about_hero_badge')
                                            ->label('Label Kecil (Badge)')
                                            ->placeholder('Accaive Design Studio — Est. Yogyakarta & Jakarta'),
                                        TextInput::make('about_hero_image_caption')
                                            ->label('Keterangan Foto Hero')
                                            ->placeholder('The Void House — Monolithic Form & Light'),
                                        TextInput::make('about_hero_heading')
                                            ->label('Headline Utama')
                                            ->placeholder('Architecture as a dialogue between tectonic permanence and poetic restraint.')
                                            ->columnSpanFull(),
                                        Textarea::make('about_hero_description')
                                            ->label('Deskripsi Pengantar Studio')
                                            ->rows(3)
                                            ->columnSpanFull(),
                                        FileUpload::make('about_hero_image')
                                            ->label('Unggah Foto Hero Monumen')
                                            ->image()
                                            ->directory('about')
                                            ->imageEditor()
                                            ->helperText('Unggah foto arsitektur resolusi tinggi (disarankan 21:9 atau 16:9).')
                                            ->columnSpanFull(),
                                    ])->columns(2),
                            ]),

                        // TAB 2: MANIFESTO & FILOSOFI
                        Tabs\Tab::make('Manifesto')
                            ->icon('heroicon-o-book-open')
                            ->schema([
                                Section::make('Filosofi & Manifesto Studio')
                                    ->description('Kutipan monumental dan dua narasi teks filosofi pendekatan desain studio.')
                                    ->schema([
                                        Textarea::make('about_manifesto_quote')
                                            ->label('Kutipan Besar Manifesto')
                                            ->placeholder('We do not build to decorate landscapes; we build to frame human existence with spatial truth and quiet dignity.')
                                            ->rows(2)
                                            ->columnSpanFull(),
                                        Textarea::make('about_manifesto_p1')
                                            ->label('Paragraf 1: Dualisme Kotagede & Jakarta')
                                            ->rows(5)
                                            ->columnSpanFull(),
                                        Textarea::make('about_manifesto_p2')
                                            ->label('Paragraf 2: Kejujuran Tektonik & Materialitas')
                                            ->rows(5)
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        // TAB 3: DUAL STUDIOS / LOKASI
                        Tabs\Tab::make('Lokasi Studio')
                            ->icon('heroicon-o-map-pin')
                            ->schema([
                                Section::make('Studio Hub 1: Kotagede Atelier')
                                    ->schema([
                                        TextInput::make('about_hub1_title')
                                            ->label('Nama Studio'),
                                        TextInput::make('about_hub1_sub')
                                            ->label('Keterangan / Laboratorium'),
                                        FileUpload::make('about_hub1_image')
                                            ->label('Foto Studio Kotagede')
                                            ->image()
                                            ->directory('about')
                                            ->imageEditor()
                                            ->columnSpanFull(),
                                    ])->columns(2),

                                Section::make('Studio Hub 2: Jakarta Strategic Lab')
                                    ->schema([
                                        TextInput::make('about_hub2_title')
                                            ->label('Nama Studio'),
                                        TextInput::make('about_hub2_sub')
                                            ->label('Keterangan / Laboratorium'),
                                        FileUpload::make('about_hub2_image')
                                            ->label('Foto Studio Jakarta')
                                            ->image()
                                            ->directory('about')
                                            ->imageEditor()
                                            ->columnSpanFull(),
                                    ])->columns(2),
                            ]),

                        // TAB 4: SEO & METADATA
                        Tabs\Tab::make('SEO Google')
                            ->icon('heroicon-o-globe-alt')
                            ->schema([
                                Section::make('Optimasi Mesin Pencari (SEO)')
                                    ->schema([
                                        TextInput::make('about_page_title')
                                            ->label('Judul Tab Browser (Meta Title)')
                                            ->placeholder('About Accaive — Architecture & Built Environments')
                                            ->columnSpanFull(),
                                        Textarea::make('about_seo_description')
                                            ->label('Deskripsi Meta di Google')
                                            ->rows(3)
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                    ]),
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

        foreach ($state as $key => $value) {
            SiteSetting::updateOrCreate(
                ['key' => $key],
                ['value' => is_array($value) ? json_encode($value) : $value]
            );
        }

        Cache::forget('site_settings');

        Notification::make()
            ->title('Halaman About Berhasil Diperbarui!')
            ->body('Foto, narasi filosofi, dan lokasi studio telah tersimpan dan langsung aktif di website.')
            ->success()
            ->send();

        $this->dispatch('about-saved');
    }
}
