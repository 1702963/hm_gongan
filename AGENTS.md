# Repository Guidelines

## 项目结构与模块划分

- 主体代码位于 `gxdg/`，入口 `index.php` 通过 `phpcms/base.php` 启动 PHPCMS。
- 业务接口集中在 `gxdg/api/`（如上传、短信、视频接口）；新增接口请按功能归类放置。
- 框架与模板：`gxdg/phpcms/` 下的 `modules/`、`templates/`、`libs/`；语言包在 `languages/`。
- 配置与缓存：`gxdg/caches/`（数据库配置在 `caches/configs/database.php`，勿提交敏感信息）。
- 定时/工具脚本：`gxdg/cron/`、`gxdg/tools/`；静态资源在 `gxdg/statics/`；上传文件存于 `gxdg/uploads/<YYYYMM>/`。

## 构建、测试与开发命令

- 本地启动（适合单机调试）：`php -S 0.0.0.0:8000 -t gxdg`（需兼容 `mysql_*` 的 PHP 版本）。
- 服务器模拟：将 Web 根目录指向 `gxdg/`，保持与生产路由一致。
- 清理缓存：慎删 `gxdg/caches/` 下生成文件，操作前备份。

## 代码风格与命名规范

- PHP 使用 4 空格缩进，`<?php ?>` 全标签，函数/控制结构与左花括号同一行。
- 变量与函数命名以 snake_case 为主；文件名用小写+下划线（例：`my_feature.php`）。
- 保持现有过程式风格；若引入新特性，确保不破坏依赖 `mysql_*` 的旧代码。
- 所有输入需转义或使用预处理，避免直接拼接 SQL。

## 测试指引

- 当前无自动化测试，建议为关键接口编写轻量脚本或手工用例。
- API 变更请用 `curl` 验证典型路径，如：`curl -X POST http://localhost:8000/api/ajax.php` 并核对 JSON 与数据库写入。
- 上传相关改动需检查权限、文件体积限制及落盘路径 `uploads/<YYYYMM>/`。
- 在 PR 中记录手工测试步骤与结果。

## 提交与合并要求

- Commit 信息使用祈使句简述改动，例如 `Fix upload type checks`，必要时追加简短说明。
- PR 需说明意图、影响范围（涉及的接口/模板/配置）、测试结果，UI 变更附截图（`phpcms/templates/` 相关）。
- 不要提交 `caches/configs` 内的真实凭据，如需示例请用占位符。

## 安全与配置提示

- 所有外部输入（`api/`、`cron/`）必须校验类型、长度与文件扩展名；上传需再次校验大小与 MIME。
- 数据库与第三方密钥请使用本地私有配置加载，勿入库或入仓；新增配置文件遵循现有目录结构，并保持默认安全值。
