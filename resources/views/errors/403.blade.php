@extends('layouts.app')

@section('content')
    <div class="container-fluid">
       <div class="row">
           <div class="offset-md-3 col-md-6">
               <div class="uk-card uk-card-default uk-card-body">

                   <h3 class="uk-card-title" style="color:darkred !important;">Accès interdit !</h3>
                   <p class="alert alert-danger">Vous n'êtes pas autorisé à accéder à cette url.</p>
               </div>
           </div>
       </div>
    </div>
@endsection