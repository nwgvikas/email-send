<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Models\Campaign;
use App\Services\CampaignDispatcher;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('campaigns:dispatch-scheduled', function (CampaignDispatcher $dispatcher) {
    $campaigns = Campaign::query()
        ->where('status', 'scheduled')
        ->whereNotNull('scheduled_at')
        ->where('scheduled_at', '<=', now())
        ->get();

    foreach ($campaigns as $campaign) {
        $dispatcher->dispatch($campaign);
    }

    $this->info("Queued {$campaigns->count()} scheduled campaign(s).");
})->purpose('Dispatch due scheduled campaigns');
