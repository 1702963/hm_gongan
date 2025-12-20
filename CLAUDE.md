# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## 项目概述

基于 PHPCMS V9 框架开发的公安辅警管理系统，使用 **PHP 5.6** 标准开发。

主要功能: 辅警档案、工资绩效、考勤、培训、奖惩、装备、监督、招录考试、优抚管理、党建管理。

## 快速开始

### 本地开发环境初始化

1. **克隆项目并进入目录**
   ```bash
   cd /Volumes/DATA/host/gongan/hm_gongan
   ```

2. **创建数据库配置**
   - 编辑 `gxdg/caches/configs/database.php`
   - 配置 default 连接（`gxdg` 数据库，前缀 `mj_`）
   - 配置 gxdgdb 连接（`fujing` 数据库，前缀 `v9_`）
   - ⚠️ 勿提交真实数据库凭据到 Git

3. **初始化数据库表**
   ```bash
   # 使用 DDL.txt 创建所有表结构
   mysql -h 192.168.1.66 -u root -proot < DDL.txt
   ```

### 常用开发命令

```bash
# 启动本地开发服务器
php -S 0.0.0.0:8000 -t gxdg

# 连接数据库
mysql -h 192.168.1.66 -u root -proot

# 清理模板编译缓存（修改模板后需运行）
rm -rf gxdg/caches/caches_template/*

# 清理数据缓存
rm -rf gxdg/caches/caches_commons/caches_data/*

# 清理全部缓存（需谨慎，操作前备份）
rm -rf gxdg/caches/*
```

## 项目结构与文件组织

### 核心入口与路由

- **前台入口**: `gxdg/index.php?m=模块&c=控制器&a=方法`
- **后台入口**: `gxdg/admin.php?m=模块&c=控制器&a=方法`
- **API 入口**: `gxdg/api.php?op=操作名`

### 目录说明

| 目录 | 用途 |
|------|------|
| `gxdg/phpcms/modules/` | 业务模块（50+ 个，包括 fujing、gongzi、renshi、peixun 等） |
| `gxdg/phpcms/templates/` | 模板文件（默认主题在 `default/`） |
| `gxdg/phpcms/libs/classes/` | 框架核心类库（application、model、param 等） |
| `gxdg/phpcms/model/` | 数据模型基类 |
| `gxdg/api/` | 业务接口脚本（上传、短信、视频等） |
| `gxdg/caches/` | 缓存目录，包含配置、编译、数据缓存 |
| `gxdg/caches/configs/` | 配置文件（database.php、system.php） |
| `gxdg/caches/caches_template/` | 模板编译缓存 |
| `gxdg/uploadfile/` | 上传文件存储（访问路径） |
| `gxdg/uploads/` | 按月份组织的上传文件（`uploads/<YYYYMM>/`） |
| `gxdg/cron/` | 定时任务脚本 |
| `gxdg/statics/` | 静态资源（JS、CSS、图片） |
| `DDL.txt` | 数据库表结构 SQL（用于初始化） |
| `GXDG.md` | gxdg 数据库文档（mj_ 前缀表结构） |
| `FUJING.md` | fujing 数据库文档（v9_ 前缀表结构） |

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

## 代码风格与命名规范

- **缩进**: PHP 使用 4 空格缩进，不使用制表符
- **标签**: 使用完整 `<?php ?>` 标签，不使用短标签
- **花括号**: 函数/控制结构与左花括号同一行
- **变量命名**: snake_case（如 `$user_name`，`$is_active`）
- **函数命名**: snake_case（如 `get_user_info()`）
- **文件命名**: 小写 + 下划线（如 `my_feature.php`）
- **常量**: UPPER_SNAKE_CASE
- **类名**: PascalCase
- **保持兼容**: 避免使用 PHP 7+ 特性，维持 PHP 5.6 兼容性

## 测试与验证

### 手工测试流程

当前无自动化测试框架。对关键接口进行手工验证：

```bash
# 测试 API 接口
curl -X POST http://localhost:8000/api/ajax.php -d "param=value"

# 验证数据库写入
mysql -h 192.168.1.66 -u root -proot -e "SELECT * FROM database.table LIMIT 1;"
```

### 测试检查清单

- [ ] **上传功能**: 检查文件大小限制、扩展名白名单、存储路径 `uploads/<YYYYMM>/`
- [ ] **数据变更**: 验证数据库记录是否正确写入/更新
- [ ] **权限控制**: 确保只有授权用户可访问受限功能
- [ ] **边界条件**: 测试空值、极值、特殊字符输入
- [ ] **错误处理**: 验证异常情况下的错误消息和日志记录

### 提交与 PR 要求

- **Commit 信息**: 使用祈使句，例如 `Fix upload type checks` 或 `Add BMI calculation feature`
- **PR 说明**: 包含以下内容
  - 功能描述与改动意图
  - 涉及的模块/接口/配置
  - 手工测试步骤与结果
  - UI 变更需附截图（`phpcms/templates/` 相关）
  - 数据库表结构变更需说明
