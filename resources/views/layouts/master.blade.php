<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Garment Factory Management System">
    <meta name="author" content="Yuyuan Zhang">

    <title>{{config('app.name')}}</title>

    <link href="{{asset('master/css/app.css')}}" rel="stylesheet">
    <link href="{{asset('master/css/custom.css')}}" rel="stylesheet">
    @yield('style')
</head>

<body>
    <div class="wrapper">
        @include('layouts.aside')
        <div class="main">            
            @include('layouts.header')
            <main class="content">
                @yield('content')
            </main>
        </div>
    </div>

    <script src="{{asset('master/js/app.js')}}"></script>
    <script src="{{asset('master/js/custom.js')}}"></script>
    @yield('script')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // function showloader(){
        //     $("#ajax-loading").show();
        // }
        // $(document).ready(function(){
        //     $("#ajax-loading").hide();
        // });
    </script>

    <script>
        var notification = '<?php echo session()->get("success"); ?>';
        if(notification != ''){
            toastr_call("success","Success",notification);
        }
        var errors_string = '<?php echo json_encode($errors->all()); ?>';
        errors_string=errors_string.replace("[","").replace("]","").replace(/\"/g,"");
        var errors = errors_string.split(",");
        if (errors_string != "") {
            for (let i = 0; i < errors.length; i++) {
                const element = errors[i];
                toastr_call("error","Error",element);             
            } 
        }       

        function toastr_call(type,title,msg,override){
            toastr[type](msg, title,override);
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": true,
                "positionClass": "toast-top-center",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }  
        }
    </script>
</body>

</html>