use App\Providers\RouteServiceProvider;

public function handle(Request $request, Closure $next, string ...$guards): Response
{
    foreach ($guards as $guard) {
        if (Auth::guard($guard)->check()) {
            // Ganti ini:
            return redirect(RouteServiceProvider::HOME);
            // Jadi ini:
            return redirect()->route('admin.dashboard');
        }
    }
    return $next($request);
}