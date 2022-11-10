@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <b>{{ __('Product List') }}</b>
                    <div>
                        <a  href="{{url('/createView')}}" class="btn btn-sm btn-primary">Add</a>
                    <table class="table table-bordered" id="ptable">
                        <thead>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Sku</th>
                            <th>Price</th>
                            <th>Image</th>
                            <th>Status</th>
                            <th>Action</th>
                        </thead>
                        <tbody>

                        </tbody>
                       </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
