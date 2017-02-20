@extends('layouts/mail/template')

@section('message')
Dear {{ $firstname }} {{ $lastname }}, your account has been verified.
    You should now be able to log into DTAdmin with the credentials you created at signup.
    Sincerely,
    TOWER Administration Team
@endsection
