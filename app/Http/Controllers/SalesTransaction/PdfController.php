<?php

namespace App\Http\Controllers\SalesTransaction;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PDF;
use Dompdf\Dompdf;
use App\Models\Company\Company;
use App\Models\SalesTransaction\SalesTransaction;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Package\AmcPackage;
use App\Models\Package\SeoPackage;
use App\Models\Invoice\Invoice;
use App\Models\Invoice\InvoiceItem;
use App\Models\Invoice\InvoiceItemAmount;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class PdfController extends Controller
{
    public function getInvoicePdf($id = '')
    {
		// $pdf = PDF::loadView('invoice.invoice2')->setPaper('a4', 'portrait');

		// return $pdf->stream('1.pdf');
    	// return view('invoice.invoice');

  //   	$pdf = new Dompdf();
		// $pdf->loadHtml(html_entity_decode($content2));
		// $pdf->render();
		// $pdf->stream();

    	// Storage::deleteDirectory(public_path('pdf/b.pdf'));
    	// File::delete(public_path('pdf/*.pdf'));

		$today = Carbon::today();
		$startOfMonth = $today->startOfMonth()->toDateString();
		$endOfMonth = $today->endOfMonth()->toDateString();
		$today = Carbon::today();
		// dd($today);

		$company = Company::where('id', '=', $id)->first();
		$seoPackages = SeoPackage::all();
		$amcPackages = AmcPackage::all();

    	$currentMonthTransactions = SalesTransaction::
											with('salesTransactionsItem.salesCategory', 'salesTransactionsItemFb', 'salesTransactionsItem.salesTransactionsItemFb')
    										->where('company_id', '=', $id)
    										->whereBetween('date', [$startOfMonth, $endOfMonth])
    										->get();

    	$previousDueAmount = SalesTransaction::where('company_id', '=', $id)
    											->whereNotBetween('date', [$startOfMonth, $endOfMonth])
    											->sum('total_unpaid_amount');

    	$totalDueAmount = SalesTransaction::where('company_id', '=', $id)
    											->sum('total_unpaid_amount');
		// dd($currentMonthTransactions);

    	//stores invoice in database
    	$invoice = new Invoice();

    	$invoice->company_id = $company->id;
    	$invoice->bill_no = 1;
    	$invoice->date = $today->toDateString();
    	$invoice->previous_due_amount = $previousDueAmount;
    	$invoice->total_due_amount = $totalDueAmount;

    	$invoice->save();

    	$invoiceUpdate = Invoice::where('id', '=', $invoice->id)->first();
    	$invoiceUpdate->bill_no = $invoice->id;
    	$invoiceUpdate->update();
    	$billNo = $invoice->id;


		$lastInvoiceItem = InvoiceItem::orderBy('id', 'DESC')->first();

		if( $lastInvoiceItem != NULL )
		{
			$lastInvoiceItemId = $lastInvoiceItem->group_id;
			$groupId = $lastInvoiceItemId;
		}
		else
			$groupId = 0;

     	foreach( $currentMonthTransactions as $sT )
     	{
     		$groupId++;
	    	foreach( $sT->salesTransactionsItem as $index => $item )
     		{
     			if( $item->salesCategory->slug != "facebook" )
		        {
	       			$invoiceItem = new InvoiceItem();

	       			$invoiceItem->invoice_id = $invoice->id;

	       			$invoiceItem->group_id = $groupId;
	       			$invoiceItem->service_id = $item->service_id;
	       			$invoiceItem->information = $item->information;
	       			$invoiceItem->total_price = $item->total_price;

	       			$invoiceItem->save();
	          	}
	          	else
		        {
		            $fbItems = $item->salesTransactionsItemFb;
		            $fbItemsCount = $fbItems->count();

		            if( $fbItemsCount > 0 )
		            {
		              foreach( $item->salesTransactionsItemFb as $fbItem )
		              {
		                // dd($fbItems);
		                $invoiceItem = new InvoiceItem();

		                $invoiceItem->invoice_id = $invoice->id;

		                $invoiceItem->group_id = $groupId;
		                $invoiceItem->service_id = $item->service_id;
		                $invoiceItem->information = $fbItem->particulars;
		                $invoiceItem->total_price = $fbItem->total;

		                $invoiceItem->save();

		              }
		              
		            }
		        }
        	}
        
	        $invoiceItemAmount = new InvoiceItemAmount();

	        $invoiceItemAmount->invoice_item_id = $invoiceItem->id;
	        $invoiceItemAmount->invoice_item_group_id = $groupId;
	        $invoiceItemAmount->total_paid_amount = $sT->total_paid_amount;

	        $invoiceItemAmount->save();
     	}
     	// return view('invoice.invoice', compact('currentMonthTransactions', 'company', 'today', 'seoPackages', 'amcPackages', 'previousDueAmount', 'totalDueAmount', 'billNo'));

		$pdf = PDF::loadView('invoice.invoice', compact('currentMonthTransactions', 'company', 'today', 'seoPackages', 'amcPackages', 'previousDueAmount', 'totalDueAmount', 'billNo'))->save(public_path('pdf/'.$company->name.'.pdf'));
		
		return redirect()->to(url('/invoice/download/'.$company->name));
        // return $pdf->download('result.pdf');

		// $pdf->save(public_path('pdf/a.pdf'));
		// $output = $pdf->output();
		// file_put_contents('filename.pdf', $output);

		// $view = View('invoice.invoice2');
  //       $pdf = \App::make('dompdf.wrapper');
  //       $pdf->loadHTML($view->render());
		// $pdf->save(storage_path().'filename.pdf');
  //       return $pdf->stream();

    }

    public function download($companyName = '')
    {
    	return response()->download(public_path('pdf/'.$companyName.'.pdf'));
    }


    public function getCompanies()
    {
    	$salesTransactions = SalesTransaction::with('company')
    									->where('payment_complete_status', '=', 0)
    									->groupBy('company_id')
    									->paginate(24);


    	// dd($salesTransactions);

    	return view('company.invoice-companies')->with('salesTransactions', $salesTransactions);
    }


    public function getInvoices()
    {
    	$invoices = Invoice::with('company')->orderBy('created_at', 'DESC')->paginate(24);
    	return view('invoice.list-invoice')->with('invoices', $invoices);
    }

    public function getInvoice( $id='' )
    {
    	$seoPackages = SeoPackage::all();
    	$amcPackages = AmcPackage::all();
    	$invoice = Invoice::with('company', 'invoiceItems.invoiceItemAmounts')->where('id', '=', $id)->first();
    	// dd($invoice);

    	return view('invoice.view-single-invoice')->with('invoice', $invoice)
    												->with('seoPackages', $seoPackages)
    												->with('amcPackages', $amcPackages)
    												->with('countGroup', new PdfController());
    }

    public function countGroup($invoiceId = '', $groupId = '')
    {
    	return InvoiceItem::where('invoice_id', '=', $invoiceId)
    						->where('group_id', '=', $groupId )
    						->count();
    }
}
