@extends('layouts.app')

@section('content')
<div class="glass-effect rounded-xl p-6 max-w-2xl mx-auto animate-fade-in">
    <h2 class="text-2xl font-semibold text-white mb-6">Edit Landlord</h2>

    <form method="POST" action="{{ route('landlords.update', $landlord) }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')
        @include('landlords.partials.form', ['button' => 'Update'])
    </form>
</div>
@endsection
