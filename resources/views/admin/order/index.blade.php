@extends('layouts.admin')

@section('body')
<div class="card">

    <div class="card-body">

        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <strong>Success!</strong> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <strong>Error!</strong> Please check the form below for errors.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif




        <div class="m-t-25">
            <table id="data-table" class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Order Number</th>
                        <th>Customer Name</th>
                        <th>Total Price</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $key => $order)
                    <tr>
                        <td>{{ ++$key }}</td>
                        <td>{{ $order->order_number }}</td>
                        <td>
                            @if($order->user)
                            <button type="button" class="btn btn-default" data-toggle="modal"
                                data-target="#customerDetailModal-{{ $order->user->id }}">
                                {{ $order->user->name }}
                            </button>
                            @else
                            <span>Guest User</span>
                            @endif

                            @if ($order->user)
                            <!-- Customer Detail Modal -->
                            <div class="modal fade" id="customerDetailModal-{{ $order->user->id }}" tabindex="-1"
                                role="dialog" aria-labelledby="customerDetailModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="customerDetailModalLabel">Customer Details:
                                                {{ $order->user->name }}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <h6>Email: {{ $order->user->email }}</h6>
                                            <h6>Phone: {{ $order->user->phone }}</h6>
                                            <h6>Orders Count:
                                                {{ App\Models\Order::where("user_id", $order->user->id)->count() }}</h6>
                                            <h6>Orders Total Amount:
                                                {{ number_format(App\Models\Order::where("user_id", $order->user->id)->sum("total_price"), 1) }}
                                                $</h6>
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Order No</th>
                                                        <th>Price</th>
                                                        <th>Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                    $userOrders = App\Models\Order::where("user_id", $order->user->id)
                                                    ->orderBy("id", "desc")
                                                    ->get(["order_number", "total_price", "created_at"]);
                                                    @endphp

                                                    @foreach($userOrders as $userOrder)
                                                    <tr>
                                                        <td>{{ $userOrder->order_number }}</td>
                                                        <td>{{ number_format($userOrder->total_price, 1) }} $</td>
                                                        <td>{{ $userOrder->created_at->format('F j, Y') }}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </td>
                        <td>
                            {{ $order->total_price }} ¥
                            @php 
                                $cupon_code_id = $order->cupon_code_id ?? null;
                                
                            @endphp
                            @if($cupon_code_id == "AAA")
                                {{ $order->total_price }} ¥
                            @elseif($cupon_code_id == "AAA")
                                @php
                                    $cupon_type = $order->CuponCode->type;
                                    $cupon_amount = $order->CuponCode->amount;
                                    $original_price = $order->total_price;
                                    if($cupon_type == 1){
                                            $after_discount_price = $original_price - $cupon_amount;
                                            echo $after_discount_price . "¥";
                                        }elseif($cupon_type == 2){
                                            $after_discount_price = $original_price - ($original_price * ($cupon_amount / 100));
                                            echo $after_discount_price . "¥";
                                        }
                                @endphp
                              
                            @endif
                           
                        </td>
                        <td>
                            <!-- Status and Form to Update -->
                            @if(in_array($order->status, [1, 4]))
                            <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <select name="status" onchange="this.form.submit()" class="form-control">
                                    <option value="1" {{ $order->status == 1 ? 'selected' : '' }}>Pending</option>
                                    <option value="2" {{ $order->status == 2 ? 'selected' : '' }}>Confirmed</option>
                                    <option value="3" {{ $order->status == 3 ? 'selected' : '' }}>Cancelled</option>
                                    <option value="4" {{ $order->status == 4 ? 'selected' : '' }}>Payment Pending
                                    </option>
                                </select>
                            </form>
                            @else
                            <p style="color:{{ $order->status == 2 ? 'green' : 'red' }};">
                                {{ $order->status == 2 ? 'Confirmed' : ($order->status == 3 ? 'Cancelled' : 'Payment Pending') }}
                            </p>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-info">
                                <i class="anticon anticon-eye"></i>
                            </a>
                          <form action="{{ route('admin.order.delete.hard') }}" method="POST" onsubmit="return confirm('Are You Sure To Delete This ?')">
                            @csrf
                                @method('POST')
                                <input type="hidden"  name="id" value="{{$order->id}}">
                                <button type="submit" class="btn btn-danger">
                                    <i class="anticon anticon-delete"></i>
                                </button>
                            </form>

                           
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection