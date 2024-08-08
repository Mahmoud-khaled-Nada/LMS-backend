 @if ($message = Session::get('success'))
     <div class="alert alert-success alert-dismissible fade show" role="alert">
         <strong>{{ $message }}</strong>
     </div>
 @endif
 @if ($errors->any())
     <div class="alert alert-danger">
         <ul>
             @foreach ($errors->all() as $error)
                 <li>{{ $error }}</li>
             @endforeach
         </ul>
     </div>
 @endif

 @if ($message = Session::get('error'))
     <div class="alert alert-danger alert-dismissible fade show" role="alert">
         <strong>{{ $message }}</strong>
     </div>
 @endif

 @if ($message = Session::get('error_message'))
     <div class="alert alert-danger alert-dismissible fade show" role="alert">
         <strong>{{ $message }}</strong>
     </div>
 @endif



 @if ($message = Session::get('warning'))
     <div class="alert alert-warning alert-dismissible fade show" role="alert">
         <strong>{{ $message }}</strong>
     </div>
 @endif



 @if ($message = Session::get('info'))
     <div class="alert alert-info alert-dismissible fade show" role="alert">
         <strong>{{ $message }}</strong>
     </div>
 @endif
