@php
    /**
     * @var App\Models\Argument $argument
     * @var App\Models\User $user
     */

    $readonly ??= false;
    $anchorLink = $argument->user->username . '-' . $argument->id;
@endphp

<div id="{{ $anchorLink }}" class="bg-white rounded-xl shadow-md w-full group px-6 pt-5 md:px-8 md:pt-7 flex gap-6 items-center">
    <x-argument-card.vote :argument="$argument" :user="$user" />

    <div class="grid gap-2 md:gap-4 w-full">
        @if(!$readonly && $isEditing?->is($argument))
            <x-markdown-editor wire:model="body" />
        @else
            <x-markdown class="prose prose-md w-full max-w-full">
                {!! $argument->body !!}
            </x-markdown>
        @endif

        <div class="flex gap-2 flex-col md:flex-row md:items-center md:justify-between">
            <div class="flex gap-2 flex-col md:flex-row md:items-center mt-3 lg:mt-0">
                @if(!$readonly && $user?->can('edit', $argument))
                    <x-argument-card.button
                        wire:click="editArgument('{{ $argument->id }}')"
                        class="{{ $isEditing?->is($argument) ? 'hover:text-green-800' : 'hover:text-blue-900' }}"
                        :icon="$isEditing?->is($argument) ? 'icons.check' : 'icons.pen'"
                    >
                        {{ $isEditing?->is($argument) ? 'Save' : 'Edit' }}
                    </x-argument-card.button>

                    @if($isEditing?->is($argument))
                        <x-argument-card.button
                            class="hover:text-red-600"
                            icon="icons.cancel"
                            wire:click="cancelEditArgument()"
                        >
                            Cancel
                        </x-argument-card.button>
                    @endif
                @endif

                @if(!$readonly && $user?->can('delete', $argument))
                    <x-argument-card.delete-button
                        :argument="$argument"
                        :is-confirming-delete="$isConfirmingDelete"
                    />
                @endif
                @if($readonly)
                    <span class="text-sm">
                    Read the RFC: <a href="{{ action(\App\Http\Controllers\RfcDetailController::class, $rfc) }}" class="underline hover:no-underline">{{ $rfc->title }}</a>
                    </span>
                @endif
            </div>
        </div>

        <x-argument-card.card-footer
            :argument="$argument"
            :user="$user"
            :anchor-link="$anchorLink"
        />
    </div>
</div>
