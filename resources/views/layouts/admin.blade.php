
<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', 'Admin')</title>
        <link rel="stylesheet" href="{{asset('css/app.css')}}">
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
        <link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <!-- css.gg -->
        <link href="https://css.gg/css" rel="stylesheet" />

        <!-- UNPKG -->
        <link href="https://unpkg.com/css.gg/icons/icons.css" rel="stylesheet" />

        <!-- JSDelivr -->
        <link
          href="https://cdn.jsdelivr.net/npm/css.gg/icons/icons.css"
          rel="stylesheet"
        />
          <!-- Tempus Dominus Styles -->
          <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
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
   /* body {
        font-family: poppins !important;
        font-size: 1.2em !important;
    } */
 /* Font size for the Select2 container */
.select2-container--default .select2-selection--single {
    font-size: 9px; /* Adjust font size for the selected item */
}

/* Font size for the dropdown search input */
.select2-container--default .select2-search__field {
    font-size: 9px; /* Adjust font size for the search input field */
}

/* Font size for dropdown options */
.select2-container--default .select2-results__option {
    font-size: 9px; /* Adjust font size for dropdown options */
}

/* Font size for no results found message */
.select2-container--default .select2-results__message {
    font-size: 9px; /* Adjust font size for no results found message */
}
.select2-dropdown {
    z-index: 1050; /* Make sure it appears above other elements */
}

  .badge-orange{
    background-color: #FE7A36;
    color : black
  }
  .badge-purple{
    background-color: #5D3587;
    color : white
  }
  .toast{
    width:100%; 
    margin : auto !important;
    /* background-position: 35% !important; */
  }
  .page-link
  {
    font-size: 9px !important;
    height: 30px !important;  
    margin-top:10px !important; 
  }
.datatable-bordered{
  font-family: Poppins;
  border-collapse: collapse;
  width: 100% !important;
  font-size: 9px;
  overflow-x:auto !important;
  
  }
  .nav-sidebar{
    overflow-y: auto;
  }
  .dataTables_filter input { width: 300px }
  .datatable-bordered td, .datatable-bordered th {
  padding: 8px;
  }
  .datatable-bordered tr:nth-child(even){background-color: #f2f2f2;}

  .datatable-bordered tr:hover {background-color: #ddd;}
  .countMoney{
    text-align: end
  }
  .datatable-bordered th {
  border: 1px solid #ddd;
  padding-top: 10px;
  padding-bottom: 10px;
  text-align: center;
  background-color: white;
  color: black;
  overflow-x:auto !important;
  }

  ion-icon
    {
     zoom: 1.5;
     margin:auto
    }
.select2{
    width: 100% !important;
    font-size:9px;
}
.select2-selection__rendered {
    line-height: 25px !important;
    font-size:9px;
  
}
.badge {
    min-width: 28px;
    border-radius: 4px;
}
.select2-container .select2-selection--single {
    height: 35px !important;
    font-size:9px;
}
.modal {
  overflow-y:auto !important;
}
.select2-selection__arrow {
    height: 34px !important;
    font-size:9px;
}

.dataTables_scrollHeadInner, .table{
     width:100%!important; 
     font-size:9px;
}
p{
  font-size: 10px !important;
}
.open\:bg-green-200[open] {
  --tw-bg-opacity: 1;
  background-color: rgb(187 247 208 / var(--tw-bg-opacity));
}
.open\:bg-red-600[open] {
  --tw-bg-opacity: 1;
  background-color: rgb(220 38 38 / var(--tw-bg-opacity));
}
.open\:bg-red-200[open] {
  --tw-bg-opacity: 1;
  background-color: rgb(254 202 202 / var(--tw-bg-opacity));

}
.open\:bg-amber-200[open] {
  --tw-bg-opacity: 1;
  background-color: rgb(253 230 138 / var(--tw-bg-opacity));
}
th.details-control {
  background-color: #04AA6D;
  color: white;
}
td.details-control {
background: url('https://datatables.net/examples/resources/details_open.png') no-repeat center center;
cursor: alias;
}
tr.shown td.details-control {
    background: url('https://datatables.net/examples/resources/details_close.png') no-repeat center center;
}

td.details-click {
    background: url('https://datatables.net/examples/resources/details_open.png') no-repeat center center;
    cursor: alias;
}
tr.shown td.details-click {
    background: url('https://datatables.net/examples/resources/details_close.png') no-repeat center center;
}

th.subdetails-control {
  background-color: #04AA6D;
  color: white;
}
td.subdetails-control {
background: url('https://datatables.net/examples/resources/details_open.png') no-repeat center center;
cursor: alias;
}
tr.shown td.subdetails-control {
    background: url('https://datatables.net/examples/resources/details_close.png') no-repeat center center;
}

td.subdetails-click {
    background: url('https://datatables.net/examples/resources/details_open.png') no-repeat center center;
    cursor: alias;
}
tr.shown td.subdetails-click {
    background: url('https://datatables.net/examples/resources/details_close.png') no-repeat center center;
}
.rating {
   position: relative;
   width: 180px;
   background: transparent;
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
.datatable-stepper{
  /* font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100% !important;
  font-size: 12px;
  overflow-x:auto !important; */
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  border-spacing: 0;
  font-size: 9px;
  width: 100% !important;
  border: 1px solid #ddd;
  
  }
  .datatable-stepper tr:nth-child(even){background-color: #f2f2f2;}

  .datatable-stepper tr:hover {background-color: #ddd;}

  .datatable-stepper th {
  border: 1px solid #ddd;
  padding-top: 10px;
  padding-bottom: 10px;
  text-align: center;
  
  color: black;
  overflow-x:auto !important;
  }
  .datatable-stepper td, .datatable-stepper th {
        border: 1px solid #ddd;
        padding: 8px;
       
    }
  .headerTitle{
    font-size: 14px;

  }
  fieldset.scheduler-border {
        border: 1px groove #ddd !important;
        padding: 0 1.5em 1.5em 1.5em !important;
        margin: 0 0 1.5em 0 !important;
        -webkit-box-shadow:  0px 0px 0px 0px #000;
                box-shadow:  0px 0px 0px 0px #000;
    }

    legend.scheduler-border {
        font-size: 12px !important;
        font-weight: bold !important;
        text-align: left !important;
    }
    .btnAction :hover {
      background-color: #1e8449;
      opacity: 1;
      transform: translateY(0);
      transition-duration: .35s;
    }

    .btnAction :active {
      transform: translateY(2px);
      transition-duration: .35s;
    }

    .btnAction :hover {
      box-shadow: rgba(39, 174, 96, .2) 0 6px 12px;
    }
    .myFont{
      font-size:9px
    }
    .bg-core{
      background-color: #6B92A4 !important;
      color: white ;
    }
    .card-radius{
      border-radius: 20px;
    }
    .card-radius-shadow{
      border-radius: 15px;
      /* box-shadow: 5px 5px rgb(0 0 0 / 0.2); */
      filter: drop-shadow(5px 5px 5px rgba(0,0,0,0.1));
    }
    .dataTables_info{
      font-size: 10px;
      color: #b3acac;
    }
    .item ion-icon[item-left]+.item-inner,
    .item ion-icon[item-left]+.item-input {
        margin-left: 10px !important;
    }
    .table{
      style=" font-family: 'Poppins', sans-serif;"
    }
</style>