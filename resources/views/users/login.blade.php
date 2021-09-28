@extends('layouts/app')
@section('content')
    <form name="login_form" method="POST" action=" {{ route('users.user_login_post') }}">
    @csrf
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    

    <div class='row'>
        <button type="submit" class='btn btn-primary'>Login !</button>
    </div>

    </form>
@endSection()