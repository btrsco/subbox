@extends('errors::minimal')

@section('title', __('Unauthorized'))
@section('code', '401')
@section('heading', __('Unauthorized'))
@section('message', __('You are not authorized to access this page.'))
