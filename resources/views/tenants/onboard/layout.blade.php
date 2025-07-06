@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto glass-effect rounded-xl p-6 text-white">
    <!-- Progress Bar -->
    <div class="flex items-center justify-between mb-6">
        <div class="w-full bg-white/10 rounded-full h-2.5">
            <div class="bg-purple-600 h-2.5 rounded-full" style="width: {{ $progress }}%"></div>
        </div>
        <span class="ml-4 text-sm text-purple-200">Step {{ $step }} of 3</span>
    </div>

    <h2 class="text-2xl font-semibold mb-4">{{ $title }}</h2>

    <form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        {!! $slot !!}

        <div class="flex justify-between pt-4">
            @if ($back)
                <a href="{{ $back }}" class="text-purple-300 hover:text-purple-100">← Back</a>
            @else
                <span></span>
            @endif
            <button class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-2 rounded-lg hover:from-indigo-700 hover:to-purple-700 transition">
                {{ $button }}
            </button>
        </div>
    </form>
</div>
@endsection