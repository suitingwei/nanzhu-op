<?php

namespace App\Console\Commands;

use App\FakeUser;
use App\User;
use App\Utils\FakeUtil;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;

class RegisterFakeUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fake:register-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'register fake user';

    /**
     * @var User
     */
    private $registeredUser;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $fakeUtil = new FakeUtil();
        $now      = Carbon::now();

        if (FakeUser::isTodayRegisteredCompleted()) {
            $this->info("{$now}的注册任务计划执行完毕");
            $leftCount = FakeUser::leftPhonesCount();
            if (Redis::get('register_fake_users')) {
                return false;
            }
            Redis::set('register_fake_users', 'success');
            Mail::raw("{$now}的注册任务执行完毕,Fake-Users表剩余电话数量为:{$leftCount}", function ($message) {
                $message->to('ufoddd001@gmail.com', 'Fake User Registered!');
                $message->from('postmaster@nanzhuxinyu.com', 'nanzhuxinyu');
            });
            return false;
        }

        sleep(mt_rand(0, 20));
        $fakeUserInfo = FakeUser::getNextUnusedFakeUserInfo();
        $fakename     = $fakeUtil->getRandomName();

        while (!$this->registerUser($fakeUserInfo->phone, $fakename, $now)) {
            $this->warn("[{$fakeUserInfo->phone}已经注册了,生成下一个手机号}]");
            $fakeUserInfo->delete();
            $fakeUserInfo = FakeUser::getNextUnusedFakeUserInfo();
        }
        $fakeUserInfo->update(['date' => $now->toDateString()]);
        $this->logSuccessInfo();
        //$this->notifyMe();

        $leftCount = FakeUser::leftPhonesCount();
        if ($leftCount == 0) {
            Mail::raw("{$now}\tFake-Users表剩余电话数量为:{$leftCount}", function ($message) {
                $message->to('ufoddd001@gmail.com', 'Fake User Registered!');
                $message->from('postmaster@nanzhuxinyu.com', 'nanzhuxinyu');
            });
        }
        return true;
    }

    private function registerUser($phone, $name, $now)
    {
        if (User::where('FLOGIN', $phone)->count() > 0) {
            return false;
        }
        $this->registeredUser = User::create([
            'FID'       => User::max('FID') + 1,
            'FNAME'     => $name,
            'FLOGIN'    => $phone,
            'FPHONE'    => $phone,
            'FCODE'     => $phone,
            'FNEWDATE'  => $now,
            'FEDITDATE' => $now,
            'FSEX'      => rand(1, 2) * 10
        ]);

        return true;
    }

    private function notifyMe()
    {
        $todayRegisteredCount  = FakeUser::todayCompletedCount();
        $justNowRegisteredUser = $this->registeredUser;
        $todayTotalCount       = FakeUser::FAKE_USER_TOTAL_COUNT;

        Mail::send('register_fake_user',
            compact('todayRegisteredCount', 'todayTotalCount', 'justNowRegisteredUser'),
            function ($message) {
                $message->to('ufoddd001@gmail.com', 'Fake User Registered!');
                $message->from('postmaster@nanzhuxinyu.com', 'nanzhuxinyu');
            });
    }

    private function logSuccessInfo()
    {
        $todayCompletedCount = FakeUser::todayCompletedCount();
        $todayTotalCount     = FakeUser::FAKE_USER_TOTAL_COUNT;
        $this->info("第[{$todayCompletedCount}]个用户注册完毕,今日总数是[{$todayTotalCount}],注册用户信息是:[{$this->registeredUser->FLOGIN}]----[{$this->registeredUser->FNAME}]注册成功");
    }

}