- **勿提交**: 真实数据库凭据、API 密钥、调试代码

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

## 安全编码规范（必读）

### SQL 注入防护

⚠️ **现有代码中存在大量 SQL 注入漏洞，新代码必须规避**：

```php
// ❌ 错误写法 - 直接拼接用户输入
$id = $_GET['id'];
$this->db->get_one("id=$id");

// ✅ 正确写法 - 整数参数用 intval
$id = intval($_GET['id']);
$this->db->get_one("id=$id");

// ✅ 正确写法 - 使用数组条件
$this->db->get_one(array('id' => intval($_GET['id'])));

// ❌ 错误写法 - LIKE 查询直接拼接
$where .= " AND xingming LIKE '%$xingming%' ";

// ✅ 正确写法
$xingming = addslashes($_GET['xingming']);
$where .= " AND xingming LIKE '%" . $xingming . "%' ";
```

### 变量初始化

```php
// ❌ 错误写法 - 未初始化直接追加
$where .= " AND status=1";

// ✅ 正确写法
$where = "isok=1";
$where .= " AND status=1";

// ❌ 错误写法 - 数组未初始化
$gangweifz[$aaa['id']] = $aaa['gwname'];

// ✅ 正确写法
$gangweifz = array();
foreach ($rss as $aaa) {
    $gangweifz[$aaa['id']] = $aaa['gwname'];
}
```

### 生产环境禁用项

```php
// ❌ 禁止出现
ini_set("display_errors", "On");
error_reporting(E_ALL);

// 调试代码提交前必须删除
```

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
- [ ] **GET/POST 整数参数是否用 intval() 处理**
- [ ] **字符串参数是否用 addslashes() 或数组条件**
- [ ] **WHERE 变量是否已初始化**

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

## 定时任务与后台脚本

### 定时任务架构

定时任务脚本位于 `gxdg/cron/` 目录：

- **cron.php**: 纯 PHP 定时器（常驻进程），定时触发业务脚本
- **tasktime.php**: 具体业务逻辑执行脚本

### 定时任务开发规范

1. **业务逻辑分离**: 定时器只做触发，业务逻辑放在单独脚本中
2. **时隙管理**: `sleep()` 控制执行间隔
3. **错误处理**: 记录执行日志，便于调试和监控
4. **性能考虑**: 避免在定时任务中执行长时间操作

## API 接口开发

### 接口目录组织

所有业务接口脚本放在 `gxdg/api/` 目录，按功能分类：

- **上传接口**: 文件上传、图片处理
- **短信接口**: 短信发送、验证
- **视频接口**: 视频处理、转码
- **数据接口**: 数据导入、导出

### API 接口安全要求

⚠️ **关键安全规范**：

1. **输入校验**
   - 参数类型检查（整数用 `intval()`，字符串用 `addslashes()`）
   - 长度限制检查
   - 文件扩展名白名单验证

2. **文件上传安全**
   - 再次验证文件大小
   - 再次验证 MIME 类型
   - 严格限制上传路径（仅允许 `uploads/<YYYYMM>/`）

3. **输出安全**
   - JSON 响应使用 `json_encode()` 防止 XSS
   - 避免直接输出用户输入

4. **敏感信息保护**
   - 数据库凭据仅在 `gxdg/caches/configs/database.php` 中
   - 第三方 API 密钥不入库
   - 勿在日志中输出敏感信息

## 常见开发场景

### 添加新的业务表

1. 在 `DDL.txt` 中添加 CREATE TABLE 语句
2. 执行 SQL 在数据库中创建表
3. 创建对应的 Model 类
4. 创建 Controller 和视图（如需要）
5. 更新 `GXDG.md` 或 `FUJING.md` 文档

### 修改动态月度表

工资表、考勤表等按月动态创建：

```php
// 动态表名示例
$table_name = 'gz' . date('Ym');  // 如: gz202412
$table_name = 'kq' . date('Ym');  // 如: kq202412

$this->table_name = $table_name;
```

### 处理文件上传

上传文件自动按年月组织：

```php
// 上传文件存储路径
$upload_dir = 'uploads/' . date('Ym') . '/';  // 如: uploads/202412/
```

## 自定义 Agents

项目配置了专用 agents (`.claude/agents/`):

- **phpcms-module-builder**: 创建 PHPcms 模块、MVC 结构、API 开发
- **php-api-test-automator**: 自动化测试 PHP API 接口
- **phpcms-frontend-developer**: 开发 PHPcms 模板页面

## 参考文档

- `GXDG.md` - gxdg 数据库结构 (mj_ 前缀, 180张表)
- `FUJING.md` - fujing 数据库结构 (v9_ 前缀, 337张表)
- `AGENTS.md` - 项目结构指南