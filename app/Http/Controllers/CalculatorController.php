<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class CalculatorController
{
    public function index(): View
    {
        return view('calculator', ['result' => null, 'values' => ['ip1' => '', 'ip2' => ''], 'errorsByField' => []]);
    }

    public function submit(Request $request): View|RedirectResponse
    {
        return $this->calculate($request->only('ip1', 'ip2'), true);
    }

    public function result(string $ip1, string $ip2): View
    {
        return $this->calculate(compact('ip1', 'ip2'));
    }

    private function calculate(array $values, bool $redirect = false): View|RedirectResponse
    {
        // Normalize Indonesian decimal commas; reject arrays and non-numeric input.
        $values = array_map(fn ($value) => is_string($value) ? str_replace(',', '.', trim($value)) : $value, $values);
        $validator = Validator::make($values, [
            'ip1' => ['bail', 'required', 'numeric', 'between:0,4'],
            'ip2' => ['bail', 'required', 'numeric', 'between:0,4'],
        ], [
            'required' => 'Add this semester GPA first.',
            'numeric' => 'Use a number, such as 3.50.',
            'between' => 'GPA must be between 0 and 4.',
        ]);

        $errorsByField = $validator->errors()->toArray();
        $result = null;
        if ($validator->passes()) {
            if ($redirect) {
                return redirect()->route('calculator.result', $validator->validated());
            }
            $total = (float) $values['ip1'] + (float) $values['ip2'];
            $result = ['total' => $total, 'average' => $total / 2];
        }
        // Keep malformed direct URLs useful, with inline errors and HTTP 422.
        $view = view('calculator', compact('values', 'result', 'errorsByField'));
        if ($validator->fails()) {
            abort(response($view, 422));
        }

        return $view;
    }
}
