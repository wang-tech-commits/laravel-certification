# laravel-certification

> 个人实名认证
## 1.安装

```shell script
composer require wang-tech-commits/laravel-certification
```

## 2.初始化

```shell script
php artisan vendor:publish --provider="MrwangTc\UserCertification\ServiceProvider"

php artisan migrate
```

## 3.使用

### 1.调整用户模型

```php
<?php

use MrwangTc\UserCertification\Certification\Traits\HasUserCertification;

class User {

    use HasUserCertification;
}
```

### 2.增加路由

```php
<?php

use MrwangTc\UserCertification\UserCertification;


/**
 * $prefix string 路由前缀
 * 当前方法推荐放置于需授权的路由作用域内
 */
UserCertification::routes('user');

```