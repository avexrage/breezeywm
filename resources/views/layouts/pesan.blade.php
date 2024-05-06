@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

 @if ($errors->any())
 <div class="pt-1">
     <div class="alert alert-danger">
         <ul>
             @foreach ($errors->all() as $item)
                 <li>{{ $item }}</li>
             @endforeach
         </ul>
     </div>
 </div>
 @endif

@if (session('verified'))
    <div class="alert alert-success">
        {{ session('verified') }}
    </div>
@endif