<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>{{ __('Feed Planner') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- ================== BEGIN core-css ================== -->
    <link href="{{ asset('assets/css/vendor.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/custom.css') }}?timestamp={{ time() }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}"
        rel="stylesheet">
    <link href="{{ asset('assets/plugins/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css') }}"
        rel="stylesheet">
    <link href="{{ asset('assets/plugins/select-picker/dist/picker.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="{{ asset('assets/plugins/tag-it/css/jquery.tagit.css') }}" rel="stylesheet">
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css">




    <style>
        .drawer {
            height: 100%;
            width: 0;
            position: fixed;
            background-color: #f1f1f1;
            margin-left: 1313px;
            transform: translate(0, 0);
        }
    </style>
    <!-- ================== END core-css ================== -->

</head>

<body>
    <!-- BEGIN #app -->
    <div id="app" class="app">
        <div id="header" class="app-header">
            @include('admin.navbar')
        </div>

        <div id="sidebar" class="app-sidebar">
            <!-- BEGIN scrollbar -->
            <div class="app-sidebar-content" data-scrollbar="true" data-height="100%">
                @include('admin.sidebar')
            </div>
            <!-- END scrollbar -->
            <!-- BEGIN mobile-sidebar-backdrop -->
            <button class="app-sidebar-mobile-backdrop" data-dismiss="sidebar-mobile"></button>
            <!-- END mobile-sidebar-backdrop -->
        </div>
        <div id="content" class="app-content">
            @yield('contents')
        </div>

        <div class="modal fade" id="commonModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog " role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="commonModal"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">

                    </div>
                </div>
            </div>
        </div>

        <div class="modal drawer left-align" id="exampleModalLeft" tabindex="-1" aria-labelledby="exampleModalLabel"
            data-backdrop="static" data-keyboard="false" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-header">
                    <h5 class="modal-title1" id="exampleModalLeft"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="left-modal-body">

                </div>
            </div>
        </div>

        <!-- BEGIN theme-panel -->
        <!-- END theme-panel -->
    </div>
    <!-- END #app -->

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>

    <!-- ================== BEGIN core-js ================== -->
    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <!-- ================== END core-js ================== -->

    <!-- ================== BEGIN page-js ================== -->
    <script src="{{ asset('assets/plugins/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/js/demo/dashboard.demo.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables.net/js/dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/select-picker/dist/picker.min.js') }}"></script>
    <script src="{{ asset('assets/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-migrate/dist/jquery-migrate.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/tag-it/js/tag-it.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>
    <script>
        // $(function() {
        //     CountryData();
        // });


        $('#datatableDefault').DataTable({
            dom: "<'row mb-3'<'col-sm-4'l><'col-sm-8 text-end'<'d-flex justify-content-end'fB>>>t<'d-flex align-items-center mt-3'<'me-auto'i><'mb-0'p>>",
            lengthMenu: [10, 20, 30, 40, 50],
            responsive: false,
            paging: false,
            searching: false,
            info: false,
            autoWidth: false,
            buttons: []
            // buttons: [{
            //         extend: 'print',
            //         className: 'btn btn-default'
            //     },
            //     {
            //         extend: 'csv',
            //         className: 'btn btn-default'
            //     }
            // ]
        });

        var handleRenderSelectPicker = function() {
            $('#ex-search').picker({
                search: true
            });
        };

        $(document).ready(function() {
            handleRenderSelectPicker();
        });

        $(document).on('click', 'a[data-ajax-popup="true"], button[data-ajax-popup="true"], div[data-ajax-popup="true"]',
            function() {
                var title = $(this).data('title');
                var size = ($(this).data('size') == '') ? 'md' : $(this).data('size');
                var url = $(this).data('url');
                $("#commonModal .modal-title").html(title);
                $("#commonModal .modal-dialog").addClass('modal-' + size);
                $.ajax({
                    url: url,
                    success: function(data) {
                        $('#commonModal .modal-body').html(data);
                        $("#commonModal").modal('show');
                        commonLoader();
                        handleRenderSelectPicker();
                    },
                    error: function(data) {
                        data = data.responseJSON;
                        show_toastr('Error', data.error, 'error')
                    }
                });

            });

        // Common Modal from right side
        $(document).on('click',
            'a[data-ajax-popup-left="true"], button[data-ajax-popup-left="true"], div[data-ajax-popup-left="true"], span[data-ajax-popup-left="true"]',
            function() {
                var title = $(this).data('title');
                var url = $(this).data('url');
                $("#exampleModalLeft .modal-title1").html(title);
                $.ajax({
                    url: url,
                    cache: false,
                    success: function(data) {
                        $('#exampleModalLeft .left-modal-body').html(data);
                        $("#exampleModalLeft").modal('show');
                        document.getElementById("exampleModalLeft").style.width = "610px";
                        // commonLoader();
                    },
                    error: function(data) {
                        data = data.responseJSON;
                        console.log(data);
                        // show_toastr('Error', data.error, 'error')
                    }
                });
            });

        // function CountryData() {
        //     $.ajax({
        //         url: "{{ route('loadcountrydata') }}",
        //         type: 'POST',
        //         dataType: 'json',
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         },
        //         success: function(response) {
        //             console.log(response.message);
        //             // alert('Data loaded successfully.');
        //         },
        //         error: function(xhr, status, error) {
        //             console.error(xhr.responseJSON.error);
        //             // alert('Failed to load data.');
        //         }
        //     });
        // }

        function commonLoader() {
            if ($(".select2").length) {
                $('.select2').select2({
                    "language": {
                        "noResults": function() {
                            return "No result found";
                        }
                    },
                    placeholder: "Select a country",
                    allowClear: true
                });
            }
        }
    </script>
    <script>
        $(document).on('click', '.show_confirm', function(event) {
            var form = $(this).closest("form");
            var name = $(this).data("name");
            event.preventDefault();
            swal({
                    title: `Are you sure?`,
                    text: "This action can not be undone. Do you want to continue?",
                    icon: "warning",
                    buttons: ["No", "Yes"],
                    //   buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                    }
                });
        });


        function show_toastr(title, message, type) {
            var o, i;
            var icon = '';
            var cls = '';
            if (type == 'success') {
                icon = 'fas fa-check-circle';
                // cls = 'success';
                cls = 'success';
            } else {
                icon = 'fas fa-times-circle';
                cls = 'danger';
            }


            $.notify({
                icon: icon,
                title: " " + title,
                message: message,
                url: ""
            }, {
                element: "body",
                type: cls,
                allow_dismiss: !0,
                placement: {
                    from: 'top',
                    align: 'right'
                },
                offset: {
                    x: 15,
                    y: 15
                },
                spacing: 10,
                z_index: 1080,
                delay: 2500,
                timer: 2000,
                url_target: "_blank",
                mouse_over: !1,
                animate: {
                    enter: o,
                    exit: i
                },
                // danger
                template: '<div class="toast text-white bg-' + cls +
                    ' fade show" role="alert" aria-live="assertive" aria-atomic="true">' +
                    '<div class="d-flex">' +
                    '<div class="toast-body"> ' + message + ' </div>' +
                    '<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>' +
                    '</div>' +
                    '</div>'
                // template: '<div class="alert alert-{0} alert-icon alert-group alert-notify" data-notify="container" role="alert"><div class="alert-group-prepend alert-content"><span class="alert-group-icon"><i data-notify="icon"></i></span></div><div class="alert-content"><strong data-notify="title">{1}</strong><div data-notify="message">{2}</div></div><button type="button" class="close" data-notify="dismiss" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'
            });
        }
    </script>
    <!-- ================== END page-js ================== -->
    @stack('scripts')
    @if (Session::has('success'))
        <script>
            show_toastr('{{ __('Success') }}', '{!! session('success') !!}', 'success');
        </script>
    @endif
    @if (Session::has('error'))
        <script>
            show_toastr('{{ __('Error') }}', '{!! session('error') !!}', 'error');
        </script>
    @endif
</body>

</html>
