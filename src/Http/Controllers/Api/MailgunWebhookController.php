<?php

declare(strict_types=1);

namespace MailMerge\Http\Controllers\Api;

use MailMerge\Services\Mailgun\MailgunLog;
use Illuminate\Http\Request;
use MailMerge\Repositories\MailLogsRepository;

class MailgunWebhookController
{
    /**
    * Handle logs webhook from mail service provider
    */
    public function handle(Request $request, MailLogsRepository $logsRepository)
    {
        $payload = $request->get('event-data');

        /** @var MailgunLog $mailgunLog */
        $mailgunLog = MailgunLog::fromEvent($payload);

        $logsRepository->saveLogs($mailgunLog->toJson());

        return response()->json();
    }
}
