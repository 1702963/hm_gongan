# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## 项目概述

这是一个基于 PHPCMS V9 框架开发的公安管理系统(hm_gongan),包含两个子系统:

- **gxdg**: 主要的公安管理系统(公选辅警系统)
- 使用 PHP 5.6 标准开发

## 数据库架构

### 数据库连接配置

系统使用两个独立的数据库连接(配置文件: `gxdg/caches/configs/database.php`):

**default 连接**

- 数据库: `gxdg`
- 表前缀: `mj_`
- 用途: 主系统数据

**gxdgdb 连接**

- 数据库: `fujing`
- 表前缀: `v9_`
- 用途: 辅警管理相关数据

### 数据库操作规范

⚠️ **关键要求**:

1. **所有数据库操作前必须与实际数据库表结构核对**
   - 表名是否正确(注意 `mj_` 或 `v9_` 前缀)
   - 字段名是否存在
   - 字段类型是否匹配
2. 使用 Model 类时通过 `$this->db_setting` 指定数据库连接:
   - `'default'` - 使用 gxdg 数据库
   - `'gxdgdb'` - 使用 fujing 数据库

### 核心数据表

详细的数据表结构请参考:

- `GXDG数据库结构和功能说明文档.md` - gxdg 数据库(mj_前缀)
- `数据库结构和功能说明文档.md` - fujing 数据库(v9_前缀)

## PHPCMS V9 框架核心架构

### MVC 请求流程

```
index.php (入口)
  → phpcms/base.php (框架初始化)
  → pc_base::creat_app() (创建应用)
  → libs/classes/application.class.php (路由解析)
  → modules/{m}/{c}.php (控制器)
  → {action}() 方法执行
```

### URL 路由机制

**标准 URL 格式**: `?m=module&c=controller&a=action`

- `m` - 模块名 (module)
- `c` - 控制器名 (controller)
- `a` - 动作方法名 (action)

**路由安全**:

- m/c/a 参数自动过滤 `/` 和 `.` 防止目录遍历
- 以 `_` 开头的方法为私有方法,禁止外部访问
- 参数解析: `libs/classes/param.class.php`

### 类加载系统

PHPCMS 使用 `pc_base` 静态类统一管理类加载:

```php
// 加载系统类 (phpcms/libs/classes/)
pc_base::load_sys_class($classname);

// 加载模块类 (phpcms/modules/{m}/classes/)
pc_base::load_app_class($classname, $module);

// 加载数据模型 (phpcms/model/)
pc_base::load_model($classname);

// 加载配置文件 (caches/configs/)
pc_base::load_config($file, $key);
```

## 目录结构

```
gxdg/
├── index.php                      # 系统入口文件
├── admin.php                      # 后台管理入口
├── api.php                        # API接口入口
├── phpcms/
│   ├── base.php                  # 框架核心启动文件
│   ├── libs/
│   │   └── classes/              # 核心类库
│   │       ├── application.class.php
│   │       ├── param.class.php
│   │       └── model.class.php
│   ├── modules/                  # 业务模块(50+个)
│   │   ├── admin/               # 后台管理
│   │   ├── fujing/              # 辅警管理
│   │   ├── gangwei/             # 岗位管理
│   │   ├── gongzi/              # 工资管理
│   │   ├── renshi/              # 人事管理
│   │   ├── jiandu/              # 监督管理
│   │   ├── peixun/              # 培训管理
│   │   ├── biaozhang/           # 表彰管理
│   │   ├── zhuangbei/           # 装备管理
│   │   ├── youfu/               # 优抚管理
│   │   ├── xuanchuan/           # 宣传管理
│   │   ├── huaxiang/            # 画像模块
│   │   └── ...                  # 其他业务模块
│   ├── templates/               # 模板文件
│   └── model/                   # 数据模型基类
├── caches/
│   └── configs/                 # 配置缓存目录
│       ├── database.php         # 数据库配置
│       └── system.php           # 系统配置
├── uploadfile/                  # 文件上传目录
└── statics/                     # 静态资源(js/css/images)
```

