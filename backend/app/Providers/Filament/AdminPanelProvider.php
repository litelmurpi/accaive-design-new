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
                        
                        /* Awwwards Minimalist Design for Filament Admin */
                        .fi-main, .fi-sidebar { background-color: #fafafa !important; }
                        .fi-topbar { box-shadow: none !important; border-bottom: 1px solid #eaeaea; background-color: transparent !important; }
                        
                        /* Remove Drop Shadows & Apply Sharp Edges */
                        .fi-ta-content, .fi-fo-component, .fi-wi-stats-overview-stat { 
                            box-shadow: none !important; 
                            border: 1px solid #e5e5e5 !important;
                            border-radius: 0px !important;
                        }
                        
                        /* Minimalist Buttons */
                        .fi-btn { 
                            border-radius: 9999px !important; 
                            box-shadow: none !important; 
                            padding: 0.5rem 1.5rem; 
                            text-transform: uppercase; 
                            font-size: 0.75rem !important; 
                            letter-spacing: 0.05em; 
                            font-weight: 500 !important;
                        }
                        
                        /* Sleek Form Inputs */
                        .fi-input, .fi-select-input, .fi-textarea {
                            box-shadow: none !important;
                            background: #fff !important;
                            border-radius: 0px !important;
                            border: 1px solid #eaeaea !important;
                            transition: border-color 0.3s ease;
                        }
                        .fi-input:focus, .fi-select-input:focus, .fi-textarea:focus {
                            border-color: #000 !important;
                        }
                        
                        /* Typography Hierarchy Sync with Frontend */
                        .fi-header-heading, .fi-modal-heading { 
                            font-family: "Playfair Display", serif !important; 
                            font-size: 2.25rem !important; 
                            font-weight: 400 !important; 
                            letter-spacing: -0.02em;
                        }
                        h3.fi-section-header-heading {
                            font-family: "Playfair Display", serif !important; 
                            font-weight: 400 !important; 
                            font-size: 1.5rem !important;
                        }

                        /* Dark mode overrides */
                        .dark .fi-main, .dark .fi-sidebar { background-color: #0a0a0a !important; }
                        .dark .fi-topbar { border-bottom: 1px solid #1a1a1a; }
                        .dark .fi-ta-content, .dark .fi-fo-component, .dark .fi-wi-stats-overview-stat { border-color: #262626 !important; }
                        .dark .fi-input, .dark .fi-select-input, .dark .fi-textarea { background: #121212 !important; border-color: #262626 !important; }
                        .dark .fi-input:focus, .dark .fi-select-input:focus, .dark .fi-textarea:focus { border-color: #fff !important; }
                    </style>
                ')
            )
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
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
