@extends('errors::minimal')

@section('title', __('Service Unavailable'))
@section('code', '503')
@section('heading', __('Under maintenance'))
@section('message', __('Unfortunately, the site is undergoing maintenance and is currently unavailable. Please check back later.'))
