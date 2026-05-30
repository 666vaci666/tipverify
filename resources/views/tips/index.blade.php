@extends('layouts.app')

@section('title', 'Zoznam tipov — TipVerify')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Tipy</h1>
    @auth
    <a href="/tips/create"
        class="bg-blue-600 text-white text-sm px-4 py-2 rounded hover:bg-blue-700">
        + Pridať tip
    </a>
    @endauth
</div>

<div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="text-left px-4 py-3 font-medium text-gray-600">Zápas</th>
                <th class="text-left px-4 py-3 font-medium text-gray-600">Tip</th>
                <th class="text-left px-4 py-3 font-medium text-gray-600">Kurz</th>
                <th class="text-left px-4 py-3 font-medium text-gray-600">Dátum</th>
                <th class="text-left px-4 py-3 font-medium text-gray-600">Autor</th>
                <th class="text-left px-4 py-3 font-medium text-gray-600">Status</th>
                @auth
                @if(auth()->user()->is_admin)
                <th class="text-left px-4 py-3 font-medium text-gray-600">Akcie</th>
                @endif
                @endauth
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($tips as $tip)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3">{{ $tip->match_teams }}</td>
                <td class="px-4 py-3">{{ $tip->prediction }}</td>
                <td class="px-4 py-3 font-mono">{{ $tip->odds }}</td>
                <td class="px-4 py-3 text-gray-500">{{ $tip->match_date }}</td>
                <td class="px-4 py-3 text-gray-500">
                    <a href="/tipster/{{ $tip->user_id }}" class="hover:text-blue-600 hover:underline">
                        {{ $tip->user->name }}
                    </a>
                </td>
                <td class="px-4 py-3">
                    @php
                    $colors = [
                    'win' => 'bg-green-100 text-green-700',
                    'loss' => 'bg-red-100 text-red-700',
                    'pending' => 'bg-yellow-100 text-yellow-700',
                    'void' => 'bg-gray-100 text-gray-600',
                    ];
                    @endphp
                    <span class="text-xs font-medium px-2 py-0.5 rounded-full {{ $colors[$tip->status] ?? '' }}">
                        {{ strtoupper($tip->status) }}
                    </span>
                </td>
                @auth
                @if(auth()->user()->is_admin)
                <td class="px-4 py-3">
                    <a href="/tips/{{ $tip->id }}/edit"
                        class="text-blue-600 hover:underline text-xs mr-3">
                        Upraviť
                    </a>
                    <form method="POST" action="/tips/{{ $tip->id }}" class="inline">
                        @csrf
                        @method('DELETE')
                        <button
                            type="submit"
                            onclick="return confirm('Naozaj zmazať?')"
                            class="text-red-500 hover:underline text-xs bg-transparent border-0 cursor-pointer p-0">
                            Zmazať
                        </button>
                    </form>
                </td>
                @endif
                @endauth
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-4 py-8 text-center text-gray-400">
                    Žiadne tipy.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Štatistiky --}}
@php
$total = $tips->count();
$wins = $tips->where('status', 'win')->count();
$losses = $tips->where('status', 'loss')->count();
$pending = $tips->where('status', 'pending')->count();
$winRate = $total > 0 ? round(($wins / max($wins + $losses, 1)) * 100) : 0;
@endphp

<div class="grid grid-cols-4 gap-4 mt-6">
    <div class="bg-white border border-gray-200 rounded-lg p-4 text-center">
        <div class="text-2xl font-bold text-gray-900">{{ $total }}</div>
        <div class="text-xs text-gray-500 mt-1">Celkom tipov</div>
    </div>
    <div class="bg-white border border-gray-200 rounded-lg p-4 text-center">
        <div class="text-2xl font-bold text-green-600">{{ $wins }}</div>
        <div class="text-xs text-gray-500 mt-1">Výhry</div>
    </div>
    <div class="bg-white border border-gray-200 rounded-lg p-4 text-center">
        <div class="text-2xl font-bold text-red-500">{{ $losses }}</div>
        <div class="text-xs text-gray-500 mt-1">Prehry</div>
    </div>
    <div class="bg-white border border-gray-200 rounded-lg p-4 text-center">
        <div class="text-2xl font-bold text-blue-600">{{ $winRate }}%</div>
        <div class="text-xs text-gray-500 mt-1">Úspešnosť</div>
    </div>
</div>

@endsection