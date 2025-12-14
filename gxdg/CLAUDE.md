# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## 项目概述

这是一个基于 PHPCMS V9 框架开发的公安管理系统,主要用于公安部门的内部管理。

## 核心架构

### MVC 请求流程
```
index.php
  → phpcms/base.php (框架初始化)
  → pc_base::creat_app()
  → application.class.php (路由解析)
  → modules/{m}/{c}.php (控制器)
  → {action}() 方法执行
```

### 路由机制
- **URL 参数**: `?m=module&c=controller&a=action`
- **路由定义**: 通过 `param.class.php` 解析 GET/POST 参数
- **安全过滤**: m/c/a 参数会自动过滤 `/` 和 `.` 防止目录遍历
- **私有方法**: 以 `_` 开头的方法禁止外部访问

### 类加载系统
使用 `pc_base` 静态类统一加载:
- `pc_base::load_sys_class($classname)` - 系统类 (`phpcms/libs/classes/`)
- `pc_base::load_app_class($classname, $module)` - 模块类 (`phpcms/modules/{m}/classes/`)
- `pc_base::load_model($classname)` - 数据模型 (`phpcms/model/`)
- `pc_base::load_config($file, $key)` - 配置文件 (`caches/configs/`)

### 目录结构
```
phpcms/
├── base.php                    # 框架核心启动文件
├── libs/classes/              # 核心类库
│   ├── application.class.php  # 应用程序入口类
│   ├── param.class.php        # 参数处理和路由
│   └── model.class.php        # 数据模型基类
├── modules/                   # 业务模块
│   ├── admin/                 # 后台管理
│   ├── huaxiang/              # 画像模块
│   ├── jiandu/                # 监督模块
│   ├── fujing/                # 辅警管理
│   └── [其他50+业务模块]
└── templates/                 # 模板文件

caches/configs/                # 配置缓存
├── database.php               # 数据库配置
├── system.php                 # 系统配置
└── route.php                  # 路由配置(若存在)

uploadfile/                    # 上传文件目录
statics/                       # 静态资源 (js/css/images)
```

## 数据库配置

配置文件: `caches/configs/database.php`

### 数据库连接
- **default**: 主数据库连接
  - 数据库: `gxdg` @ 192.168.1.66:3306
  - 表前缀: `mj_`
  - 用户名/密码: root/root

- **gxdgdb**: 辅警数据库连接
  - 数据库: `fujing` @ 192.168.1.66:3306
  - 表前缀: `v9_`
  - 用户名/密码: root/root

## 开发规范

### Model 层开发
所有模型继承自 `model` 基类:
```php
class custom_model extends model {
    public function __construct() {
        $this->db_config = pc_base::load_config('database');
        $this->db_setting = 'default';  // 或 'gxdgdb' 使用辅助库
        $this->table_name = 'table_name';  // 不含前缀
        parent::__construct();
    }
}
```

**核心方法**:
- `select($where, $data, $limit, $order, $group, $key)` - 查询多条
- `get_one($where, $data, $order, $group)` - 查询单条
- `insert($data, $return_insert_id, $replace)` - 插入
- `update($data, $where)` - 更新
- `delete($where)` - 删除
- `query($sql)` - 执行原始 SQL (占位符 `phpcms_` 自动替换为实际前缀)

### Controller 层开发
```php
class controller_name {
    public function __construct() {
        // 初始化代码
    }

    public function action_name() {
        // 公开动作方法
    }

    private function _private_method() {
        // 私有方法,无法通过路由访问
    }
}
```

### 安全规范
- **输入过滤**: 所有 GET/POST/COOKIE 已通过 `addslashes` 处理
- **Cookie 加密**: 使用 `sys_auth()` 加密/解密
- **SQL 安全**:
  - `$where` 参数支持数组格式,自动转换为安全的 SQL 条件
  - 使用 `query()` 时,表前缀占位符 `phpcms_` 会被替换
- **路由保护**: 私有方法(下划线开头)无法直接访问

### 数据库操作注意事项
**⚠️ 重要**: 进行任何数据库操作前,必须与实际数据库表结构核对:
- 表名是否正确 (注意表前缀 `mj_` 或 `v9_`)
- 字段名是否存在
- 字段类型是否匹配

### 代码修改原则
1. **最小修改**: 每次将代码改动量压缩到最小
2. **准确性优先**: 不求快,但要保证绝对正确,无潜在问题
3. **数据核对**: 数据库操作必须与实际表结构核对
4. **完整性检查**: 每次完成所有代码修改后,确认有无问题

## 系统配置

配置文件: `caches/configs/system.php`
- 网站路径: `/gxdg/`
- 字符集: UTF-8
- 时区: Etc/GMT-8 (实际为 GMT+8)
- Session 存储: MySQL
- 上传路径: `uploadfile/`
- 静态资源: `http://gongan.myphp.cn/gxdg/statics/`

## 模板和缓存
- 模板目录: `phpcms/templates/default/`
- 编译缓存: `caches/caches_template/`
- 配置缓存: `caches/configs/`
- 数据缓存: `caches/caches_commons/caches_data/`
