@extends('layout')

@section('content')
    <div class="card">
        <h1 style="margin-bottom: 20px;">Here is where we can manually update our listing collection from Eagle API</h1>

        <p>Some of these lists are really long and can take a minute or two to update</p>

        <h2>Get latest updated properties</h2>
        <p>Use this option to get only properties that were upated since last sync (recommended)</p>
        <a class="btn btn-primary" href="{{ route('update') }}">Update Listings</a>

        <hr>

        <h2>Sync active residential sales</h2>
        <p>Use this option to sync all the current residential sale listings</p>
        <a class="btn btn-primary" href="{{ route('create', ['status' => 'Active', 'listing_type' => 'residential_sale']) }}">Sync active residential sales</a>

        <hr>

        <h2>Sync let residential rentals</h2>
        <p>Use this option to sync all the current residential sale listings</p>
        <a class="btn btn-primary" href="{{ route('create', ['status' => 'Let', 'listing_type' => 'residential_rental']) }}">Sync let residential rentals</a>

        <hr>

        <h2>Sync active residential rentals</h2>
        <p>Use this option to sync all the current residential rental listings</p>
        <a class="btn btn-primary" href="{{ route('create', ['status' => 'Active', 'listing_type' => 'residential_rental']) }}">Sync active residential rentals</a>

        <hr>

        <h2>Sync active residential sold</h2>
        <p>Use this option to sync all the sold residential listings</p>
        <a class="btn btn-primary" href="{{ route('create', ['status' => 'Sold', 'listing_type' => 'residential_sale']) }}">Sync sold residential sales</a>
    </div>
@endsection