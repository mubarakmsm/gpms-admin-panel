<?php

// namespace App\Filament\Admin\Widgets;

// use App\Models\Department;
// use App\Models\Faculty;
// use Filament\Widgets\ChartWidget;
// use Illuminate\Support\Facades\DB;

// class DepartmentsOverview extends ChartWidget
// {
//     // protected static ?string $heading = 'توزيع الأقسام على الكليات';
//     protected static ?int $sort = 5;

//     protected function getData(): array
//     {
//         $facultiesWithDepartments = Faculty::withCount(['departments' => function ($query) {
//             $query->where('status', 'active');
//         }])
//         ->where('status', 'active')
//         ->get();

//         return [
//             'datasets' => [
//                 [
//                     'label' => 'عدد الأقسام',
//                     'data' => $facultiesWithDepartments->pluck('departments_count')->toArray(),
//                     'backgroundColor' => [
//                         '#3b82f6', '#ef4444', '#10b981', '#f59e0b', 
//                         '#8b5cf6', '#ec4899', '#06b6d4', '#84cc16',
//                     ],
//                 ],
//             ],
//             'labels' => $facultiesWithDepartments->pluck('name')->toArray(),
//         ];
//     }

//     protected function getType(): string
//     {
//         return 'bar';
//     }

//     protected function getOptions(): array
//     {
//         return [
//             'plugins' => [
//                 'legend' => [
//                     'display' => false,
//                 ],
//             ],
//             'scales' => [
//                 'x' => [
//                     'ticks' => [
//                         'maxRotation' => 45,
//                     ],
//                 ],
//             ],
//         ];
//     }
// }