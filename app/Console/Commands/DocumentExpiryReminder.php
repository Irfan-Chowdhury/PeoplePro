<?php

namespace App\Console\Commands;

use App\Employee;
use App\EmployeeDocument;
use App\Notifications\DocumentExpiry;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class DocumentExpiryReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'document:expiry';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if any document is being expired(3 days remaining)';

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

		$document_employee = EmployeeDocument::with('employee','DocumentType')
			->where('expiry_date','=',now()->addDays(3)->format('Y-m-d'))
			->where('is_notify','=',1)
			->get();



		if($document_employee->isNotEmpty())
		{
			foreach ($document_employee as $document)
			{
				$when = now()->addSeconds(30);
				Notification::route('mail', $document->employee->email)
					->notify((new DocumentExpiry(
						$document->document_title,
						$document->expiry_date,
						$document->DocumentType->document_type))->delay(($when)));
			}
		}
		else
		{
			return '';
		}
    }
}
