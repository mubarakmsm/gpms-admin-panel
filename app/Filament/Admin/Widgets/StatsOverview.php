<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Faculty;
use App\Models\Department;
use App\Models\Student;
use App\Models\Supervisor;
use App\Models\Team;
use App\Models\Project;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Section;

class StatsOverview extends BaseWidget
{
    // protected static bool $isLazy = false;
    // protected static ?string $pollingInterval = '30s';
    protected static ?int $sort = 1;
 public function getSectionContentComponent(): Component
    {
        return Section::make()
            ->heading($this->getHeading())
            ->description($this->getDescription())
            ->schema($this->getCachedStats())
            ->columns($this->getColumns())
            ->contained(false)
            ->gridContainer()
            ->collapsible()
            ;
    }
    protected function getStats(): array
    {
        $activeDepartments = Department::where('status', 'active')->count();
        $totalStudents = Student::where('status', 'active')->count();
        $activeSupervisors = Supervisor::where('status', 'active')->count();
        $activeTeams = Team::where('status', 'active')->count();
        $completedProjects = Project::where('status', 'completed')->count();
        $pendingProjects = Project::where('status', 'pending')->count();

        // إحصائيات النشاط الأخير
        $recentStudents = Student::where('created_at', '>=', now()->subDays(7))->count();
        $recentTeams = Team::where('created_at', '>=', now()->subDays(7))->count();

        return [
            Stat::make(__('gpms.stats.total_faculties'), Faculty::count())
                ->description(__('gpms.stats.total_faculties'))
                ->descriptionIcon('heroicon-o-building-library')
                ->color('success')
                ->chart($this->getFacultyGrowthChart())
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                ]),

            Stat::make(__('gpms.stats.active_departments'), $activeDepartments)
                ->description(__('gpms.stats.active_departments'))
                ->descriptionIcon('heroicon-o-rectangle-group')
                ->color('info')
                ->chart($this->getDepartmentStats()),

            Stat::make(__('gpms.stats.active_students'), $totalStudents)
                ->description(__('gpms.stats.new_students_week', ['count' => $recentStudents]))
                ->descriptionIcon('heroicon-o-user')
                ->color('primary')
                ->chart($this->getStudentGrowthChart()),

            Stat::make(__('gpms.stats.active_supervisors'), $activeSupervisors)
                ->description(__('gpms.stats.active_supervisors'))
                ->descriptionIcon('heroicon-o-user-group')
                ->color('warning'),

            Stat::make(__('gpms.stats.active_teams'), $activeTeams)
                ->description(__('gpms.stats.new_teams_week', ['count' => $recentTeams]))
                ->descriptionIcon('heroicon-o-clipboard-document-list')
                ->color('danger')
                ->chart($this->getTeamGrowthChart()),

            Stat::make(__('gpms.stats.completed_projects'), $completedProjects)
                ->description(__('gpms.stats.pending_projects'))
                ->descriptionIcon('heroicon-o-check-badge')
                ->color('success'),
        ];
    }

    private function getStudentGrowthChart(): array
    {
        $months = 6;
        $start = Carbon::now()->subMonths($months - 1)->startOfMonth();

        $rows = Student::where('created_at', '>=', $start)
            ->select(DB::raw("COUNT(*) as count, DATE_FORMAT(created_at, '%Y-%m') as ym"))
            ->groupBy('ym')
            ->pluck('count', 'ym')
            ->toArray();

        $result = [];
        for ($i = $months - 1; $i >= 0; $i--) {
            $ym = Carbon::now()->subMonths($i)->format('Y-m');
            $result[] = isset($rows[$ym]) ? (int) $rows[$ym] : 0;
        }

        return $result;
    }

    private function getTeamGrowthChart(): array
    {
        $months = 6;
        $start = Carbon::now()->subMonths($months - 1)->startOfMonth();

        $rows = Team::where('created_at', '>=', $start)
            ->select(DB::raw("COUNT(*) as count, DATE_FORMAT(created_at, '%Y-%m') as ym"))
            ->groupBy('ym')
            ->pluck('count', 'ym')
            ->toArray();

        $result = [];
        for ($i = $months - 1; $i >= 0; $i--) {
            $ym = Carbon::now()->subMonths($i)->format('Y-m');
            $result[] = isset($rows[$ym]) ? (int) $rows[$ym] : 0;
        }

        return $result;
    }

    private function getFacultyGrowthChart(): array
    {
        $months = 6;
        $start = Carbon::now()->subMonths($months - 1)->startOfMonth();

        $rows = Faculty::where('created_at', '>=', $start)
            ->select(DB::raw("COUNT(*) as count, DATE_FORMAT(created_at, '%Y-%m') as ym"))
            ->groupBy('ym')
            ->pluck('count', 'ym')
            ->toArray();

        $result = [];
        for ($i = $months - 1; $i >= 0; $i--) {
            $ym = Carbon::now()->subMonths($i)->format('Y-m');
            $result[] = isset($rows[$ym]) ? (int) $rows[$ym] : 0;
        }

        return $result;
    }

    private function getDepartmentStats(): array
    {
        $months = 6;
        $start = Carbon::now()->subMonths($months - 1)->startOfMonth();

        $rows = Department::where('created_at', '>=', $start)
            ->select(DB::raw("COUNT(*) as count, DATE_FORMAT(created_at, '%Y-%m') as ym"))
            ->groupBy('ym')
            ->pluck('count', 'ym')
            ->toArray();

        $result = [];
        for ($i = $months - 1; $i >= 0; $i--) {
            $ym = Carbon::now()->subMonths($i)->format('Y-m');
            $result[] = isset($rows[$ym]) ? (int) $rows[$ym] : 0;
        }

        return $result;
    }
}