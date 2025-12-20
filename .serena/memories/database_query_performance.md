# 数据库查询性能优化规范

## 核心原则
**抽取数据库数据时，要做到性能最优。**

## 性能优化检查清单

### 查询优化
- [ ] 只查询需要的字段，不用 `SELECT *`
- [ ] 使用合适的 WHERE 条件，避免全表扫描
- [ ] 使用索引字段在 WHERE 条件中
- [ ] 避免在 WHERE 条件中使用函数
- [ ] 避免 OR 条件，改用 IN() 或 UNION

### 分页查询
- [ ] 大数据量查询必须分页
- [ ] 使用 LIMIT 限制返回记录数
- [ ] 避免 OFFSET 过大（如 LIMIT 100000, 20）

### JOIN 优化
- [ ] 多表关联时，使用合适的 JOIN 类型
- [ ] 确保 JOIN 条件基于索引字段
- [ ] 避免三个以上的表 JOIN

### 数据量考虑
- [ ] 一次查询的返回数据量不超过必需
- [ ] 大数据导出需要分批处理
- [ ] 避免在循环中执行数据库查询

### 缓存策略
- [ ] 频繁查询的数据考虑缓存
- [ ] 使用 PHPCMS 缓存机制存储查询结果
- [ ] 设置合理的缓存过期时间

### 监控与调试
- [ ] 开启数据库 debug 模式查看执行的 SQL
- [ ] 关注查询执行时间
- [ ] 使用 EXPLAIN 分析慢查询

## 最佳实践示例

### ❌ 性能差的写法
```php
// 1. 查询全部字段
$data = $this->select("", "*");  // 不必要的字段

// 2. 全表扫描
$data = $this->select("");

// 3. 大 OFFSET
$data = $this->select("", "*", "50000, 20");

// 4. 循环查询
foreach ($ids as $id) {
    $item = $this->get_one("id=$id");  // N+1 问题
}

// 5. 多个字段 OR 条件
$data = $this->select("name='$a' OR name='$b' OR name='$c'");
```

### ✅ 性能优的写法
```php
// 1. 只查询需要的字段
$data = $this->select("", "id, name, status");

// 2. 使用 WHERE 条件
$data = $this->select("status=1", "id, name");

// 3. 合理分页
$data = $this->select("status=1", "id, name", "0, 20");

// 4. 批量查询
$data = $this->select("id IN (".implode(',', $ids).")", "id, name");

// 5. 使用 IN 代替多个 OR
$data = $this->select("name IN ('$a', '$b', '$c')", "id, name");

// 6. 使用索引字段过滤
$data = $this->select("user_id=$uid AND status=1", "id, name");
```

## 相关文档参考
- CLAUDE.md - Model 层开发规范
- 数据库配置：gxdg/caches/configs/database.php
- 推荐使用框架方法而不是手写 SQL
