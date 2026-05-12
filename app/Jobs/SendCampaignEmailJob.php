<?php

namespace App\Jobs;

use App\Models\Campaign;
use App\Models\Contact;
use App\Services\BulkEmailSender;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendCampaignEmailJob implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;

    public function __construct(
        public int $campaignId,
        public int $contactId
    ) {
    }

    public function handle(BulkEmailSender $sender): void
    {
        $campaign = Campaign::with('template')->findOrFail($this->campaignId);
        $contact = Contact::findOrFail($this->contactId);

        $sender->sendToContact($campaign, $contact);
    }
}
