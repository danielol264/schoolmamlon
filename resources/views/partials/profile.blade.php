@extends('layouts.app')
@section('title', 'Mi Perfil')

@section('content')
  <div class="max-w-xl mx-auto p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-4">Mi Perfil</h2>

    @if(session('success'))
      <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
        {{ session('success') }}
      </div>
    @endif

    <div class="flex items-center mb-6">
      <img
        src="{{ asset('storage/' . (Auth::user()->fotoperfil ?? 'default.jpg')) }}"
        alt="Foto de Perfil"
        class="w-20 h-20 rounded-full object-cover mr-4"
      >
      <div>
        <p class="text-xl font-semibold">{{ Auth::user()->name }}</p>
        <p class="text-gray-600">{{ Auth::user()->email }}</p>
      </div>
    </div>

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div class="mb-4">
        <label for="fotoperfil" class="block text-sm font-medium text-gray-700">Selecciona nueva foto</label>
        <input
          type="file"
          name="fotoperfil"
          id="fotoperfil"
          accept="image/*"
          class="mt-1 block w-full text-sm text-gray-500"
        >
        @error('fotoperfil')
          <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>

      <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
        Actualizar Foto
      </button>
    </form>
  </div>
@endsection