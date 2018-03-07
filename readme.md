【登录系统】
1、执行php artisan make:auth 命令
  ----会创建HomeController控制器、在web.php 文件中添加Auth::routes()【作用:生成用户认证路由,包括登录、注册、重置密码、忘记密码,可以使用php artisan route:list 指令查看路由情况】

2、在app/LoginController中,
   (1)设置用户名 验证字段
   public function username()
    {
        return 'name'; //用户名对应的字段，
        			   //默认验证email字段，在trait AuthenticatesUsers类中
    }
    (2)修改默认的认证方式
    a、在config/auth.php文件中，添加新的认证方式：
    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'api' => [
            'driver' => 'token',
            'provider' => 'users',
        ],
        'admin' => [    //为新增的认证方式
            'driver' => 'token',
            'provider' => 'users',
        ],
    ],

    b、在app/LoginController中，添加
	protected function guard()
    {
        return Auth::guard(‘admin’);
    }
    和 直接给中间件传递guard参数，
    如$this->middleware('guest:admin', ['except' => 'logout']);
    或者直接修改config/auth.php文件中的defaults['guard']=>'admin'【默认使用defaults中的认证方式】
    和 在app/LoginController中, 直接给中间件传递guard参数，
    如$this->middleware('guest:admin', ['except' => 'logout']);
3、如果用户登录成功，就会跳转到 redirectTo属性 指向的url地址;


4、 用户登录成功后，可以通过以下方法，获取登录用户的信息：
	Auth::user()   -- 获取登录用户的实例
	Auth::id()     -- 获取登录用户的id
	Auth::check()  -- 检测用户是否登录


【权限控制】
	---- 针对已经认证的用户

1、通过路由中间件，获取左侧一二级菜单，添加到$request->attributes属性中
2、
（1）通过路由中间件，来判断用户是否有权限访问;即用户访问的权限在不在其权限组内
（2）通过Gate类进行授权，将用户所有的权限全部define进去;再在中间件中判断当前权限是否授权allow。
【在AuthServiceProvider类中，进行授权：
			 Gate::define($permission->name, function ($user) use ($permission) {
                return $user->per($user->role_id, $permission->id);
            });
		/**
         * 共有权限
         **/
        foreach (config('auth.public') as $name) {
            Gate::define($name, function () {
                return true;
            });
        }
    】

 3、把权限注册到路由：
 通过读取数据库中的权限，经过相应的替换，批量添加到路由。
  Route::any('数据库中读取', '数据库中读取')->name('test');