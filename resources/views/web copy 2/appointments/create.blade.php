@extends('web.layouts.app')

@section('content')
    <section class="bg-gradient-shaph position-relative pt-14 pt-md-15 pb-11 pb-lg-12 pb-xl-13">
        <div class="container position-relative z-3">
            @include('web.layouts.breadcrumb')

            <div class="card flex-direction-initial">
                <div class="card-body">

                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-8 col-md-10">
                                <div class="card shadow border-0">
                                    <div class="card-header bg-primary text-white text-center">
                                        <h2 class="mb-0 text-white">Book an Appointment</h2>
                                        <small>Fill in the details below and our team will contact you</small>
                                    </div>

                                    <div class="card-body p-4" x-data="appointmentForm()">
                                        @if (session('appointment_code'))
                                            <div
                                                class="alert alert-info alert-dismissible fade show d-flex align-items-center justify-content-between">
                                                <div>
                                                    Your appointment code is:
                                                    <strong id="appointmentCode">{{ session('appointment_code') }}</strong>
                                                </div>
                                                <div>
                                                    <button class="btn btn-sm btn-outline-primary"
                                                        onclick="copyAppointmentCode()">
                                                        Copy
                                                    </button>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="alert"></button>
                                                </div>
                                            </div>
                                        @endif

                                        {{-- Success Message --}}
                                        @if (session('success'))
                                            <div class="alert alert-success alert-dismissible fade show">
                                                {{ session('success') }}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                            </div>
                                        @endif
                                        {{-- Validation errors --}}
                                        @if ($errors->any())
                                            @foreach ($errors->all() as $error)
                                                <div class="alert alert-danger alert-dismissible fade show">
                                                    {{ $error }}
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="alert"></button>
                                                </div>
                                            @endforeach
                                        @endif

                                        {{-- Progress Bar --}}
                                        <div class="mb-4">
                                            <div class="progress" style="height: 10px;">
                                                <div class="progress-bar bg-primary" role="progressbar"
                                                    :style="`width: ${step * 50}%`">
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between mt-1">
                                                <small :class="step === 1 ? 'text-primary fw-bold' : ''">
                                                    Info
                                                </small>
                                                <small :class="step === 2 ? 'text-primary fw-bold' : ''">
                                                    Appointment
                                                    Details
                                                </small>
                                            </div>
                                        </div>

                                        <form method="POST" action="{{ route('appointment.store') }}">
                                            @csrf

                                            {{-- Step 1 --}}
                                            <div x-show="step === 1" x-transition x-cloak>
                                                <div class="mb-3">
                                                    <label class="form-label">Full Name <code>*</code></label>
                                                    <input type="text" x-model="patient_name" name="patient_name"
                                                        class="form-control" placeholder="Full Name">
                                                    <template x-if="errors.patient_name">
                                                        <div class="text-danger mt-1" x-text="errors.patient_name"></div>
                                                    </template>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Email</label>
                                                    <input type="email" x-model="email" name="email"
                                                        class="form-control" placeholder="Email">
                                                    <template x-if="errors.email">
                                                        <div class="text-danger mt-1" x-text="errors.email"></div>
                                                    </template>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Phone <code>*</code></label>
                                                    <input type="text" x-model="phone" name="phone"
                                                        class="form-control" placeholder="Phone Number">
                                                    <template x-if="errors.phone">
                                                        <div class="text-danger mt-1" x-text="errors.phone"></div>
                                                    </template>
                                                </div>

                                                <div class="d-flex justify-content-end">
                                                    <button type="button" class="btn btn-primary"
                                                        @click="validateStep1">Next</button>
                                                </div>
                                            </div>

                                            {{-- Step 2 --}}
                                            <div x-show="step === 2" x-transition x-cloak>
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label">Appointment Date <code>*</code></label>
                                                        <input type="date" name="appointment_date" class="form-control"
                                                            required min="{{ date('Y-m-d') }}">
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="form-label">Time</label>
                                                        <input type="time" name="appointment_time" class="form-control">
                                                    </div>
                                                </div>

                                                <div
                                                    x-data='{
                                                        selectedDept: @json(old('department_has_item_id', '')),
                                                        selectedDoctor: @json(old('doctor_id', '')),
                                                        doctors: @json($departmentDoctors)
                                                    }'>

                                                    <div class="mb-3">
                                                        <label class="form-label">Department</label>
                                                        <select name="department_has_item_id" class="form-select"
                                                            x-model="selectedDept"
                                                            x-on:change="selectedDoctor = ''; $refs.doctorSelect.disabled = !selectedDept">
                                                            <option value="">-- Select Department --</option>
                                                            @foreach ($departments as $dept)
                                                                <option value="{{ $dept->id }}">{{ $dept->title }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">Person</label>
                                                        <select name="doctor_id" class="form-select" x-ref="doctorSelect"
                                                            :disabled="!(doctors[selectedDept] ?? []).length"
                                                            x-model="selectedDoctor">

                                                            <option value="">-- Select --</option>
                                                            <template x-for="doctor in doctors[selectedDept] ?? []"
                                                                :key="doctor.id">
                                                                <option :value="doctor.id" x-text="doctor.name">
                                                                </option>
                                                            </template>


                                                        </select>
                                                    </div>
                                                    {{-- <!-- Debug --> --}}
                                                    {{-- <pre x-text="JSON.stringify(doctors[selectedDept] ?? [], null, 2)"></pre> --}}
                                                </div>


                                                <div class="mb-3">
                                                    <label class="form-label">Notes</label>
                                                    <textarea name="notes" rows="3" class="form-control" placeholder="Additional information">{{ old('notes') }}</textarea>
                                                </div>

                                                <div class="d-flex justify-content-between">
                                                    <button type="button" class="btn btn-dark"
                                                        @click="step = 1">Back</button>
                                                    <button type="submit" class="btn btn-primary">Book
                                                        Appointment</button>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- <div x-data="{ count: 0 }">
                        <button @click="count++">Increment</button>
                        <span x-text="count"></span>
                    </div> --}}
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js-down')
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <script>
        function appointmentForm() {
            return {
                step: 1,
                patient_name: '',
                email: '',
                phone: '',
                errors: {},

                validateStep1() {
                    this.errors = {};

                    // Validate name (2 words)
                    if (!this.patient_name) this.errors.patient_name = 'Patient Name is required';
                    else if (this.patient_name.trim().split(' ').length < 2) this.errors.patient_name =
                        'Full Name must contain at least 2 words';

                    // Validate phone
                    if (!this.phone) {
                        this.errors.phone = 'Phone is required';
                    } else if (!/^[0-9+\-\s\(\)]+$/.test(this.phone)) {
                        // Allow digits, +, -, space, parentheses
                        this.errors.phone = 'Phone can only contain numbers, +, -, spaces, and parentheses';
                    } else if (this.phone.replace(/\D/g, '').length < 10) {
                        // Count only digits for length
                        this.errors.phone = 'Phone must have at least 10 digits';
                    }

                    // Validate email if entered
                    if (this.email) {
                        fetch('{{ route('appointment.validate-email') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    email: this.email
                                })
                            })
                            .then(res => res.json())
                            .then(data => {
                                if (!data.valid) {
                                    this.errors.email = data.message;
                                }
                                // Proceed to step 2 if no errors
                                if (Object.keys(this.errors).length === 0) this.step = 2;
                            });
                    } else {
                        if (Object.keys(this.errors).length === 0) this.step = 2;
                    }
                }
            }
        }
    </script>
    <script>
        function copyAppointmentCode() {
            const code = document.getElementById('appointmentCode').innerText;
            navigator.clipboard.writeText(code).then(() => {
                alert('Appointment code copied: ' + code);
            }).catch(err => {
                console.error('Failed to copy: ', err);
            });
        }
    </script>
@endpush
