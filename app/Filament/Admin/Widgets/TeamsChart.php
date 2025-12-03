<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\ChartWidget;

class TeamsChart extends ChartWidget
{
    protected ?string $heading = 'Teams Chart';
    protected static ?int $sort = 2;
    protected bool $isCollapsible = true;

    protected function getData(): array
    {
        return [
             'datasets' => [
                [
                    'label' => 'Teams',
                    'data' => [0, 10, 5, 2, 21, 32, 45, 74, 65, 45, 77, 89],
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