## Model 层开发规范

### 创建 Model

所有模型必须继承 `model` 基类:

```php
class custom_model extends model {
    public function __construct() {
        $this->db_config = pc_base::load_config('database');
        $this->db_setting = 'default';  // 或 'gxdgdb'
        $this->table_name = 'table_name'; // 不含前缀
        parent::__construct();
    }
}
```

### Model 核心方法

```php
// 查询多条记录
select($where, $data = '*', $limit = '', $order = '', $group = '', $key = '');

// 查询单条记录
get_one($where, $data = '*', $order = '', $group = '');

// 插入数据
insert($data, $return_insert_id = false, $replace = false);

// 更新数据
update($data, $where = '');

// 删除数据
delete($where);

// 执行原始SQL (占位符 phpcms_ 会自动替换为实际表前缀)
query($sql);
```

### WHERE 条件构造

支持数组格式自动转换为安全的 SQL 条件:

```php
// 数组格式
$where = array('status' => 1, 'isok' => 1);

// 字符串格式(需自行转义)
$where = "status=1 AND isok=1";
```

## Controller 层开发规范

```php
class controller_name {
    public function __construct() {
        // 初始化代码
    }

    public function action_name() {
        // 公开动作方法,可通过 URL 访问
    }

    private function _private_method() {
        // 私有方法,无法通过路由访问
    }
}
```

## 核心业务模块说明

### 辅警管理 (fujing)

- 辅警档案管理
- 在职状态控制
- 岗位职务分配
- 核心表: `mj_fujing` / `v9_fujing`

### 工资管理 (gongzi)

- 工资表生成(按月动态创建: `mj_gz202412`, `v9_gz202412`)
- 绩效考核(`mj_gongzi_jixiao`, `v9_gongzi_jixiao`)
- 分级审批流程(部门→主管→组织处→政委→局长)
- 核心表: `mj_gongzi_tables`, `v9_gongzi_tables`

### 考勤管理 (renshi 子模块)

- 月度考勤表(按月动态创建: `mj_kq202412`, `v9_kq202412`)
- 请假管理(`mj_renshi_xiujia`, `v9_renshi_xiujia`)
- 考勤状态: 0=休息, 1=正常, 2=病假, 3=事假, 7=旷工, 9=加班
- 每日考勤字段动态生成(如: `20241201`, `20241202`)

### 岗位层级管理

- 岗位表(`mj_gangwei`, `v9_gangwei`) - 岗位工资标准
- 职务表(`mj_zhiwu`, `v9_zhiwu`) - 职务津贴标准
- 层级表(`mj_cengji`, `v9_cengji`) - 职级工资标准

### 其他核心模块

- **peixun** - 培训记录管理
- **biaozhang** - 表彰奖励管理
- **jiandu** - 监督管理(公务/网络/信访/舆情/执法)
- **zhuangbei** - 装备发放管理
- **youfu** - 优抚申报管理
- **xuanchuan** - 宣传素材管理

## 审批流程规范

系统大部分业务表包含统一的审批流程字段:

```php
// 审批字段组(每级审批包含3个字段)
{角色}user  - 审核人ID (int)
{角色}ok    - 审核状态 (int: 1=通过, 0=待审核)
{角色}dt    - 审核时间 (int: Unix时间戳)

// 常见审批角色
bmuser, bmok, bmdt         // 部门审核
zguser, zgok, zgdt         // 主管审核
zzcuser, zzcok, zzcdt      // 组织处审核
zhengweiuser, zhengweiok, zhengweidt  // 政委审核
juuser, juok, judt         // 局长审核
```

## 安全规范

### 输入安全

- 所有 GET/POST/COOKIE 已通过 `addslashes` 自动处理
- Cookie 使用 `sys_auth()` 函数加密/解密

### SQL 安全

