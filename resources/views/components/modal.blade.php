@props([
    'id' => null,
    'title' => null,
    'titleCreate' => null,
    'titleUpdate' => null,
    'maxWidth' => 'max-w-lg',
    'defaults' => [],
])

<div
    x-data="{
        open: false,
        payload: null,
        form: {},
        openModal(e) {
            if (e.detail?.id !== @js($id)) return;
            this.payload = e.detail.payload ?? null;
            this.form = { ...@js($defaults), ...(this.payload ?? {}) };
            this.open = true;
            document.body.classList.add('overflow-hidden');
        },
        close() {
            this.open = false;
            document.body.classList.remove('overflow-hidden');
        },
        submit() {
            if (typeof savePayload === 'function') savePayload(this.payload?.id, { ...this.form });
        }
    }"
    @open-modal.window="openModal($event)"
    @close-modal.window="close()"
    @keydown.escape.window="close()"
    x-cloak
    x-show="open"
    x-transition.opacity.duration.150ms
    class="fixed inset-0 z-[70] flex items-center justify-center p-4"
    role="dialog"
    aria-modal="true"
>
    <div class="absolute inset-0 bg-gray-900/50" @click="close()"></div>

    <div class="relative w-full {{ $maxWidth }} max-h-[90vh] overflow-y-auto rounded-2xl bg-white shadow-2xl">
        <div class="flex items-start justify-between gap-4 border-b border-gray-100 px-6 py-4">
            <h3
                class="text-base font-bold text-gray-900"
                @if ($titleCreate || $titleUpdate)
                    x-text="payload ? @js($titleUpdate ?? $title) : @js($titleCreate ?? $title)"
                @endif
            >{{ $title }}</h3>
            <button type="button" @click="close()" class="-mr-1 rounded-lg p-1 text-gray-400 transition-colors duration-150 hover:bg-gray-100 hover:text-gray-700" aria-label="Close">
                <x-icons name="x" class="w-5 h-5" />
            </button>
        </div>

        <form class="px-6 py-5" x-on:submit.prevent="submit()">
            {{ $slot }}
        </form>

        @if (isset($footer) || ! empty($defaults))
            <div class="flex flex-wrap items-center justify-end gap-2 border-t border-gray-100 px-6 py-4">
                @if (isset($footer))
                    {{ $footer }}
                @else
                    <x-button variant="outline" x-on:click="close()">Cancel</x-button>
                    <x-button icon="check" x-on:click="submit()">Save</x-button>
                @endif
            </div>
        @endif
    </div>
</div>
