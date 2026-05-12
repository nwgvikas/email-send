<?php

namespace App\Services;

use App\Jobs\SendCampaignEmailJob;
use App\Models\Campaign;
use Illuminate\Support\Facades\DB;

class CampaignDispatcher
{
    public function dispatch(Campaign $campaign): void
    {
        if ($campaign->status === 'processing') {
            return;
        }

        $campaign->update(['status' => 'processing']);

        DB::table('campaign_contact')
            ->where('campaign_id', $campaign->id)
            ->where('status', 'pending')
            ->orderBy('id')
            ->chunkById(200, function ($records) use ($campaign): void {
                foreach ($records as $record) {
                    SendCampaignEmailJob::dispatch($campaign->id, $record->contact_id);
                }
            });
    }
}
