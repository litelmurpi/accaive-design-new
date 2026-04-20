<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\HtmlString;
use Filament\Support\Enums\MaxWidth;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->spa()
            ->sidebarCollapsibleOnDesktop()
            ->maxContentWidth(MaxWidth::Full)
            ->brandName('Accaive Studio')
            ->font('Inter')
            ->colors([
                'primary' => Color::Zinc,
                'gray' => Color::Slate,
            ])
            ->renderHook(
                PanelsRenderHook::HEAD_END,
                fn(): string => new HtmlString('
                    <style>
                        @import url("https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;1,400&family=Inter:wght@300;400;500;600&display=swap");
                        
                        :root {
                            --p-font-serif: "Playfair Display", serif;
                            --p-font-sans: "Inter", sans-serif;
                        }

                        /* Architectural Layout */
                        .fi-main { background-color: #fcfcfc !important; }
                        .fi-sidebar { 
                            background-color: #f8f8f8 !important; 
                            border-right: 1px solid #eeeeee !important;
                        }
                        .fi-topbar { 
                            box-shadow: none !important; 
                            border-bottom: 1px solid #eeeeee !important; 
                            background-color: rgba(255, 255, 255, 0.8) !important;
                            backdrop-filter: blur(8px);
                        }
                        
                        /* Sharp & Precise Components */
                        .fi-ta-content, 
                        .fi-fo-component, 
                        .fi-wi-stats-overview-stat,
                        .fi-section,
                        .fi-modal-window { 
                            box-shadow: none !important; 
                            border: 1px solid #e5e5e5 !important;
                            border-radius: 0px !important;
                            background-color: #fff !important;
                        }
                        
                        /* Editorial Typography */
                        .fi-header-heading, .fi-modal-heading { 
                            font-family: var(--p-font-serif) !important; 
                            font-size: 2.5rem !important; 
                            font-weight: 400 !important; 
                            letter-spacing: -0.03em;
                            color: #121212 !important;
                        }
                        h3.fi-section-header-heading {
                            font-family: var(--p-font-serif) !important; 
                            font-weight: 400 !important; 
                            font-size: 1.6rem !important;
                            letter-spacing: -0.01em;
                        }
                        .fi-sidebar-item-label, .fi-ta-header-cell-label {
                            text-transform: uppercase;
                            letter-spacing: 0.08em;
                            font-size: 0.7rem !important;
                            font-weight: 600 !important;
                        }

                        /* Minimalist Forms */
                        .fi-input, .fi-select-input, .fi-textarea {
                            box-shadow: none !important;
                            background: #fff !important;
                            border-radius: 0px !important;
                            border: 1px solid #e0e0e0 !important;
                            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
                            padding: 0.75rem 1rem !important;
                        }
                        .fi-input:focus, .fi-select-input:focus, .fi-textarea:focus {
                            border-color: #000 !important;
                            background: #fdfdfd !important;
                        }
                        
                        /* Premium Buttons */
                        .fi-btn { 
                            border-radius: 0px !important; 
                            box-shadow: none !important; 
                            padding: 0.6rem 2rem !important; 
                            text-transform: uppercase; 
                            font-size: 0.7rem !important; 
                            letter-spacing: 0.1em; 
                            font-weight: 600 !important;
                            transition: all 0.3s ease;
                        }
                        .fi-btn-color-primary {
                            background-color: #121212 !important;
                        }
                        .fi-btn-color-primary:hover {
                            background-color: #333 !important;
                            transform: translateY(-1px);
                        }

                        /* Custom Scrollbar */
                        ::-webkit-scrollbar { width: 6px; }
                        ::-webkit-scrollbar-track { background: #f8f8f8; }
                        ::-webkit-scrollbar-thumb { background: #d1d1d1; }
                        ::-webkit-scrollbar-thumb:hover { background: #999; }

                        /* Dark Mode Overrides */
                        .dark .fi-main { background-color: #050505 !important; }
                        .dark .fi-sidebar { background-color: #0a0a0a !important; border-color: #1a1a1a !important; }
                        .dark .fi-topbar { background-color: rgba(10, 10, 10, 0.8) !important; border-color: #1a1a1a !important; }
                        .dark .fi-ta-content, 
                        .dark .fi-fo-component, 
                        .dark .fi-wi-stats-overview-stat,
                        .dark .fi-section,
                        .dark .fi-modal-window { 
                            border-color: #1a1a1a !important; 
                            background-color: #0e0e0e !important; 
                        }
                        .dark .fi-header-heading, .dark .fi-modal-heading, .dark h3.fi-section-header-heading { 
                            color: #f8f8f8 !important; 
                        }
                        .dark .fi-input, .dark .fi-select-input, .dark .fi-textarea { 
                            background: #111 !important; 
                            border-color: #222 !important; 
                            color: #eee !important;
                        }
                        .dark .fi-input:focus, .dark .fi-select-input:focus { border-color: #fff !important; }
                        .dark .fi-btn-color-primary { background-color: #fff !important; color: #000 !important; }
                    </style>
                ')
            )
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                // Custom widgets discovered automatically
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
