@extends('errors::minimal')

@section('title', __('Server Error'))
@section('code', '500')
@section('heading', __('Server error'))
@section('message', __('Uh oh! Something went wrong on our end.'))
