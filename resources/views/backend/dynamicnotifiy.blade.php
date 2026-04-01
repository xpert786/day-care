@foreach ($notifications as  $notifications)
@if($notifications->type == 1)
<a style="text-decoration:none;" href="{{url('viewCustomerDetail/'.$notifications->user_id)}}" target="_blank">
@elseif($notifications->type == 2)
<a style="text-decoration:none;" href="{{url('viewProviderDetail/'.$notifications->user_id)}}" target="_blank">
@endif
<div class="col-12 shadow-sm p-2 m-1 mt-3 mb-3 bar-border"  >
    <div class="row notifaction-bar">
      <div class="col-3 col-md-1 notifaction-name-A" >
            <p>{{$notifications->id}}</p>
      </div>
      <div class="col-6 col-md-9">
        <p class="lign">
            @if($notifications->type == 1)
            New customer registered 
            @elseif($notifications->type == 2)
            New service provider registered
            @endif
        </p>
      </div>
      <div class="col-3 col-md-2 text-end m-0">
        <p><?php echo date_format($notifications->created_at,"d-m-Y g:i:a") ?></p>
        {{-- <p><i class="fa fa-times-circle-o text-danger" aria-hidden="true"></i></p> --}}
      </div>
    </div>

  </div>
  </a>
@endforeach
{{-- created_at --}}