<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use DateTime;

class TimelySendEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends email notification to all companies, that needs to renew their domain and hosting part, at specified time intervals';

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
         //sending email to client starts
        $seoPackages = \App\Models\Package\SeoPackage::all();
        $amcPackages = \App\Models\Package\AmcPackage::all();

        $salesTransactionsItems = \App\Models\SalesTransaction\SalesTransactionsItem::
                                        with(['salesTransaction.company.emails' => function($query){
                                            $query->where('type', '=', 'primary');
                                        }])
                                        ->with('salesCategory')
                    ->join('sales_categories', 'sales_transactions_items.service_id', 'sales_categories.id')
                    ->whereNotIn('sales_categories.slug', ['system', 'animation', 'apps', 'printing'])
                    ->where('sales_transactions_items.end_date', '!=', NULL)
                    ->where('sales_transactions_items.end_date', '>=', date('Y-m-d'))
                    ->get();

        $current_date = new DateTime(date('Y-m-d'));

        foreach( $salesTransactionsItems as $salesTransactionsItem )
        {
            $end_date = new DateTime($salesTransactionsItem->end_date);
            $days = $current_date->diff($end_date)->days;

            if( $salesTransactionsItem->service_id == 2 )
            {
                foreach( $seoPackages as $seoPackage )
                {
                    if( $seoPackage->slug == $salesTransactionsItem->information )
                        $information = $seoPackage->name;
                }
            }
            else if( $salesTransactionsItem->service_id == 10 )
            {
                foreach( $amcPackages as $amcPackage )
                {
                    if( $amcPackage->slug == $salesTransactionsItem->information )
                        $information = $amcPackage->name;
                }
            }
            else
                $information = $salesTransactionsItem->information;


            if( ($days == 60) || ($days == 45) || ($days == 30) || ($days == 15) || ($days == 7) || ($days == 3) || ($days == 2) || ($days == 1) )
            {
                $data = array(
                    'subject' => 'Ultrabyte Account Section',
                    'service' => $salesTransactionsItem->salesCategory->name,
                    'information' => $information,
                    'days' => $days,
                    'view' => 'mail.email-notification',
                );

                foreach( $salesTransactionsItem->salesTransaction->company->emails as $email )
                {
                    Mail::to($email->email)->send(new sendMail($data));

                    if( empty(Mail::failures()) )
                    {
                        $notification = array(
                                            'salesTransactionId' => $salesTransactionsItem->sales_transaction_id,
                                            'salesTransactionItemId' => $salesTransactionsItem->id,
                                            'companyId' => $salesTransactionsItem->salesTransaction->company_id,
                                            'serviceId' => $salesTransactionsItem->service_id,
                                            'information' => $salesTransactionsItem->information,
                                            'remainingDays' => $days,
                                            'expirationDate' => $salesTransactionsItem->end_date,
                                            'seen' => 0
                                        );

                        $this->setTimelyNotification($notification, 1);
                    }
                    else
                    {
                        $notification = array(
                                            'salesTransactionId' => $salesTransactionsItem->sales_transaction_id,
                                            'salesTransactionItemId' => $salesTransactionsItem->id,
                                            'companyId' => $salesTransactionsItem->salesTransaction->company_id,
                                            'serviceId' => $salesTransactionsItem->service_id,
                                            'information' => $salesTransactionsItem->information,
                                            'remainingDays' => $days,
                                            'expirationDate' => $salesTransactionsItem->end_date,
                                            'seen' => 0
                                        );

                        $this->setTimelyNotification($notification, 0);
                    }

                }
            }

        }

        //sending email to client ends

    }

    public function setTimelyNotification( array $data, $successfullySent )
    {
        $timelyNotification = new \App\Models\Notification\TimelyNotification();

        $timelyNotification->sales_transaction_id = $data['salesTransactionId'];
        $timelyNotification->sales_transaction_item_id = $data['salesTransactionItemId'];
        $timelyNotification->company_id = $data['companyId'];
        $timelyNotification->service_id = $data['serviceId'];
        $timelyNotification->information = $data['information'];
        $timelyNotification->remaining_days = $data['remainingDays'];
        $timelyNotification->expiration_date = $data['expirationDate'];
        $timelyNotification->successfully_sent = $successfullySent;

        $timelyNotification->seen = 0;

        $timelyNotification->save();
    }
}
