<?php

namespace App\Console\Commands;


use App\Notifications\OfficialDocumentExpiry;
use App\OfficialDocument;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class OfficialDocumentExpiryReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'officialDocument:expiry';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if any document is being expired';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
		$seven = now()->addDays(7)->format('Y-m-d');
		$fifteen = now()->addDays(15)->format('Y-m-d');
		$one_month = now()->addDays(30)->format('Y-m-d');

		$official_document = OfficialDocument::with('AddedBy')
			->whereIn('expiry_date',[$seven,$fifteen,$one_month])
			->get();

		if($official_document->isNotEmpty())
		{
			foreach ($official_document as $document)
			{
				$when = now()->addSeconds(30);
				Notification::route('mail', $document->AddedBy->email)
					->notify((new OfficialDocumentExpiry(
						$document->document_title,
						$document->expiry_date,$document->is_notify))->delay(($when)));
			}
		}
		else
		{
			return '';
		}
    }
}
