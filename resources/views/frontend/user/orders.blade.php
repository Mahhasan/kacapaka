@extends('frontend.user.layouts.app')
@section('content')
<div class="container">
    <div class="">
        <div>
            <h2 class="text-center">My Orders</h2>
        </div>
        <div class="py-5">
            <table class="table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>023568</td>
                        <td>2-3-2024</td>
                        <td>Pending</td>
                        <td>500 BDT</td>
                    </tr>
                    <tr>
                        <td>023525</td>
                        <td>2-3-2024</td>
                        <td>Deliverd</td>
                        <td>800 BDT</td>
                    </tr>
                    <tr>
                        <td>023565</td>
                        <td>2-3-2024</td>
                        <td>Processing</td>
                        <td>1000 BDT</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection