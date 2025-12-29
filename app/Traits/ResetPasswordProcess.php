<?php

namespace App\Traits;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Exception;
use App\Mail\ResetPassword;
use App\Traits\SmsProcess;

trait ResetPasswordProcess
{
    use SmsProcess;

    public function resetPasswordToUser($user)
    {
        try {
            if (empty($user->email)) {
                \Session::put('failmessage', 'User email not found');
                return false;
            }

            $token = Str::random(64);

            DB::beginTransaction();

            $inserted = DB::table(config('auth.passwords.users.table'))->insert([
                'email'      => $user->email,
                'token'      => Hash::make($token),
                'created_at' => Carbon::now(),
            ]);

            if (!$inserted) {
                DB::rollBack();
                \Session::put('failmessage', 'Password reset failed');
                return false;
            }

            if (env('SMS_STATUS') === 'on' && !empty($user->mobile_no)) {
                $url = url('/password/reset/' . $token);
                $this->sendUserResetPassword($user->mobile_no, $url);
            }

            if (env('MAIL_STATUS') === 'on') {
                Mail::to($user->email)
                    ->queue(
                        (new ResetPassword($user, $token))->onQueue('emails')
                    );

                \Session::put('successmessage', 'Check your email to reset the password');
            }

            DB::commit();
            return true;

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Reset Password Error: ' . $e->getMessage());
            \Session::put('failmessage', 'Something went wrong');
            return false;
        }
    }

    public function resetPasswordSms($user)
    {
        try {
            if (empty($user->email) || empty($user->mobile_no)) {
                return false;
            }

            if (env('SMS_STATUS') !== 'on') {
                return false;
            }

            $token = Str::random(64);

            DB::table(config('auth.passwords.users.table'))->insert([
                'email'      => $user->email,
                'token'      => Hash::make($token),
                'created_at' => Carbon::now(),
            ]);

            $url = url('/password/reset/' . $token);
            $this->sendUserResetPassword($user->mobile_no, $url);

            return true;

        } catch (Exception $e) {
            Log::error('Reset Password SMS Error: ' . $e->getMessage());
            return false;
        }
    }
}
