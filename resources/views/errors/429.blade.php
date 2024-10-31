@extends('errors::minimal')

@section('title', __('Too Many Requests'))
@section('code', '429')
@section('heading', __('Slow down'))
@section('message', __('You have made too many requests. Please wait a while before trying again.'))
