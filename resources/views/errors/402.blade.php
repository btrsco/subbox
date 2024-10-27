@extends('errors::minimal')

@section('title', __('Payment Required'))
@section('code', '402')
@section('heading', __('Payment issues'))
@section('message', __('Unfortunately, you may need to update your payment information to access this page.'))
@section('button_url', route('settings.account.edit'))
@section('button_text', __('Account settings'))
