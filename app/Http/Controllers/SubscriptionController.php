<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\User;
use App\Models\Plan;
use Illuminate\Http\Request;


class SubscriptionController extends Controller
{
    public function create(Request $request, Plan $plan)
    {
        $plan = Plan::findOrFail($request->get('plan'));
        $user = $request->user();
        $paymentMethod = $request->paymentMethod;

        $user->CreateOrGetStripeCustomer();
        $user->updateDefaultPaymentMethod($paymentMethod);
            $user->newSubscription('default', $plan->stripe_plan)
            ->create($paymentMethod, [
                'email' => $user->email,
            ]);
        
        Subscription::where('user_id', $user->id)->update(['status' => 0]);
        return redirect()->route('home')->with(session()->flash('status', 'Your plan subscribed successfully'));
    }
}
