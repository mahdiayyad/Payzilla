<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::all();
        return view('plans.index', compact('plans'));
    }

    public function create(Request $request) {
        $plan = new Plan();
        $plan->name = $request->name;
        $plan->slug = $request->slug;
        $plan->stripe_plan = $request->stripe_plan;
        $plan->price = $request->price;
        $plan->description = $request->description;
        if($plan->save()) {
            return response()->json(['success' => true, 'message' => 'Plan created successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Plan creation failed']);
        }
    }

    public function show(Plan $plan, Request $request)
    {   
       $paymentMethods = $request->user()->paymentMethods();

        $intent = $request->user()->createSetupIntent();
        
        return view('plans.show', compact('plan', 'intent'));
    }

    public function edit() {
        $plans = Plan::all();
        return view('plans.edit', compact('plans'));
    }

    public function update(Request $request)
    {
        $plansUpdate = Plan::where('id', '=', $request->id)->update([
            'name' => $request->name, 
            'slug' => $request->slug,
            'stripe_plan' => $request->stripe_plan,
            'price' => $request->price, 
            'description' => $request->description,
        ]);

        if($plansUpdate) {
            return response()->json(['success' => true, 'message' => 'Plan updated successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Plan update failed']);
        }
    }

    public function exportCsv() {
        $fileName = "plans.csv";
        $plans = Plan::all();

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre",
            "Expires" => "0"
        );

        $columns = array('id', 'name', 'price', 'description');

        $callback = function() use ($plans, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach($plans as $plan) {
                fputcsv($file, array(
                    $plan->id,
                    $plan->name,
                    $plan->price,
                    $plan->description
                ));
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function delete(Request $request) {
        $plansDelete = Plan::where('id', '=', $request->id)->delete();

        if($plansDelete) {
            return response()->json(['success' => true, 'message' => 'Plan deleted successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Plan deletion failed']);
        }
    }

    
}
