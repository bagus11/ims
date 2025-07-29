
<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', 'Admin')</title>
        <link rel="stylesheet" href="{{asset('css/app.css')}}">
      
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
      <!-- DataTables with Bootstrap 4 -->
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/datatables.net-bs4@1.13.7/css/dataTables.bootstrap4.min.css">

        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <!-- css.gg -->
        <link href="https://css.gg/css" rel="stylesheet" />

        <!-- UNPKG -->
        <link href="https://unpkg.com/css.gg/icons/icons.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!-- JSDelivr -->
        <link
          href="https://cdn.jsdelivr.net/npm/css.gg/icons/icons.css"
          rel="stylesheet"
        />
          <!-- Tempus Dominus Styles -->
         
          {{-- <link href="{{ asset('assets/select2/select2.min.css') }}" rel="stylesheet"> --}}

          <link href="{{ asset('assets/summernote/summernote.css') }}" rel="stylesheet">
    </head>
    <body class="hold-transition sidebar-mini">
        <div class="wrapper">
        @include('layouts.admin.navbar')
        @include('layouts.admin.sidebar')

        <div class="content-wrapper py-4">
            <input type="hidden" id="authId" value="{{auth()->user()->id}}">
            @yield('content')
        </div>


        <aside class="control-sidebar control-sidebar-dark overflow-auto">

            <div class="p-3">
              <h5>Title</h5>
              <p>Sidebar content</p>
            </div>
         
        </aside>
        @include('layouts.admin.footer')
        </div>
      
        <script src="{{asset('js/app.js')}}"></script>
        <script src="{{asset('js/accounting.min.js')}}"></script>
        {{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
        <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
        {{-- <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script> --}}
        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script> 
        {{-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
        <script src="{{ asset('assets/sweetalert2/sweetalert.min.js') }}"></script>
        <script src="{{ asset('assets/summernote/summernote.js') }}"></script>
        {{-- <script src="{{ asset('assets/select2/select2.full.min.js') }}"></script> --}}
        {{-- <script src="{{ asset('assets/select2/select2.full.min.js') }}"></script> --}}
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
        {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
        {{-- <script src="{{asset('js/chartjs-plugin-labels.js')}}"></script> --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.0.0-rc.1/chartjs-plugin-datalabels.min.js" 
        integrity="sha512-+UYTD5L/bU1sgAfWA0ELK5RlQ811q8wZIocqI7+K0Lhh8yVdIoAMEs96wJAIbgFvzynPm36ZCXtkydxu1cs27w==" crossorigin="anonymous" 
        referrerpolicy="no-referrer"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script>
        <!--Moment JS CDN-->
        <script src="https://momentjs.com/downloads/moment.js"></script>

        <!--Tempusdominus JS CDN-->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/js/tempusdominus-bootstrap-4.min.js"></script>

        <!--Tempusdominus CSS CDN-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/css/tempusdominus-bootstrap-4.min.css" />
        <script>
            $(document).on('click', '.dropdown-menu', function (e) {
              e.stopPropagation();
            });
            $(document).ready(function(){
                $(".select2").select2();
                $('.select2').select2({ dropdownCssClass: "selectOption2"});
                $.ajaxSetup({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                })
                $('.summernote').summernote({
                    tabsize: 2,
                    height: '270px',
                    toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                    ],
                    fontSizes: ['11']
                });

                $('#collapse_id').on('click', function(){
                
                  var x = document.getElementById("logo_container");
                  var y = document.getElementById("60_container");
                  if(window.getComputedStyle(y).display === "none"){
                    $('#60_container').prop('hidden', false);
                    $('#logo_container').prop('hidden', true);
                  }else{
                    $('#60_container').prop('hidden', true);
                    $('#logo_container').prop('hidden', false);

                  }
                })
            });
            toastr.options = {
              "closeButton": false,
              "debug": false,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-bottom-right",
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
            var url = window.location;
           // for sidebar menu entirely but not cover treeview
           $('ul.nav-sidebar a').filter(function() {
               return this.href == url;
           }).addClass('active');
       
           // for treeview
           $('ul.nav-treeview a').filter(function() {
               return this.href == url;
           }).parentsUntil(".nav-sidebar > .nav-treeview").addClass('menu-open').prev('a').addClass('');
       
           // Swal Loading
           function SwalLoading(html = 'Loading ...', title = '') {
              return Swal.fire({
                  title: title,
                  html: html,
            customClass: 'swal-wide',
                  timerProgressBar: true,
                  allowOutsideClick: false,
                  didOpen: () => {
                      Swal.showLoading()
                  }
              });
          }
       
          $(".select2").select2({ width: '300px', dropdownCssClass: "bigdrop" });
          
         
       </script>
       <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
       <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
       @include('helper.helper')
        @stack('custom-js')
 
    </body>
</html>
<style>
/* ============================
   FONT & GLOBAL
============================ */
body {
    font-family: 'Poppins', sans-serif !important;
    font-size: 10px !important;
}
p {
    font-size: 10px !important;
}
.myFont {
    font-size: 9px;
}

/* ============================
   SELECT2
============================ */
.select2 {
    width: 100% !important;
    font-size: 9px;
}
.select2-container--default .select2-selection--single {
    height: 35px !important;
    font-size: 9px;
}
.select2-selection__rendered {
    line-height: 25px !important;
    font-size: 9px;
}
.select2-selection__arrow {
    height: 34px !important;
    font-size: 9px;
}
.select2-container--default .select2-search__field,
.select2-container--default .select2-results__option,
.select2-container--default .select2-results__message {
    font-size: 9px;
}
.select2-dropdown {
    z-index: 1050;
}

/* ============================
   DATATABLES
============================ */
.datatable-bordered,
.datatable-stepper {
    font-family: Poppins, Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100% !important;
    font-size: 9px;
    border: 1px solid #ddd;
    overflow-x: auto !important;
}

.datatable-bordered td,
.datatable-bordered th,
.datatable-stepper td,
.datatable-stepper th {
    border: 1px solid #ddd;
    padding: 8px;
}

.datatable-bordered tr:nth-child(even),
.datatable-stepper tr:nth-child(even) {
    background-color: #f2f2f2;
}

.datatable-bordered tr:hover,
.datatable-stepper tr:hover {
    background-color: #ddd;
}

.datatable-bordered th,
.datatable-stepper th {
    padding: 10px 0;
    text-align: center;
    background-color: white;
    color: black;
}

.dataTables_scrollHeadInner,
.table {
    width: 100% !important;
    font-size: 9px;
}

/* Info & pagination text */
.dataTables_info {
    font-size: 10px;
    color: #b3acac;
}

/* Search box */
.dataTables_filter input {
    width: 300px;
    border-radius: 20px;
    border: 1px solid #ccc;
    padding: 5px 12px;
    font-size: 14px;
    transition: all 0.3s ease;
}
.dataTables_filter input:focus {
    border-color: #007bff;
    box-shadow: 0 0 4px rgba(0, 123, 255, 0.3);
}

/* Pagination buttons */
.dataTables_wrapper .dataTables_paginate .paginate_button {
    padding: 5px 12px;
    border-radius: 4px;
    margin: 0 2px;
    border: none;
    background: #f8f9fa;
    font-size: 9px !important;
    height: 30px !important;
    margin-top: 10px !important;
    transition: all 0.3s ease;
}
.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
    background: #007bff;
    color: #fff !important;
}
.dataTables_wrapper .dataTables_paginate .paginate_button.current {
    background: #007bff;
    color: #fff !important;
}

/* Sorting icon with FontAwesome */
table.dataTable thead .sorting:after,
table.dataTable thead .sorting_asc:after,
table.dataTable thead .sorting_desc:after {
    font-family: "Font Awesome 5 Free";
    font-weight: 900;
    opacity: 0.6;
    margin-left: 6px;
}
table.dataTable thead .sorting:after {
    content: "\f0dc"; /* sort */
}
table.dataTable thead .sorting_asc:after {
    content: "\f0de"; /* sort-up */
}
table.dataTable thead .sorting_desc:after {
    content: "\f0dd"; /* sort-down */
}

/* ============================
   BADGES
============================ */
.badge {
    min-width: 28px;
    border-radius: 4px;
    font-size: 9px;
}
.badge-orange {
    background-color: #FE7A36;
    color: black;
}
.badge-purple {
    background-color: #5D3587;
    color: white;
}

/* ============================
   TOAST
============================ */
.toast {
    width: 100%;
    margin: auto !important;
}

/* ============================
   COMPONENTS & UTILITIES
============================ */
.countMoney {
    text-align: end;
}
.nav-sidebar {
    overflow-y: auto;
}
.modal {
    overflow-y: auto !important;
}
.headerTitle {
    font-size: 14px;
}
.bg-core {
    background-color: #6B92A4 !important;
    color: white;
}
.card-radius {
    border-radius: 20px;
}
.card-radius-shadow {
    border-radius: 15px;
    filter: drop-shadow(5px 5px 5px rgba(0, 0, 0, 0.1));
}

/* ============================
   DETAILS ICONS (EXPAND/Collapse)
============================ */
th.details-control,
th.subdetails-control {
    background-color: #04AA6D;
    color: white;
}
td.details-control,
td.subdetails-control {
    background: url('https://datatables.net/examples/resources/details_open.png') no-repeat center center;
    cursor: alias;
}
tr.shown td.details-control,
tr.shown td.subdetails-control {
    background: url('https://datatables.net/examples/resources/details_close.png') no-repeat center center;
}
td.details-click,
td.subdetails-click {
    background: url('https://datatables.net/examples/resources/details_open.png') no-repeat center center;
    cursor: alias;
}
tr.shown td.details-click,
tr.shown td.subdetails-click {
    background: url('https://datatables.net/examples/resources/details_close.png') no-repeat center center;
}

/* ============================
   STAR RATING
============================ */
.rating {
    position: relative;
    width: 180px;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: .3em;
    padding: 5px;
    overflow: hidden;
    border-radius: 20px;
    box-shadow: 0 0 2px #b3acac;
}
.rating__result {
    position: absolute;
    top: 0;
    left: 0;
    transform: translateY(-10px) translateX(-5px);
    z-index: -9;
    font: 3em Arial, Helvetica, sans-serif;
    color: #ebebeb8e;
    pointer-events: none;
}
.rating__star {
    font-size: 1.3em;
    cursor: pointer;
    color: #dabd18b2;
    transition: filter linear .3s;
}
.rating__star:hover {
    filter: drop-shadow(1px 1px 4px gold);
}

/* ============================
   BUTTON ACTION
============================ */
.btnAction:hover {
    background-color: #1e8449;
    opacity: 1;
    transform: translateY(0);
    transition-duration: .35s;
}
.btnAction:active {
    transform: translateY(2px);
    transition-duration: .35s;
}
.btnAction:hover {
    box-shadow: rgba(39, 174, 96, .2) 0 6px 12px;
}

/* ============================
   FIELDSET & LEGEND
============================ */
fieldset.scheduler-border {
    border: 1px groove #ddd !important;
    padding: 0 1.5em 1.5em 1.5em !important;
    margin: 0 0 1.5em 0 !important;
    box-shadow: none;
}
legend.scheduler-border {
    font-size: 12px !important;
    font-weight: bold !important;
    text-align: left !important;
}

/* ============================
   ICONS
============================ */
ion-icon {
    zoom: 1.5;
    margin: auto;
}
.item ion-icon[item-left] + .item-inner,
.item ion-icon[item-left] + .item-input {
    margin-left: 10px !important;
}

/* ============================
   OPEN STATE COLORS
============================ */
.open\:bg-green-200[open] {
    background-color: rgb(187 247 208 / 1);
}
.open\:bg-red-600[open] {
    background-color: rgb(220 38 38 / 1);
}
.open\:bg-red-200[open] {
    background-color: rgb(254 202 202 / 1);
}
.open\:bg-amber-200[open] {
    background-color: rgb(253 230 138 / 1);
}
</style>
