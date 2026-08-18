<x-filament::page>
    <x-filament::card>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <h2 class="text-lg font-bold">Applicant Details</h2>
                <p><strong>Name:</strong> {{ $record->name }}</p>
                <p><strong>Email:</strong> {{ $record->email }}</p>
                <p><strong>Phone:</strong> {{ $record->phone }}</p>
                <p><strong>Status:</strong> 
                    @if ($record->is_active)
                        <span class="text-green-600 font-semibold">Approved</span>
                    @else
                        <span class="text-red-600 font-semibold">On Hold</span>
                    @endif
                    {{-- {{ $record->is_active ? 'Approved' : 'On Hold' }} --}}
                </p>
            </div>

            <div>
                <h2 class="text-lg font-bold">Career Details</h2>
                <p><strong>Career:</strong> {{ $record->career->title }}</p>
                <p><strong>Applied On:</strong> {{ $record->created_at->format('Y-m-d') }}</p>
            </div>

            <div class="md:col-span-2">
                <h2 class="text-lg font-bold">Cover Letter</h2>
                <div class="prose">
                    {!! $record->cover_letter !!}
                </div>
            </div>

            <div class="md:col-span-2">
                <h2 class="text-lg font-bold">Resume</h2>
                @if ($record->resume_path)
                    <a href="{{ Storage::disk('public')->url($record->resume_path) }}" target="_blank" class=" text-primary-600 hover:underline">
                        Download Resume
                    </a>
                @else
                    <span>No resume uploaded.</span>
                @endif
            </div>
        </div>
    </x-filament::card>
</x-filament::page>
