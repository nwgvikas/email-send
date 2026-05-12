# Architecture Overview

## Stack

- Backend: Laravel 13 (PHP 8.3)
- Database: SQLite/MySQL/PostgreSQL compatible schema
- Queue: Laravel queue (database driver by default)
- Mail transport: Laravel Mail using third-party providers (SES/Mailgun/SendGrid SMTP)

## Core Components

### Data Layer

- `contacts`
  - Base profile (`name`, `email`)
  - Dynamic custom attributes in `extra_fields` JSON
- `email_templates`
  - `subject`, `body` with token placeholders
- `campaigns`
  - Lifecycle: `draft` -> `scheduled`/`processing` -> `completed`
  - Aggregated stats: `total_contacts`, `success_count`, `failed_count`
- `campaign_contact` (pivot)
  - Per-recipient delivery status and error detail
- `campaign_logs`
  - Operational logs for traceability/reporting

### Application Layer

- `ContactController`
  - CRUD-lite + CSV import parser
- `EmailTemplateController`
  - Template creation/listing
- `CampaignController`
  - Campaign create/send now/show logs
- `CampaignDispatcher`
  - Splits campaign recipients into queue jobs
- `SendCampaignEmailJob`
  - Asynchronous recipient-level processing with retries
- `BulkEmailSender`
  - Template rendering + provider send + status/log updates
- `TemplateRenderer`
  - Replaces `{{placeholder}}` tokens with contact data

### UI Layer

- Admin layout with fixed left sidebar
- Dashboard with key email metrics and recent campaigns
- Dedicated sections for contacts, templates, campaigns, logs

## Email Workflow

1. Create/import contacts
2. Create template with placeholders
3. Create campaign and bind all contacts
4. Dispatch campaign now or later
5. Queue worker processes each recipient job
6. Persist success/failure + logs
7. Dashboard and campaign log screens expose results

## Scalability Notes

- Recipient-level queueing allows horizontal worker scaling.
- Batch dispatch avoids loading entire pivot data in memory.
- Schema supports retry and failure diagnostics.
- For production:
  - Use Redis queue + Supervisor
  - Provider-specific rate limiting
  - Webhook processing for opens/clicks/bounces (future enhancement)
