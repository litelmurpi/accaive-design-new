<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Widgets\StatsOverviewWidget;
use App\Filament\Widgets\StatsOverview;
use App\Filament\Widgets\LatestInquiries;

class Dashboard extends BaseDashboard
{
    protected static ?string $title = 'Studio Overview';

    protected static string $view = 'filament.pages.custom-dashboard';

    public function getWidgets(): array
    {
        return [
            StatsOverview::class,
            LatestInquiries::class,
        ];
    }
}
