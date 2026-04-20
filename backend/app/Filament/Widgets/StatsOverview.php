<?php

namespace App\Filament\Widgets;

use App\Models\Project;
use App\Models\TeamMember;
use App\Models\ContactSubmission;
use App\Models\JobOpening;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Projects', Project::count())
                ->description('Curated works in portfolio')
                ->descriptionIcon('heroicon-m-building-office-2')
                ->color('primary'),
            
            Stat::make('Studio Team', TeamMember::count())
                ->description('Creative minds')
                ->descriptionIcon('heroicon-m-users')
                ->color('success'),
            
            Stat::make('New Inquiries', ContactSubmission::count())
                ->description('Messages from website')
                ->descriptionIcon('heroicon-m-envelope')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('info'),
                
            Stat::make('Active Careers', JobOpening::where('is_active', true)->count())
                ->description('Open positions')
                ->descriptionIcon('heroicon-m-briefcase')
                ->color('warning'),
        ];
    }
}
