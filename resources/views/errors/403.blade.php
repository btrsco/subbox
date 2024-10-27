@extends('errors::minimal')

@section('title', __('Forbidden'))
@section('code', '403')
@section('heading', __('Forbidden'))
@section('message', __($exception->getMessage() ?: 'You are not authorized to access this page.'))
