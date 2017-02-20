@extends('layouts/mail/template')

@section('message')
Dear {{ $firstname }} {{ $lastname }}, your account has been disabled.
An administrator has disabled your account. Please contact <a href=\"mailto:support@towerdevs.xyz\">support@towerdevs.xyz</a> for more information.
Sincerely,
TOWER Administration Team
@endsection
