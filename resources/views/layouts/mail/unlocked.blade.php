@extends('layouts/mail/template')

@section('message')
Dear {{ $firstname }} {{ $lastname }}, your account has been unlocked.
An administrator has unlocked your account, you may now sign in again.
Sincerely,
TOWER Administration Team
@endsection
