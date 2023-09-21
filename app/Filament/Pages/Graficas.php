<?php

namespace App\Filament\Pages;
use App\Filament\Widgets\BlogPostsChart;
use App\Filament\Widgets\BlogPostsChartTest;

use Filament\Pages\Page;

class Graficas extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.graficas';


    protected function getHeaderWidgets(): array
{
    return [
        BlogPostsChart::class,
        BlogPostsChartTest::class,
    ];
}
}
