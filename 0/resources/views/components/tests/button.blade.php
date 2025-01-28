<!-- resources/views/components/button.blade.php -->
<button 
    type="{{ $type ?? 'button' }}" 
    class="w-full bg-{{ $color ?? 'blue' }}-600 text-white py-2 px-4 rounded-md hover:bg-{{ $color ?? 'blue' }}-700 focus:outline-none focus:ring-2 focus:ring-{{ $color ?? 'blue' }}-500 focus:ring-offset-2"
>
    {{ $slot }}
</button>
