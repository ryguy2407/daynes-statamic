@extends('layout')

@section('content')
    <div class="card" id="vueApp">
        <h1 style="margin-bottom: 20px;">Synced Listings</h1>

        <div class="loading">Loading...this can take a while. Feel free to navigate away, grab a coffee etc.</div>
        <div class="message"></div>

    </div>
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        $.ajax({
            url: "http://daynesproperty.test/cp/addons/c-r-m-listings/sync?status={{ request('status') }}&listing_type={{ request('listing_type') }}",
            success: function(result) {
                $('div.loading').hide();
                console.log(result);
                result.forEach(function(data){
                    $('div.message').append('<li>'+data.attributes.full_address+'</li>')
                });
            }
        });
    });
</script>