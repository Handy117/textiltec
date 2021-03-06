@extends('layouts.master')
@section('style')
    <link href="{{asset('master/plugins/jquery-ui/jquery-ui.css')}}" rel="stylesheet">
    <link href="{{asset('master/plugins/jquery-ui/timepicker/jquery-ui-timepicker-addon.min.css')}}" rel="stylesheet">
    <script src="{{asset('master/plugins/vuejs/vue.js')}}"></script>
    <script src="{{asset('master/plugins/vuejs/axios.js')}}"></script>
@endsection
@section('content')
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3"><i class="fa fa-cubes"></i> {{__('page.edit_production_order')}}</h1>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form class="form-layout form-layout-1" action="{{route('produce_order.update')}}" method="POST" enctype="multipart/form-data" id="app">
                            @csrf
                            <input type="hidden" name="id" value="{{$order->id}}" id="order_id">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="col-form-label">{{__('page.production_order_date')}} <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="date" id="purchase_date" v-model="date" placeholder="{{__('page.production_order_date')}}" autocomplete="off" required>
                                        @error('date')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">{{__('page.reference_number')}} <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="reference_number"  v-model="reference_no" required placeholder="{{__('page.reference_number')}}">
                                        @error('reference_number')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">{{__('page.workshop')}} <span class="text-danger">*</span></label>
                                        <div class="input-group">                                  
                                            <select class="form-control" name="workshop" required>
                                                <option label="{{__('page.select_workshop')}}"></option>
                                                @foreach ($workshops as $item)
                                                    <option value="{{$item->id}}" @if($order->workshop_id == $item->id) selected @endif>{{$item->name}}</option>
                                                @endforeach
                                            </select> 
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">{{__('page.product')}} <span class="text-danger">*</span></label>
                                        <div class="input-group">                                  
                                            <select class="form-control select2" name="product" id="search_product" required data-placeholder="{{__('page.select_product')}}">
                                                <option label="{{__('page.select_product')}}"></option>
                                                @foreach ($products as $item)
                                                    <option value="{{$item->id}}" @if($order->product_id == $item->id) selected @endif>{{$item->name}}</option>
                                                @endforeach
                                            </select>
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-primary btn-rounded tx-white ml-1" id="btn-add-product"><i class="fa fa-plus"></i></button>
                                            </div>  
                                        </div>
                                        @error('product')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">{{__('page.quantity')}} <span class="text-danger">*</span></label>
                                        <input class="form-control" type="number" name="product_quantity" v-model="product_quantity" required placeholder="{{__('page.quantity')}}">
                                        @error('product_quantity')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">{{__('page.main_image')}}</label>
                                        <input type="file" name="main_image" id="file2" class="form-control file-input-styled" accept="image/*">
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">{{__('page.gallery_images')}}</label>
                                        <input type="file" name="gallery_images[]" id="file2" class="form-control file-input-styled" accept="image/*, video/*" multiple />
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">{{__('page.responsibility')}}</label>
                                        <input type="text" class="form-control" name="responsibility" v-model="responsibility" placeholder="{{__('page.responsibility')}}" />
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">{{__('page.description')}}</label>
                                        <input type="text" class="form-control" name="description" v-model="description" placeholder="{{__('page.description')}}" />
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">{{__('page.deadline')}} <span class="text-danger">*</span></label>
                                        <input class="form-control" type="number" name="deadline" v-model="deadline" required placeholder="{{__('page.deadline')}}">
                                        @error('deadline')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <h3><i class="align-middle" data-feather="image"></i> {{__('page.image_gallery')}}</h3>
                                    <div class="row"> 
                                        @php
                                            $image_array = array('jpg', 'png', 'jpeg', 'gif');
                                            $video_array = array('avi', 'mp4', 'mpg');                                
                                        @endphp                                  
                                        @foreach ($order->images as $item)  
                                            @php
                                                $filename = basename($item->path);
                                                $extension = pathinfo($item->path, PATHINFO_EXTENSION);
                                            @endphp                                      
                                            <div class="col-md-4 image-container">
                                                <div class="card card-body">
                                                    <button type="button" data-id="{{$item->id}}" class="close remove-image" data-dismiss="alert" style="position:absolute;top:5px;right:10px;" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    <input type="hidden" name="original_galleries[]" value="{{$item->id}}">
                                                    @if (in_array($extension, $image_array))
                                                        <img class="gallery-image" width="100%" height="160" src="{{asset($item->path)}}" alt="" class="img-fluid" />
                                                    @elseif(in_array($extension, $video_array))
                                                        <video class="gallery-video" width="100%" height="160" src="{{asset($item->path)}}" controls autoplay><source src="{{asset($item->path)}}"></video>
                                                    @else
                                                        <a href="{{asset($item->path)}}" download>{{$filename}}</a>
                                                    @endif
                                                        {{-- <img src="{{asset($item->path)}}" width="100%" alt="" class="img-fluid"> --}}
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div>
                                        <h5 class="my-1" style="float:left">{{__('page.supply_list')}}</h5>
                                        {{-- <button type="button" class="btn btn-primary mg-b-10 add-product" style="float:right">ADD</button> --}}
                                        <a href="#" class="btn btn-sm btn-primary mb-2 add-product" style="float:right" @click="add_item()" title="{{__('page.right_ctrl_key')}}"><div><i class="fa fa-plus"></i>{{__('page.add')}}</div></a>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="supply_order_table">
                                            <thead class="table-success">
                                                <tr>
                                                    <th>{{__('page.name')}}</th>
                                                    <th>{{__('page.cost')}}</th>
                                                    <th>{{__('page.average_quantity')}}</th>
                                                    <th>{{__('page.total_quantity')}}</th>
                                                    <th>{{__('page.unit')}}</th>
                                                    <th>{{__('page.subtotal')}}</th>
                                                    <th style="width:30px"></th>
                                                </tr>
                                            </thead>
                                            <tbody class="top-search-form">
                                                <tr v-for="(item,i) in order_items" :key="i">
                                                    <td>
                                                        <select class="form-control form-control-sm supply" name="supply_id[]" v-model="item.supply_id" @change="get_supply(i)">
                                                            <option value="" hidden>{{__('page.select_supply')}}</option>
                                                            <option :value="supply.id" v-for="(supply, i) in supplies" :key="i">@{{supply.name}}(@{{supply.code}})</option>
                                                        </select>
                                                    </td>
                                                    <td><input type="number" class="form-control form-control-sm cost" name="cost[]" v-model="item.cost" required placeholder="{{__('page.cost')}}" /></td>
                                                    <td><input type="number" class="form-control form-control-sm quantity" name="quantity[]" min="0" step="0.01" v-model="item.quantity" required placeholder="{{__('page.quantity')}}" /></td>
                                                    <td> @{{(item.quantity * product_quantity).toFixed(2)}}</td>
                                                    <td> @{{item.unit}}</td>
                                                    <td class="subtotal">
                                                        @{{formatPrice(item.sub_total)}}
                                                        <input type="hidden" name="subtotal[]" :value="item.sub_total" />
                                                        <input type="hidden" name="order_id[]" :value="item.order_id" />
                                                    </td>
                                                    <td align="center">
                                                        <a href="#" class="btn btn-sm btn-success remove-product" @click="remove(i)"><i class="fa fa-times"></i></a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="5">{{__('page.total')}}</td>
                                                    {{-- <td class="total_quantity">@{{total.quantity}}</td> --}}
                                                    <td class="total" colspan="2">
                                                        @{{formatPrice(total.cost)}}
                                                        <input type="hidden" name="supply_cost" :value="total.cost" />
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <div class="row my-3">                        
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label class="col-form-label col-md-5 text-sm-right">{{__('page.manufacturing_cost')}} :</label>
                                                <div class="col-md-7">
                                                    <input type="text" name="manufacturing_cost" class="form-control" v-model="manufacturing_cost" placeholder="{{__('page.manufacturing_cost')}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 col-md-6 col-xl d-flex">
                                            <div class="card flex-fill">
                                                <div class="card-body py-4">
                                                    <div class="row">
                                                        <div class="col-8">
                                                            <h3 class="mb-2">@{{formatPrice((total.cost * product_quantity).toFixed(2))}}</h3>
                                                            <div class="mb-0">{{__('page.supply_cost')}}</div>
                                                        </div>
                                                        <div class="col-4 ml-auto text-right">
                                                            <div class="d-inline-block mt-2">
                                                                <i class="feather-lg text-primary" data-feather="truck"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl d-flex">
                                            <div class="card flex-fill">
                                                <div class="card-body py-4">
                                                    <div class="row">
                                                        <div class="col-8">
                                                            <h3 class="mb-2">@{{formatPrice(manufacturing_cost * product_quantity)}}</h3>
                                                            <div class="mb-0">{{__('page.manufacturing_cost')}}</div>
                                                        </div>
                                                        <div class="col-4 ml-auto text-right">
                                                            <div class="d-inline-block mt-2">
                                                                <i class="feather-lg text-danger" data-feather="dollar-sign"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl d-flex">
                                            <div class="card flex-fill">
                                                <div class="card-body py-4">
                                                    <div class="row">
                                                        <div class="col-8">
                                                            <h3 class="mb-2">
                                                                @{{formatPrice(total_cost * product_quantity)}}
                                                                <input type="hidden" name="total_cost" :value="total_cost" />
                                                                <input type="hidden" name="production_cost" :value="total_cost * product_quantity" />
                                                            </h3>
                                                            <div class="mb-0">{{__('page.total_cost')}}</div>
                                                        </div>
                                                        <div class="col-4 ml-auto text-right">
                                                            <div class="d-inline-block mt-2">
                                                                <i class="feather-lg text-info" data-feather="dollar-sign"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                    
                                    <div class="form-layout-footer mt-5 text-right">
                                        <button type="submit" class="btn btn-lg btn-primary mr-2"><i class="fa fa-check"></i>  {{__('page.save')}}</button>
                                        <a href="{{route('produce_order.index')}}" class="btn btn-lg btn-warning"><i class="fa fa-times"></i>  {{__('page.cancel')}}</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addProductModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{__('page.add_product')}}</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <form action="" id="create_form" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label">{{__('page.name')}}</label>
                            <input class="form-control name" type="text" name="name" placeholder="{{__('page.name')}}">
                            <span id="name_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">{{__('page.code')}}</label>
                            <input class="form-control code" type="text" name="code" placeholder="{{__('page.code')}}">
                            <span id="name_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">{{__('page.description')}}</label>
                            <input class="form-control description" type="text" name="description" placeholder="{{__('page.description')}}">
                            <span id="descriptione_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>
                    </div>    
                    <div class="modal-footer">
                        <button type="button" id="btn_create" class="btn btn-primary btn-submit"><i class="fa fa-check mg-r-10"></i>&nbsp;{{__('page.save')}}</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times mg-r-10"></i>&nbsp;{{__('page.close')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@section('script')
    <script src="{{asset('master/plugins/uniform/uniform.min.js')}}"></script>    
    <script src="{{asset('master/plugins/jquery-ui/jquery-ui.js')}}"></script>
    <script src="{{asset('master/plugins/jquery-ui/timepicker/jquery-ui-timepicker-addon.min.js')}}"></script>    
    <script src="{{ asset('master/js/produce_edit_order_items.js') }}"></script>
    <script>
        $(document).ready(function(){
            $('.file-input-styled').uniform({
                fileButtonClass: 'action btn bg-primary tx-white'
            });
            $('.select2').each(function() {
                $(this)
                    .wrap('<div class="position-relative" style="width: calc(100% - 40px)"></div>')
                    .select2({
                        width: 'resolve',
                        placeholder: '{!! __('page.product_supplier') !!}'
                    });                    
            });
            $("#purchase_date").datetimepicker({
                dateFormat: 'yy-mm-dd',
            });
            $(".expiry_date").datepicker({
                dateFormat: 'yy-mm-dd',
            });

            $(".remove-image").click(function(){
                let sure = window.confirm("{{__('page.are_you_sure')}}");
                console.log(sure);
                if(sure == true){
                    $(this).parents('.image-container').remove();
                }else{
                    return false;
                }
            });

            $("#btn-add-product").click(function(){
                $("#create_form input.form-control").val('');
                $("#create_form .invalid-feedback strong").text('');
                $("#addProductModal").modal();
            });

            $("#btn_create").click(function(){
                $("#ajax-loading").show();
                $.ajax({
                    url: "{{route('product.produce_create')}}",
                    type: 'post',
                    dataType: 'json',
                    data: $('#create_form').serialize(),
                    success : function(data) {
                        $("#ajax-loading").hide();
                        if(data.id != null) {
                            $("#addProductModal").modal('hide');
                            $("#search_product").append(`
                                <option value="${data.id}">${data.name}</option>
                            `).val(data.id);
                        }
                        else if(data.message == 'The given data was invalid.') {
                            alert(data.message);
                        }
                    },
                    error: function(data) {
                        $("#ajax-loading").hide();
                        console.log(data.responseJSON);
                        if(data.responseJSON.message == 'The given data was invalid.') {
                            let messages = data.responseJSON.errors;
                            if(messages.name) {
                                $('#name_error strong').text(data.responseJSON.errors.name[0]);
                                $('#name_error').show();
                                $('#create_form .name').focus();
                            }
                            
                            if(messages.code) {
                                $('#code_error strong').text(data.responseJSON.errors.code[0]);
                                $('#code_error').show();
                                $('#create_form .code').focus();
                            }
                        }
                    }
                });
            });
        });
    </script>
@endsection
                    