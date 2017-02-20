@extends('layouts/mail/template')

@section('message')
Dear {{ $firstname }} {{ $lastname }}, your account has been deleted.
Somebody, either you or an administrator, has deleted your account. If you deleted your account, there's nothing else you need to do.
Sincerely,
TOWER Administration Team
@endsection
