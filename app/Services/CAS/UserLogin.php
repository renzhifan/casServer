<?php
namespace App\Services\CAS;

use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Leo108\CAS\Contracts\Interactions\UserLogin as UserLoginContract;

class UserLogin implements UserLoginContract
{
    use ThrottlesLogins;

    public function login(Request $request)
    {
        $this->validateLogin($request);

        if ($this->attemptLogin($request)) {
            $request->session()->regenerate();
            $this->clearLoginAttempts($request);
            return $this->guard()->user();
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return null;
    }

    public function getCurrentUser(Request $request)
    {
        return $request->user();
    }

    public function showAuthenticateFailed(Request $request)
    {
        // TODO: Implement showAuthenticateFailed() method.
    }

    public function showLoginWarnPage(Request $request, $jumpUrl, $service)
    {
        // TODO: Implement showLoginWarnPage() method.
    }

    public function showLoginPage(Request $request, array $errors = [])
    {
        $post_login_url = route('cas.login.post');
        if ($request->getQueryString()) {
            $post_login_url .= '?' . $request->getQueryString();
        }
        return view('auth.login', ['post_login_url' => $post_login_url]);
    }

    public function redirectToHome(array $errors = [])
    {
        return redirect('/home');
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect('/');
    }

    public function showLoggedOut(Request $request)
    {
        // TODO: Implement showLoggedOut() method.
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        Validator::make($request->all(), [
            $this->username() => 'required|string',
            'password' => 'required|string',
        ])->validate();
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            $this->credentials($request), $request->filled('remember')
        );
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password');
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'email';
    }

    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }
}
