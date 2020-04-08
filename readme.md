## 安装使用

- 1、先安装composer和php运行环境
- 2、克隆项目  

    git clone https://github.com/111Quentin/work_blog.git
- 3、安装依赖

    composer install 
- 4、创建配置文件
   
   cp .env.example .env
   
   php artisan key:generate 生成密钥
   
   修改DB_CONNECTION、DB_HOST、DB_PORT、DB_DATABASE、DB_USERNAME、DB_PASSWORD等字段
    
- 5.数据迁移

    php artisan migrate
    
    默认创建一个用户名为admin的超级管理员

- 6.运行项目，在项目根文件夹下执行

    php artisan serve



