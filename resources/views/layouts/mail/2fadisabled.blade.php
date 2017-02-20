@extends('layouts/mail/template')

@section('message')
Dear {{ $firstname }} {{ $lastname }}, multi-factor authentication has been disabled.
Somebody, either you or an administrator, has disabled multi-factor authentication on your account. If you performed this action, there's nothing more you need to do.
If you did not perform this action, please contact support@towerdevs.xyz immediately as your account may be compromised.
Sincerely,
TOWER Administration Team
@endsection
