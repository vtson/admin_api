<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use http\Env\Response;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(){
        $order = Order::paginate();

        return OrderResource::collection($order);
    }

    public function show($id){
        return new OrderResource(Order::find($id));
    }

    public function export(){
        $header = [
            "Content-type" => "text/csv",
            'Content-Disposition' => "attachment; filename=orders.csv",
            "pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function(){
            $orders = Order::all();
            $file = fopen('php://output', 'w');

            fputcsv($file, ['ID', 'Name', 'Email', 'Product Title', 'Price', 'Quantity']);

            foreach ($orders as $order){
                fputcsv($file, [$order->id, $order->name, $order->email, '', '', '']);

                foreach ($order->orderItems as $orderItem){
                    fputcsv($file, ['', '', '', $orderItem->product_title, $orderItem->price, $orderItem->quantity]);
                }
            }

            fclose($file);
        };

        return \Illuminate\Support\Facades\Response::stream($callback, 200, $header);
    }
}
