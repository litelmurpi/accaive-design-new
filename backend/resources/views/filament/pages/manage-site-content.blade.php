<x-filament-panels::page>
    <form wire:submit="save">
        {{ $this->form }}

        <div class="mt-8 flex justify-end">
            <x-filament::button type="submit" size="lg" icon="heroicon-m-check">
                Simpan Semua Perubahan
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>
