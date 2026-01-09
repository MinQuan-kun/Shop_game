<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        try {
            // 1. Kiểm tra Email có tồn tại không
            $user = \App\Models\User::where('email', $this->email)->first();

            if (! $user) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'email' => 'Email không tồn tại, vui lòng đăng ký tài khoản.',
                ]);
            }

            // 2. Kiểm tra Mật khẩu (Auth::attempt)
            // Khối này dễ gây lỗi 500 nếu cấu hình sai, nên cần try-catch
            if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
                RateLimiter::hit($this->throttleKey());

                throw ValidationException::withMessages([
                    'password' => 'Mật khẩu không chính xác, vui lòng nhập lại.', // Bạn có thể dùng trans('auth.failed')
                ]);
            }
        } catch (\Exception $e) {
            // Nếu lỗi là do Validation (Email không tồn tại / Sai pass) -> Ném lỗi ra bình thường
            if ($e instanceof \Illuminate\Validation\ValidationException) {
                throw $e;
            }

            // Nếu là lỗi 500 (Lỗi code, DB, Server...) -> Log lại và báo lỗi thân thiện
            \Illuminate\Support\Facades\Log::error('Login Error: ' . $e->getMessage());

            throw ValidationException::withMessages([
                'email' => 'Đã có lỗi hệ thống xảy ra khi đăng nhập. Vui lòng thử lại sau.',
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')) . '|' . $this->ip());
    }
}
