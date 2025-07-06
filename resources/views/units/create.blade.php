@extends('layouts.app')

@section('content')
<div class="glass-effect rounded-xl p-6 max-w-2xl mx-auto animate-fade-in">
    <h2 class="text-2xl font-semibold text-white mb-6">Add New Unit</h2>

    <form method="POST" action="{{ route('units.store') }}" class="space-y-6">
        @csrf
        @include('units.partials.form', ['button' => 'Create'])
    </form>
</div>
@endsection
