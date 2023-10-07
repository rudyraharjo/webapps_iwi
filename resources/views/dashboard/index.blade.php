@extends('layouts.app')

@section('title', 'Dashboard')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item {{ request()->is('app/dashboard') ? 'active' : '' }}">
        Dashboard</li>
@endsection

@section('content')

    @includeIf('dashboard.report.info1')

    @includeIf('dashboard.report.info2')

    @includeIf('dashboard.report.info3')

    @includeIf('dashboard.report.info4')

@endsection
