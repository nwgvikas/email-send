<?php

namespace App\Services;

use App\Models\Campaign;
use App\Models\CampaignLog;
use App\Models\Contact;
use App\Models\SiteSetting;
use App\Support\TemplateRenderer;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Throwable;

class BulkEmailSender
{
    public function sendToContact(Campaign $campaign, Contact $contact): void
    {
        $template = $campaign->template;
        $payload = array_merge(
            ['name' => $contact->name, 'email' => $contact->email],
            $contact->extra_fields ?? []
        );

        $subject = TemplateRenderer::render($template->subject, $payload);
        $body = TemplateRenderer::render($template->body, $payload);

        $plainPreview = trim(preg_replace('/\s+/', ' ', strip_tags($body)) ?? '');
        $preheader = Str::limit($plainPreview, 140, '');

        $fallbackUrl = null;
        if (preg_match('/href=["\'](https?:\/\/[^"\']+)["\']/i', $body, $m)) {
            $fallbackUrl = $m[1];
        }

        $branding = SiteSetting::branding();

        $html = View::make('mail.campaign', [
            'body' => $body,
            'preheader' => $preheader,
            'subject' => $subject,
            'headerSubtitle' => $campaign->name,
            'appName' => $branding['site_name'],
            'logoUrl' => $branding['logo_url'],
            'appUrl' => rtrim((string) config('app.url', ''), '/'),
            'fallbackUrl' => $fallbackUrl,
        ])->render();

        try {
            Mail::mailer(config('mail.default'))
                ->html($html, function ($message) use ($contact, $subject): void {
                    $message->to($contact->email, $contact->name)->subject($subject);
                });

            $campaign->contacts()->updateExistingPivot($contact->id, [
                'status' => 'sent',
                'error_message' => null,
                'processed_at' => now(),
                'updated_at' => now(),
            ]);

            $campaign->increment('success_count');

            CampaignLog::create([
                'campaign_id' => $campaign->id,
                'contact_id' => $contact->id,
                'level' => 'info',
                'message' => 'Email sent successfully.',
                'context' => ['email' => $contact->email],
            ]);
        } catch (Throwable $exception) {
            $campaign->contacts()->updateExistingPivot($contact->id, [
                'status' => 'failed',
                'error_message' => $exception->getMessage(),
                'processed_at' => now(),
                'updated_at' => now(),
            ]);

            $campaign->increment('failed_count');

            CampaignLog::create([
                'campaign_id' => $campaign->id,
                'contact_id' => $contact->id,
                'level' => 'error',
                'message' => 'Email send failed.',
                'context' => ['error' => $exception->getMessage()],
            ]);
        }

        $pendingCount = $campaign->contacts()->wherePivot('status', 'pending')->count();
        if ($pendingCount === 0) {
            $campaign->update([
                'status' => 'completed',
                'sent_at' => now(),
            ]);
        }
    }
}
