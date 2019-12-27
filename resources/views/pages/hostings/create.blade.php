@extends('layouts.master')

@section('styles')
<link rel="stylesheet" href="/css/app.css">
<link rel="stylesheet" href="/css/adminStyles.css">
@endsection

@section('scripts')
<script src="/js/api/navDropdown.js"></script>
<script src="/js/api/inputFile.js"></script>
<script>
@if(session()->has('success'))
    alert('{{ session('success') }}');
@endif
@if($errors->any())
    alert('Ýalňyşlyklaryňyzy düzediň');
@endif
</script>
@endsection

@section('content')
@if($errors->any())
<div class="container mt-80px" style="padding-bottom: 0;">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
</div>
@endif
<h1 class="info @if(!$errors->any()) mt-80px @endif"><span class="common">Goşmak</span></h1>
    <div class="container">
        <form action="{{ route('hostings.store') }}" class="form-wrapper" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="input-container">
                <label for="">Edaraň ady</label>
                <input type="text" name="company_name" required>
            </div>

            <div class="input-container">
                <label for="">Ýuridiki salgy</label>
                <input type="text" name="company_address" id="" required>
            </div>
            
            <div class="input-container">
                <label for="">№ (Web sahypa / VPS)</label>
                <input type="text" name="vps_number" required>
            </div>

            <div class="input-container">
                <label for="">Habarlaşmak üçin telefon belgileri</label>
                <input type="text" name="phone_number" id="" required>
            </div>

            <div class="input-container special-input">
                <label for="">Hatyň belgisi we senesi</label>
                <input type="text" name="letter_number" id="">
                <input type="date" name="letter_at" id="" required>
            </div>

            <div class="input-container">
                <label for="">Ýolbaşçynyň A.A.F</label>
                <input type="text" name="employer_name" id="" required>
            </div>

            <div class="input-container">
                <label for="">Jogapkär işgär</label>
                <input type="text" name="responsible_employee_name" id="" required>
            </div>

            <div class="input-container">
                <label for="">Jogapkär işgäriň telefony</label>
                <input type="text" name="responsible_employee_phone_number" id="" required>
            </div>

            <div class="input-container">
                <label for="">Jogapkäriň E-mail </label>
                <input type="email" name="responsible_employee_email" id="" required>
            </div>

            <div class="input-container">
                <label for="">Jogapkär işgäriň öý belgisi</label>
                <input type="text" name="responsible_employee_home_number" id="" required>
            </div>

            <div class="input-container">
                <label for="">Jogapkär işgäriň iş belgisi</label>
                <input type="text" name="responsible_employee_job_number" id="" required>
            </div>
            
            <div class="input-container">
                <label for="">Şertnama baglanşan senesi</label>
                <input type="date" name="contract_at" id="" required>
            </div>
            
            <div class="input-container" v-if="ipAddressField.length <= 0">
                <label for="">Domain Name</label>
                <input type="text" name="domain_name" v-model="domainNameField" id="">
            </div>

            <div class="input-container">
                <label for="">Tarif</label>
                <select name="plan" id="" required>
                    @if(count($plans) > 0)
                        @foreach($plans as $plan)
                            <option value="{{ $plan->id }}">{{ $plan->name }}</option>
                        @endforeach
                    @else
                        <option value="">Tarif ýok</option>
                    @endif
                    {{-- <option value="a">VPS A</option>
                    <option value="b">VPS B</option>
                    <option value="c">VPS C</option>
                    <option value="a-18">VPS A-2018</option>
                    <option value="b-18">VPS B-2018</option>
                    <option value="c-18">VPS C-2018</option> --}}
                </select>
            </div>

            <div class="input-container" v-if="domainNameField.length < 1">
                <label for="">IP adress</label>
                <input type="text" name="ip_address" v-model="ipAddressField" id="">
            </div>

            <div class="input-container">
                <label for="">Birikdiren sene</label>
                <input type="date" name="associated_at" id="" required>
            </div>

            <div class="input-container">
                <label for="">Görnüşi</label>
                <select name="type" id="" required>
                    @if(count($types) > 0)
                        @foreach($types as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    @else
                        <option value="">Görnüş ýok</option>
                    @endif
                    {{-- <option value="gov">Döwlet</option>
                    <option value="budget">Býujet</option>
                    <option value="own">Döwlet däl</option> --}}
                </select>
            </div>

            <div class="input-container">
                <label for="">Bellige alnan belgi: Web-sahypa nomer, ýa-da VPS nomeri</label>
                <input type="text" name="number_noted" id="" required>
            </div>

            <div class="input-container for-textarea">
                <label for="">Bellik</label>
                <textarea name="more" id="" rows="4" required></textarea>
            </div>

            <input type="submit" id="" value="Ugrat">
        </form>
    </div>
@stop
