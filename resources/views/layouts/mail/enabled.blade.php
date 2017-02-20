@extends('layouts/mail/template')

@section('message')
Dear {{ $firstname }} {{ $lastname }}, your account has been enabled.
An administrator has re-enabled your account. However, some functionality might still be disabled for security reasons.
Sincerely,
TOWER Administration Team
@endsection
