@extends('layouts.app')
@section('title', 'Calculator')
@section('file', 'semester.calc')
@section('content')
<header class="page-heading calculator-heading"><p class="eyebrow">A LITTLE CHECK-IN FOR YOUR SEMESTER</p><h1>Count your <em>progress.</em></h1><p>Two semesters, one quick snapshot of how the journey is going.</p></header>
<div class="page-content">
    <div class="calculator-layout">
        <section class="window calculator-window"><div class="window-bar"><span>semester.calc</span><span aria-hidden="true">− □ ×</span></div><form class="calculator-form" action="{{ route('calculator.submit') }}" method="get">
            <p class="form-intro">Add the GPA for each semester.</p>
            @foreach(['ip1' => 'Semester 01', 'ip2' => 'Semester 02'] as $field => $label)
                <div class="form-field"><label for="{{ $field }}">{{ $label }} <span>GRADE POINT AVERAGE</span></label><div class="input-wrap"><input id="{{ $field }}" name="{{ $field }}" type="text" inputmode="decimal" required maxlength="12" placeholder="0.00" value="{{ is_scalar($values[$field] ?? '') ? ($values[$field] ?? '') : '' }}" aria-describedby="{{ $field }}-hint{{ isset($errorsByField[$field]) ? ' '.$field.'-error' : '' }}" @if(isset($errorsByField[$field])) aria-invalid="true" @endif><span>/ 4.00</span></div><span class="field-hint" id="{{ $field }}-hint">Use 0–4. Both 3.50 and 3,50 work.</span>@if(isset($errorsByField[$field]))<p class="field-error" id="{{ $field }}-error">{{ $errorsByField[$field][0] }}</p>@endif</div>
            @endforeach
            <div class="button-row"><button class="button primary" type="submit">Calculate average <span aria-hidden="true">=</span></button><a class="reset-link" href="{{ route('calculator.index') }}">Reset</a></div>
        </form></section>
        <section class="result-panel {{ $result ? 'has-result' : '' }}" aria-labelledby="result-title" @if($result) data-result @endif>
            <p class="eyebrow" id="result-title">{{ $result ? 'YOUR SEMESTER SNAPSHOT' : 'READY WHEN YOU ARE' }}</p>
            <div class="result-display"><span class="result-label">AVERAGE GPA</span><strong class="result-number">{{ $result ? number_format($result['average'], 2) : '—.——' }}</strong><span class="result-scale">out of 4.00</span></div>
            @if($result)<div class="result-equation"><span>Total of both GPAs</span><strong>{{ number_format($result['total'], 2) }}</strong></div><div class="result-equation"><span>The math</span><strong>({{ $values['ip1'] }} + {{ $values['ip2'] }}) ÷ 2</strong></div><p class="result-message">Every step counts. Keep going - you’re doing more than you think. ♡</p>@else<p class="result-message">{{ $errorsByField ? 'Check the highlighted field, then give it another go.' : 'Your result and the calculation will show up here once both fields are filled.' }}</p>@endif
        </section>
    </div>
    <aside class="calculator-note"><span aria-hidden="true">ⓘ</span><p>This is a simple equal-weight average for two semesters. Your official cumulative GPA is credit-weighted, so it may be different.</p></aside>
    <a class="text-link" href="{{ route('dashboard.index') }}">Open academic dashboard ↗</a>
</div>
@endsection
