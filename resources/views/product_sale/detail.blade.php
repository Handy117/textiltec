@extends('layouts.master')
@section('style')    
    <link rel="stylesheet" href="{{asset('master/plugins/imageviewer/css/jquery.verySimpleImageViewer.css')}}">
    <style>
        #image_preview {
            max-width: 600px;
            height: 600px;
        }
        .image_viewer_inner_container {
            width: 100% !important;
        }
    </style> 
@endsection
@section('content')
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3"><i class="fa fa-cubes"></i> Purchase Details</h1>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">                        
                        <div class="row">
                            <div class="col-lg-4"> 
                                <div class="card">
                                    <div class="card-header">
                                        <h2 class="card-title mb-0">{{__('page.customer')}}</h2>
                                    </div>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">{{__('page.name')}} :  @isset($sale->customer->name){{$sale->customer->name}}@endisset</li>
                                        <li class="list-group-item">{{__('page.email')}} :  @isset($sale->customer->email){{$sale->customer->email}}@endisset</li>
                                        <li class="list-group-item">{{__('page.phone')}} :  @isset($sale->customer->phone_number){{$sale->customer->phone_number}}@endisset</li>
                                        <li class="list-group-item">{{__('page.note')}} :  @isset($sale->customer->note){{$sale->customer->note}}@endisset</li>
                                    </ul>
                                </div> 
                                <div class="card">
                                    <div class="card-header">
                                        <h2 class="card-title mb-0">{{__('page.reference')}}</h2>
                                    </div>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">{{__('page.number')}} : {{$sale->reference_no}}</li>
                                        <li class="list-group-item">{{__('page.date')}}: {{$sale->timestamp}}</li>
                                        <li class="list-group-item">
                                            {{__('page.status')}}: 
                                            @if($sale->status == 0)
                                                <span class="badge badge-warning">{{__('page.pending')}}</span>
                                            @elseif($sale->status == 1)
                                                <span class="badge badge-warning">{{__('page.received')}}</span>
                                            @endif
                                        </li>
                                        <li class="list-group-item">
                                            {{__('page.attachment')}} : 
                                            @if ($sale->attachment != "")
                                                <a href="#" class="attachment" data-value="{{asset($sale->attachment)}}">&nbsp;&nbsp;&nbsp;<i class="fa fa-paperclip"></i></a>
                                            @endif
                                        </li>
                                    </ul>
                                </div> 
                                <div class="card">
                                    <div class="card-header">
                                        <h2 class="card-title mb-0">Purchas Note</h2>
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text">
                                            {{$sale->note}}
                                        </p>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <h3>Order Details</h3>
                                
                                <table class="table table-bordered table-colored table-info">
                                    <thead>
                                        <tr>
                                            <th class="wd-40">#</th>
                                            <th>{{__('page.product_name_code')}}</th>
                                            <th>{{__('page.price')}}</th>
                                            <th>{{__('page.quantity')}}</th>
                                            <th>{{__('page.subtotal')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $total_quantity = 0;
                                            $total_amount = 0;
                                            $paid = $sale->payments()->sum('amount');
                                        @endphp
                                        @foreach ($sale->orders as $item)
                                        @php
                                            $quantity = $item->quantity;
                                            $price = $item->price;
                                            $subtotal = $item->subtotal;
        
                                            $total_quantity += $quantity;
                                            $total_amount += $subtotal;
                                        @endphp
                                            <tr>
                                                <td>{{$loop->index+1}}</td>
                                                <td>@isset($item->product->name){{$item->product->name}} ({{$item->product->code}})@endisset</td>
                                                <td>{{number_format($item->price)}}</td>
                                                <td>{{$item->quantity}}</td>
                                                <td>{{number_format($item->subtotal)}}</td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="3" class="tx-bold" style="text-align:right">{{__('page.total')}} (COP)</td>
                                            <td>{{$total_quantity}}</td>
                                            <td>{{number_format($total_amount)}}</td>
                                        </tr>
                                    </tbody>
                                    <tfoot class="tx-bold tx-black">
                                        <tr>
                                            <td colspan="4" style="text-align:right">{{__('page.discount')}} (COP)</td>
                                            <td>
                                                @if(strpos( $sale->discount_string , '%' ) !== false)
                                                    {{$sale->discount_string}} ({{number_format($sale->discount)}})
                                                @else
                                                    {{number_format($sale->discount)}}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" style="text-align:right">{{__('page.shipping')}} (COP)</td>
                                            <td>
                                                @if(strpos( $sale->shipping_string , '%' ) !== false)
                                                    {{$sale->shipping_string}} ({{number_format($sale->shipping)}})
                                                @else
                                                    {{number_format($sale->shipping)}}
                                                @endif
                                            </td>
                                        </tr>
                                        
                                        <tr>
                                            <td colspan="4" style="text-align:right">{{__('page.returns')}}</td>
                                            <td>
                                                {{number_format($sale->returns)}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" style="text-align:right">{{__('page.total_amount')}} (COP)</td>
                                            <td>{{number_format($sale->grand_total)}}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" style="text-align:right">{{__('page.paid')}} (COP)</td>
                                            <td>{{number_format($paid)}}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" style="text-align:right">{{__('page.balance')}} (COP)</td>
                                            <td>{{number_format($sale->grand_total - $paid)}}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <div class="row mt-5">
                                    <div class="col-md-12 text-right">
                                        <a href="{{route('product_sale.index')}}" class="btn btn-success"><i class="fa fa-credit-card"></i>  {{__('page.product_sale')}}</a>
                                        <a href="{{route('payment.index', ['sale', $sale->id])}}" class="btn btn-info"><i class="fa fa-list"></i>  {{__('page.payment_list')}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="attachModal">
        <div class="modal-dialog" style="margin-top:17vh">
            <div class="modal-content">
                <div id="image_preview"></div>
                {{-- <img src="" id="attachment" width="100%" height="600" alt=""> --}}
            </div>
        </div>
    </div>
@endsection


@section('script')
    <script src="{{asset('master/plugins/imageviewer/js/jquery.verySimpleImageViewer.min.js')}}"></script>
    <script>
        $(document).ready(function(){
            
            $(".attachment").click(function(e){
                e.preventDefault();
                let path = $(this).data('value');
                console.log(path)
                // $("#attachment").attr('src', path);
                $("#image_preview").html('')
                $("#image_preview").verySimpleImageViewer({
                    imageSource: path,
                    frame: ['100%', '100%'],
                    maxZoom: '900%',
                    zoomFactor: '10%',
                    mouse: true,
                    keyboard: true,
                    toolbar: true,
                });
                $("#attachModal").modal();
            });
            
        });
    </script>
@endsection
                    