<?php

namespace App\Providers;
 
use App\Models\Task;
use App\Models\Journal;
use App\Models\FinancialRecord;
use App\Policies\TaskPolicy;
use App\Policies\JournalPolicy;
use App\Policies\FinancialRecordPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
 
class AppServiceProvider extends ServiceProvider
{
    protected $policies = [
        Task::class            => TaskPolicy::class,
        FinancialRecord::class => FinancialRecordPolicy::class,
        Journal::class         => JournalPolicy::class,
    ];
 
    public function boot(): void
    {
        $this->registerPolicies();
    }
}