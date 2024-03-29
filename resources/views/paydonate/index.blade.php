@extends('layouts.master')

@section('css')
<link href="{{ URL::asset('assets/libs/chartist/chartist.min.css')}}" rel="stylesheet" type="text/css" />
@include('layouts.datatable')
@endsection

@section('content')
<div class="row align-items-center">
    <div class="col-sm-6">
        <div class="page-title-box">
            <h4 class="font-size-18">Carian Derma</h4>
            <!-- <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item active">Welcome to Veltrix Dashboard</li>
            </ol> -->
        </div>
    </div>
</div>
<div class="row">

    <div class="col-md-12">
        <div class="card card-primary">

            @if(count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            {{csrf_field()}}
            <div class="card-body">

                <div class="form-group">
                    <label>Nama Organisasi</label>
                    <select name="organization" id="organization" class="form-control">
                        <option value="" selected>Semua Organisasi</option>
                        @foreach($organization as $row)
                        <option value="{{ $row->id }}">{{ $row->nama }}</option>
                        @endforeach
                    </select>
                </div>


            </div>

            <div class="">
                <button onclick="filter()" style="float: right" type="submit" class="btn btn-primary"><i
                        class="fa fa-search"></i>
                    Tapis</button>
            </div>

        </div>
    </div>

    <div class="col-md-12">
        <div class="card">

            <div class="card-body">

                @if(count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                @if(\Session::has('success'))
                <div class="alert alert-success">
                    <p>{{ \Session::get('success') }}</p>
                </div>
                @endif

                <div class="table-responsive">
                    <table id="donationTable" class="table table-bordered table-striped">
                        <thead>
                            <tr style="text-align:center">
                                <th> No. </th>
                                <th> Nama Derma </th>
                                <th> Penerangan </th>
                                <th> Status </th>
                                <th> Action </th>
                            </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection


@section('script')
<!-- Peity chart-->
<script src="{{ URL::asset('assets/libs/peity/peity.min.js')}}"></script>

<!-- Plugin Js-->
<script src="{{ URL::asset('assets/libs/chartist/chartist.min.js')}}"></script>

<script src="{{ URL::asset('assets/js/pages/dashboard.init.js')}}"></script>

<script>
    $(document).ready(function(){

        fetch_data();

        function fetch_data(oid = '')
        {
            $('#donationTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url:"{{ route('donate.donationlist') }}",
                    data:{ 
                        oid:oid,
                        hasOrganization: false
                    },
                    type: 'GET',
                   
                },
                order: [[ 1, 'asc' ]],
                columns:[
                        { 
                            "data": null,
                            searchable: false,
                            "sortable": false, 
                            render: function (data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }  
                        },
                        { 
                            data: "nama",
                            name: 'nama'
                        },
                        { 
                            data: "description",
                            name: 'description'
                        },
                        { 
                            data: 'status', 
                            name: 'status', 
                            orderable: false, 
                            searchable: false
                        },
                        {
                            data: 'action', 
                            name: 'action', 
                            orderable: false, 
                            searchable: false
                        },
                    ]
            });
        }

        $('#organization').change(function(){
            var organizationid      = $("#organization option:selected").val();

            $('#donationTable').DataTable().destroy();

            fetch_data(organizationid);
        });
        

    });

</script>
@endsection