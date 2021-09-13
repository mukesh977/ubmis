<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\Models\RequestedTransaction\RequestedSalesTransaction;
use App\Models\RequestedTransaction\RequestedSalesTransactionItem;
use App\Models\RequestedTransaction\RequestedSalesInstallmentPayment;
use App\Models\Notification\TimelyNotification;
use Illuminate\Support\Facades\Auth;
use App\Models\Ticket\Ticket;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    	Schema::defaultStringLength(191);

        view()->composer('layouts.header', function($view) {
            $view->with('rST', RequestedSalesTransaction::with('requestedSalesTransactionItem', 'requestedSalesInstallmentPayment', 'User')
                                        ->where('completed', '=', 0)
                                        ->get());

        });

        view()->composer('layouts.header', function($view) {
            $timelyNotifications = TimelyNotification::with('company')->orderBy('created_at', 'DESC')->limit(100)->get();

            $timelyNotificationsCount = TimelyNotification::where('seen', '=', 0)->count();

            $services = \App\Models\Sales\SalesCategory::all();
            
            $view->with('timelyNotifications', $timelyNotifications)
                    ->with('timelyNotificationsCount', $timelyNotificationsCount )
                    ->with('services', $services);
        });

        view()->composer('layouts.side_nav', function($view) {
            $authenticated_user = Auth::user();
            $roles = array();

            foreach( $authenticated_user->roles as $role )
                $roles[] = $role->name;

            $activeTicketsCount = Ticket::where('completed_at', NULL)
                                ->where( function($q) use ($roles, $authenticated_user){
                                    if( in_array('agent', $roles) )
                                        $q->where('agent_id', '=', $authenticated_user->id);
                                    else if( in_array('admin', $roles) )
                                        $q;
                                    else if( in_array('client', $roles) )
                                        $q->where('user_id', '=', $authenticated_user->id);
                                })
                                ->count();

            $completedTicketsCount = Ticket::where('completed_at', '!=', NULL)
                                    ->where( function($q) use ($roles, $authenticated_user){
                                        if( in_array('agent', $roles) )
                                            $q->where('agent_id', '=', $authenticated_user->id);
                                        else if( in_array('admin', $roles) )
                                            $q;
                                        else if( in_array('client', $roles) )
                                            $q->where('user_id', '=', $authenticated_user->id);
                                    })
                                    ->count();
            

            $view->with('activeTicketsCount', $activeTicketsCount)
                    ->with('completedTicketsCount', $completedTicketsCount );
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
