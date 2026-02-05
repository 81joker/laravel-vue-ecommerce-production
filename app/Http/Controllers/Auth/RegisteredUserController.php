<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Helpers\Cart;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        DB::begintransaction();
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
    
            event(new Registered($user));
    
            $customer = new Customer();
            $name = explode(" ", $request->name);
            $customer->user_id = $user->id;
            // if (!isset($customer)) {
                $customer->first_name = $name[0];
                $customer->last_name = $name[1] ?? '';
                $customer->save();
            // }
    
            Auth::login($user);
        } catch (\Throwable $th) {
            // throw $th;
            DB::rollback();
            return back()->withInput()->withErrors(['error' , 'Something went wrong while registering. Please try again.']);
            // return back()->withInput($request->all())->withErrors(['error' => 'Something went wrong while registering. Please try again.']);
        }
        DB::commit();

        Cart::moveCartItemsIntoDb();
        return redirect(route('home', absolute: false));
        // return redirect(RouteServiceProvider::HOME);

    }
}
/*
كيف تعمل؟
فتح معاملة: تبدأ بفتح معاملة باستخدام 1DB::beginTransaction().
إجراء تغييرات: تقوم بإجراء تغييرات على قاعدة البيانات.2
تأكيد التغييرات: إذا كانت جميع العمليات ناجحة، تستخدم 3DB::commit() لتأكيد التغييرات.
التراجع عن التغييرات: إذا حدث خطأ، يمكنك استخدام 4DB::rollBack() للتراجع عن كافة التغييرات.

How does it work?
1-Open a transaction: You start a transaction using DB::beginTransaction().
2-Commit changes: You make changes to the database.
3-Confirm changes: If all operations are successful, you use DB::commit() to confirm the changes.
4-Roll back changes: If an error occurs, you can use DB::rollBack() to roll back all changes.

*/