@extends('layouts.reception.layout')

@section('content')
  	<portal-target name="approve_leave"></portal-target>
  	@include('partials.message')
    	<reception-leave-list url="{{ url('/') }}" type="{{ $user_type }}"></reception-leave-list>
@endsection