- 优先使用 Model 的数组 WHERE 条件
- 使用 `query()` 执行原始 SQL 时,表前缀占位符 `phpcms_` 会自动替换
- 手动构造 SQL 时必须做好参数转义

### 路由安全

- 私有方法(下划线开头)无法通过 URL 直接访问
- m/c/a 参数自动过滤目录遍历字符

## 开发注意事项

### 代码修改原则

⚠️ **最高优先级规则**:

1. **不使用 desktop-commander 的 edit_block 工具**
2. **不使用 serena 工具进行代码修改**(其他操作可以)
3. **每次将代码改动量压缩到最小**
4. **不求快,但要保证绝对正确,无潜在问题**
5. **每完成一次代码修改后,确认有无问题**

### PHP 版本要求

- **统一使用 PHP 5.6 标准开发**
- 避免使用 PHP 7+ 的新特性

### 数据库操作检查清单

- [ ] 表名是否正确(mj_ 或 v9_ 前缀)
- [ ] 字段是否存在于实际表中
- [ ] 字段类型是否匹配
- [ ] 是否使用了正确的数据库连接(default/gxdgdb)

### 常用字段命名规范

**字段前缀**:

- `fj` - 辅警相关(fjid, fjname)
- `bm` - 部门相关(bmid, bmuser, bmok)
- `gw` - 岗位相关(gwname, gwdj)
- `zw` - 职务相关(zwname)
- `cj` - 层级相关(cjname)
- `kh` - 考核相关(kh_de, kh_neng)
- `sh` - 审核相关(shuser, shtime, shnr)

**字段后缀**:

- `id` - ID标识
- `time` - Unix时间戳
- `dt` - 日期时间
- `ok` - 审核状态
- `user` - 操作人
- `name` - 名称

**状态字段**:

- `status` - 1=正常/在职, 0=停用/离职
- `islock` - 1=锁定, 0=未锁定
- `isok` - 1=有效, 0=作废
- `shenhe` - 1=通过, 0=待审核, 2=拒绝

## 系统配置

### 系统路径

- 网站路径: `/gxdg/`
- 上传路径: `uploadfile/`
- 静态资源: `statics/`

### 字符编码

- 数据库字符集: UTF-8
- 时区: Etc/GMT-8 (实际为 GMT+8)

### Session 存储

- 存储方式: MySQL
- 配置文件: `caches/configs/system.php`

## 模板和缓存

- 模板目录: `phpcms/templates/default/`
- 编译缓存: `caches/caches_template/`
- 配置缓存: `caches/configs/`
- 数据缓存: `caches/caches_commons/caches_data/`

## 常见开发任务

### 创建新的业务模块

1. 在 `phpcms/modules/` 创建模块目录
2. 创建控制器文件(继承自相应的基类)
3. 创建 Model 类(继承 `model`)
4. 在数据库创建对应的表(注意表前缀)

### 添加新字段到现有表

1. 先在数据库中添加字段
2. 更新对应的 Model 类(如需要)
3. 修改控制器逻辑处理新字段
4. 更新模板显示新字段

### 修改审批流程

1. 检查表中是否已有审批字段组
2. 按照标准格式添加: {角色}user, {角色}ok, {角色}dt
3. 在控制器中实现审批逻辑
4. 更新前端显示审批状态

### 查询动态月度表

```php
// 工资表
$table_name = 'gz' . date('Ym'); // 如: gz202412
$this->table_name = $table_name;

// 考勤表
$table_name = 'kq' . date('Ym'); // 如: kq202412
$this->table_name = $table_name;
```

## 参考文档

项目包含详细的数据库结构文档:

- `GXDG数据库结构和功能说明文档.md` - gxdg 数据库完整说明
- `数据库结构和功能说明文档.md` - fujing 数据库完整说明
- `gxdg/CLAUDE.md` - gxdg 子系统的详细说明

这些文档包含:

- 所有数据表的详细字段说明
- 表之间的关联关系
- 字段命名规范
- 常用查询示例
