@extends('layouts/mail/template')

@section('message')
Dear {{ $firstname }} {{ $lastname }}, your account has been created.
Since you provided a Invite Key at signup, your account has been auto-confirmed. You may now log in with your username and password.
Sincerely,
TOWER Administration Team
@endsection
