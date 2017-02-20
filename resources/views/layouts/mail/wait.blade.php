@extends('layouts/mail/template')

@section('message')
Dear {{ $firstname }} {{ $lastname }}, your account has been created.
However, your account must be verified by an administrator before you can log in. If this process takes more than 7 days, please contact <a href=\"mailto:support@towerdevs.xyz\">support@towerdevs.xyz</a> for more information.
Sincerely,
TOWER Administration Team
@endsection
