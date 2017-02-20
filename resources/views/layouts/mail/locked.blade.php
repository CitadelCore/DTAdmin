@extends('layouts/mail/template')

@section('message')
Dear {{ $firstname }} {{ $lastname }}, your account has been locked.
Your account has been locked due to too many incorrect login attempts from the IP address $lockedip. Please contact <a href=\"mailto:support@towerdevs.xyz\">support@towerdevs.xyz</a> for more information.
Sincerely,
TOWER Administration Team
@endsection
