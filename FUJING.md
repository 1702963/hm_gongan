# 公安管理系统数据库结构和功能说明文档

> 基于 PHPCMS V9 框架开发的公安部门内部管理系统
>
> 数据库：fujing @ 192.168.1.66:3306
>
> 表前缀：v9_
>
> 文档生成日期：2025-12-12

---

## 目录

- [一、系统概述](#一系统概述)
- [二、核心模块及数据表](#二核心模块及数据表)
  - [1. 用户权限管理模块](#1-用户权限管理模块)
  - [2. 辅警档案管理模块](#2-辅警档案管理模块)
  - [3. 岗位层级管理模块](#3-岗位层级管理模块)
  - [4. 工资管理模块](#4-工资管理模块)
  - [5. 考勤管理模块](#5-考勤管理模块)
  - [6. 教育培训模块](#6-教育培训模块)
  - [7. 奖惩管理模块](#7-奖惩管理模块)
  - [8. 家属信息模块](#8-家属信息模块)
  - [9. 装备管理模块](#9-装备管理模块)
  - [10. 人事管理模块](#10-人事管理模块)
  - [11. 监督管理模块](#11-监督管理模块)
  - [12. 内容管理模块](#12-内容管理模块)
  - [13. 附件管理模块](#13-附件管理模块)
- [三、数据表关系图](#三数据表关系图)
- [四、字段命名规范](#四字段命名规范)

---

## 一、系统概述

### 1.1 系统架构

本系统采用 PHPCMS V9 框架构建，使用 MVC 架构模式。主要功能包括：

- 辅警人员档案管理
- 工资绩效管理
- 考勤管理
- 教育培训管理
- 奖惩记录
- 装备管理
- 监督管理等

### 1.2 数据库连接配置

系统使用两个数据库连接：

**主数据库 (default)**

- 数据库名：gxdg
- 表前缀：mj_
- 主机：192.168.1.66:3306

**辅警数据库 (gxdgdb)**

- 数据库名：fujing
- 表前缀：v9_
- 主机：192.168.1.66:3306

---

## 二、核心模块及数据表

### 1. 用户权限管理模块

#### 1.1 管理员表 (v9_admin)

**表名**: `v9_admin`

**功能**: 存储系统管理员账户信息和权限

**字段说明**:

| 字段名        | 类型         | 说明         | 备注         |
| ------------- | ------------ | ------------ | ------------ |
| userid        | mediumint(6) | 用户ID       | 主键，自增   |
| px            | int(3)       | 排序         | 用于显示顺序 |
| username      | varchar(20)  | 用户名       | 登录账号     |
| password      | varchar(32)  | 密码         | MD5加密      |
| roleid        | smallint(5)  | 角色ID       | 关联角色权限 |
| encrypt       | varchar(6)   | 加密盐       | 密码加密使用 |
| lastloginip   | varchar(15)  | 最后登录IP   | 记录登录IP   |
| lastlogintime | int(10)      | 最后登录时间 | Unix时间戳   |
| email         | varchar(40)  | 邮箱         | 联系邮箱     |
| realname      | varchar(50)  | 真实姓名     | 管理员姓名   |
| card          | varchar(255) | 身份证号     | 管理员身份证 |
| lang          | varchar(6)   | 语言         | 系统语言设置 |
| bmid          | int(10)      | 部门ID       | 所属部门     |
| qianzipic     | varchar(512) | 签字图片     | 电子签名     |
| gongzhangpic  | varchar(512) | 公章图片     | 公章图片路径 |
| isbmuser      | int(1)       | 是否部门用户 | 0=否, 1=是   |

**关联模块**: `phpcms/modules/admin/`

**使用场景**:

- 系统登录验证
- 权限控制
- 操作日志记录

---

#### 1.2 角色表 (v9_admin_role)

**表名**: `v9_admin_role`

**功能**: 定义管理员角色和权限组

**主要功能**:

- 角色定义
- 权限分组
- 权限继承

---

#### 1.3 部门表 (v9_bumen)

**表名**: `v9_bumen`

**功能**: 组织架构和部门信息管理

**字段说明**:

| 字段名    | 类型          | 说明     | 备注             |
| --------- | ------------- | -------- | ---------------- |
| id        | smallint(6)   | 部门ID   | 主键，自增       |
| name      | char(40)      | 部门名称 | 部门全称         |
| parentid  | smallint(6)   | 父部门ID | 树形结构         |
| m         | char(20)      | 模块     | 关联模块         |
| c         | char(20)      | 控制器   | 关联控制器       |
| a         | char(20)      | 动作     | 关联动作方法     |
| data      | char(100)     | 扩展数据 | JSON或序列化数据 |
| listorder | smallint(6)   | 排序     | 显示顺序         |
| display   | enum('1','0') | 是否显示 | 1=显示, 0=隐藏   |

**关联表**:

- v9_admin (bmid)
- v9_fujing (dwid)

---

#### 1.4 会员表 (v9_member)

**表名**: `v9_member`

**功能**: 前台会员账户管理

**字段说明**:

| 字段名    | 类型         | 说明       | 备注           |
| --------- | ------------ | ---------- | -------------- |
| userid    | mediumint(8) | 用户ID     | 主键，自增     |
| phpssouid | mediumint(8) | SSO用户ID  | 单点登录ID     |
| username  | char(20)     | 用户名     | 唯一索引       |
| password  | char(32)     | 密码       | MD5加密        |
| encrypt   | char(6)      | 加密盐     | 安全验证       |
| nickname  | char(20)     | 昵称       | 显示名称       |
| regdate   | int(10)      | 注册时间   | Unix时间戳     |
| lastdate  | int(10)      | 最后登录   | Unix时间戳     |
| regip     | char(15)     | 注册IP     | 注册时IP       |
| lastip    | char(15)     | 最后登录IP | 最后登录IP     |
| loginnum  | smallint(5)  | 登录次数   | 累计登录       |
| email     | char(32)     | 邮箱       | 联系邮箱，索引 |
| groupid   | tinyint(3)   | 用户组ID   | 会员等级       |
| mobile    | char(11)     | 手机号     | 联系电话       |

---

### 2. 辅警档案管理模块

#### 2.1 辅警主表 (v9_fujing)

**表名**: `v9_fujing`

**功能**: 辅警人员基本档案信息，系统核心表

**关联模块**: `phpcms/modules/fujing/`

**字段详细说明**:

##### 基本信息字段

| 字段名     | 类型         | 说明     | 备注               |
| ---------- | ------------ | -------- | ------------------ |
| id         | int(10)      | 辅警ID   | 主键，自增         |
| xingming   | varchar(255) | 姓名     | 辅警姓名           |
| sfz        | varchar(20)  | 身份证号 | 18位身份证         |
| dwid       | int(10)      | 单位ID   | 关联v9_bumen.id    |
| tel        | char(15)     | 电话     | 联系电话           |
| thumb      | varchar(255) | 照片     | 照片路径           |
| sex        | char(10)     | 性别     | 男/女              |
| age        | int(3)       | 年龄     | 根据生日自动计算   |
| shengri    | varchar(32)  | 出生日期 | 生日               |
| sr_yue     | int(2)       | 生日月份 | 1-12，用于生日提醒 |
| minzu      | varchar(30)  | 民族     | 民族名称           |
| hun        | varchar(30)  | 婚姻状况 | 已婚/未婚          |
| jiguan     | varchar(255) | 籍贯     | 籍贯地址           |
| chushengdi | varchar(256) | 出生地   | 出生地址           |
| hjdizhi    | varchar(255) | 户籍地址 | 户口所在地         |
| jzd        | varchar(255) | 居住地   | 现居住地址         |

##### 学历信息字段

| 字段名     | 类型         | 说明       | 备注           |
| ---------- | ------------ | ---------- | -------------- |
| xueli      | varchar(100) | 学历       | 最高学历       |
| xuexiao    | varchar(255) | 毕业学校   | 学校名称       |
| zhuanye    | varchar(255) | 专业       | 所学专业       |
| xuewei     | varchar(256) | 学位       | 学士/硕士/博士 |
| zz_xueli   | int(10)      | 在职学历ID | 在职教育学历   |
| zz_xuexiao | varchar(256) | 在职学校   | 在职教育学校   |
| zz_zhuanye | varchar(256) | 在职专业   | 在职教育专业   |
| zz_xuewei  | varchar(256) | 在职学位   | 在职教育学位   |

##### 岗位职务字段

| 字段名    | 类型         | 说明      | 备注              |
| --------- | ------------ | --------- | ----------------- |
| gangwei   | int(10)      | 岗位ID    | 关联v9_gangwei.id |
| gangweifz | int(9)       | 岗位副职  | 副岗位ID          |
| gw        | varchar(255) | 岗位名称  | 岗位文本          |
| gwdj      | int(9)       | 岗位等级  | 关联v9_gwdj.id    |
| zhiwu     | int(10)      | 职务ID    | 关联v9_zhiwu.id   |
| zhiwu2    | int(10)      | 副职务ID  | 副职务            |
| zy_zhiwu  | int(10)      | 主要职务  | 主要职务ID        |
| cengji    | int(9)       | 层级ID    | 关联v9_cengji.id  |
| cengji3   | int(10)      | 层级3     | 备用层级字段      |
| cj3       | varchar(255) | 层级3名称 | 层级文本          |
| dc        | varchar(255) | 党次      | 党内职务          |

##### 工作信息字段

| 字段名   | 类型         | 说明           | 备注            |
| -------- | ------------ | -------------- | --------------- |
| ygxz     | varchar(255) | 用工性质       | 合同/劳务派遣等 |
| rdtime   | int(10)      | 入队时间       | Unix时间戳      |
| rdzztime | int(10)      | 入党时间       | Unix时间戳      |
| rjtime   | int(10)      | 入警时间       | Unix时间戳      |
| gzz      | varchar(255) | 工作证号       | 工作证编号      |
| gzzztime | int(10)      | 工作证发证时间 | Unix时间戳      |
| gzztime  | int(10)      | 工作证时间     | 工作证有效期    |
| scgztime | int(10)      | 首次工作时间   | 参加工作时间    |
| ddanwei  | varchar(255) | 档案单位       | 档案存放单位    |
| oldjob   | varchar(255) | 原工作单位     | 之前工作单位    |
| zzsj     | int(4)       | 工作年限       | 累计工作年限    |

##### 工资银行字段

| 字段名   | 类型         | 说明     | 备注         |
| -------- | ------------ | -------- | ------------ |
| khh      | varchar(255) | 开户行   | 银行名称     |
| kahao    | varchar(255) | 卡号     | 银行卡号     |
| caizheng | varchar(255) | 财政编号 | 财政工资编号 |
| sbkh     | varchar(255) | 社保卡号 | 社保账号     |
| gzjs     | double(10,2) | 工资基数 | 工资计算基数 |

##### 状态控制字段

| 字段名    | 类型        | 说明     | 备注             |
| --------- | ----------- | -------- | ---------------- |
| status    | int(1)      | 在职状态 | 1=在职, 0=离职   |
| tuiwu     | int(1)      | 是否退伍 | 1=是, 0=否       |
| jingxiao  | int(1)      | 警校生   | 1=是, 0=否       |
| zhuangbei | int(1)      | 装备状态 | 1=正常, 0=异常   |
| shequ     | int(1)      | 社区民警 | 1=是, 0=否       |
| jnbx      | int(1)      | 技能补贴 | 1=有, 0=无       |
| cancengji | int(1)      | 参层级   | 1=参与, 0=不参与 |
| islock    | int(1)      | 锁定状态 | 1=锁定, 0=未锁定 |
| isok      | int(1)      | 有效性   | 1=有效, 0=作废   |
| ismj      | int(1)      | 是否民警 | 1=是, 0=否       |
| mjzt      | varchar(64) | 民警状态 | 民警状态描述     |

##### 离职信息字段

| 字段名       | 类型          | 说明     | 备注         |
| ------------ | ------------- | -------- | ------------ |
| lizhitime    | int(10)       | 离职时间 | Unix时间戳   |
| lizhiyuanyin | varchar(2048) | 离职原因 | 离职说明     |
| zfyy         | varchar(512)  | 作废原因 | 记录作废原因 |

##### 绩效控制字段

| 字段名      | 类型         | 说明     | 备注         |
| ----------- | ------------ | -------- | ------------ |
| kz_zhiban   | decimal(6,2) | 值班控制 | 值班系数     |
| kz_jixiao   | decimal(6,2) | 绩效控制 | 绩效系数     |
| kz_niangong | decimal(6,2) | 年功控制 | 年功工资系数 |

##### 其他信息字段

| 字段名     | 类型         | 说明     | 备注                 |
| ---------- | ------------ | -------- | -------------------- |
| zzmm       | int(2)       | 政治面貌 | 党员/群众等          |
| oldname    | varchar(30)  | 曾用名   | 原名字               |
| jiankang   | varchar(64)  | 健康状况 | 健康状态             |
| zhuanchang | varchar(256) | 专长     | 技能特长             |
| shengao    | double(4,2)  | 身高     | 单位：米             |
| tizhong    | float(4,2)   | 体重     | 单位：公斤           |
| bmi        | float(4,2)   | BMI指数  | 体重指数             |
| dfmj       | varchar(255) | 地方民警 | 地方民警标识         |
| fzlx       | varchar(50)  | 辅助类型 | 辅警类型             |
| scbz       | int(10)      | 生产标准 | 标准编号             |
| jhid       | int(5)       | 计划ID   | 关联计划             |
| ddid       | varchar(64)  | 钉钉ID   | 钉钉用户ID           |
| password   | varchar(255) | 密码     | 登录密码，默认123456 |
| beizhu     | text         | 备注     | 其他说明             |

##### 系统字段

| 字段名       | 类型         | 说明     | 备注       |
| ------------ | ------------ | -------- | ---------- |
| inputtime    | int(10)      | 录入时间 | Unix时间戳 |
| inputuser    | varchar(255) | 录入人   | 操作员     |
| pingdangtime | int(9)       | 评档时间 | Unix时间戳 |
| pingjitime   | int(9)       | 评级时间 | Unix时间戳 |

**主要功能**:

- 辅警基本信息管理
- 学历职务管理
- 在职状态控制
- 工资绩效关联
- 装备发放记录

**关联表**:

- v9_bumen (dwid) - 所属部门
- v9_gangwei (gangwei) - 岗位信息
- v9_zhiwu (zhiwu) - 职务信息
- v9_cengji (cengji) - 层级信息
- v9_gongzi_* - 工资表
- v9_kq* - 考勤表

---

### 3. 岗位层级管理模块

#### 3.1 岗位表 (v9_gangwei)

**表名**: `v9_gangwei`

**功能**: 定义岗位类型和岗位工资标准

**关联模块**: `phpcms/modules/gangwei/`

**字段说明**:

| 字段名 | 类型         | 说明     | 备注         |
| ------ | ------------ | -------- | ------------ |
| id     | int(10)      | 岗位ID   | 主键，自增   |
| gwname | varchar(255) | 岗位名称 | 岗位全称     |
| gongzi | float(7,3)   | 岗位工资 | 岗位工资标准 |

**使用场景**:

- 岗位定义
- 工资计算基础
- 人员岗位分配

---

#### 3.2 职务表 (v9_zhiwu)

**表名**: `v9_zhiwu`

**功能**: 定义职务类型和职务津贴标准

**字段说明**:

| 字段名 | 类型         | 说明     | 备注         |
| ------ | ------------ | -------- | ------------ |
| id     | int(10)      | 职务ID   | 主键，自增   |
| zwname | varchar(255) | 职务名称 | 职务全称     |
| gongzi | float(7,3)   | 职务津贴 | 职务津贴标准 |

**使用场景**:

- 职务管理
- 职务津贴计算
- 干部任免

---

#### 3.3 层级表 (v9_cengji)

**表名**: `v9_cengji`

**功能**: 定义职级层次和对应的工资标准

**字段说明**:

| 字段名  | 类型         | 说明     | 备注           |
| ------- | ------------ | -------- | -------------- |
| id      | int(10)      | 层级ID   | 主键，自增     |
| cjname  | varchar(255) | 层级名称 | 层级全称       |
| nx1     | float        | 年限下限 | 最低年限要求   |
| nx2     | float        | 年限上限 | 最高年限       |
| gongzi  | float(7,3)   | 层级工资 | 层级工资标准   |
| jibengz | decimal(6,2) | 基本工资 | 基础工资额     |
| jxjx    | decimal(6,2) | 绩效基薪 | 绩效基础薪资   |
| px      | int(9)       | 排序     | 显示顺序       |
| autoup  | int(1)       | 自动晋升 | 1=自动, 0=手动 |

**使用场景**:

- 职级管理
- 年限晋升
- 工资计算

---

#### 3.4 岗位等级表 (v9_gwdj)

**表名**: `v9_gwdj`

**功能**: 岗位等级细分

**主要功能**:

- 岗位等级划分
- 等级工资标准
- 晋级管理

---

### 4. 工资管理模块

#### 4.1 工资表设置表 (v9_gongzi_tables)

**表名**: `v9_gongzi_tables`

**功能**: 工资表生成和管理配置

**关联模块**: `phpcms/modules/gongzi/`

**字段说明**:

| 字段名       | 类型        | 说明           | 备注             |
| ------------ | ----------- | -------------- | ---------------- |
| id           | int(10)     | 记录ID         | 主键，自增       |
| tname        | varchar(32) | 表名           | 工资表名称       |
| yue          | varchar(64) | 月份           | 格式：YYYYMM     |
| fromyue      | varchar(64) | 开始月份       | 工资周期开始     |
| toyue        | varchar(64) | 结束月份       | 工资周期结束     |
| ctime        | int(9)      | 创建时间       | Unix时间戳       |
| rows         | int(8)      | 记录数         | 工资记录数量     |
| islocked     | int(1)      | 锁定状态       | 1=锁定, 0=未锁定 |
| isfinish     | int(1)      | 完成状态       | 1=完成, 0=未完成 |
| douser       | varchar(32) | 操作人         | 制表人           |
| dotime       | int(9)      | 操作时间       | Unix时间戳       |
| zzcuser      | int(9)      | 组织处审核人   | 审核人ID         |
| zzcok        | int(1)      | 组织处审核     | 1=通过, 0=未审核 |
| zzcdt        | int(9)      | 组织处审核时间 | Unix时间戳       |
| zhengweiuser | int(9)      | 政委审核人     | 审核人ID         |
| zhengweiok   | int(1)      | 政委审核       | 1=通过, 0=未审核 |
| zhengweidt   | int(9)      | 政委审核时间   | Unix时间戳       |
| juuser       | int(9)      | 局长审核人     | 审核人ID         |
| juok         | int(1)      | 局长审核       | 1=通过, 0=未审核 |
| judt         | int(9)      | 局长审核时间   | Unix时间戳       |

**主要功能**:

- 工资表创建
- 审批流程控制
- 工资表锁定管理

---

#### 4.2 月度工资表 (v9_gz202412, v9_gz202501, ...)

**表名**: `v9_gz202412` (按月份命名，如202412表示2024年12月)

**功能**: 存储每月具体的工资发放数据

**表结构**: 动态生成，每月一张表

**主要字段类型**:

- 基本信息：姓名、身份证、单位
- 岗位工资：岗位、职务、层级工资
- 各类补贴：津贴、补助、奖金
- 扣款项目：社保、公积金、个税
- 汇总字段：应发、实发

**使用场景**:

- 月度工资发放
- 工资条打印
- 工资统计分析

---

#### 4.3 绩效考核表 (v9_gongzi_jixiao)

**表名**: `v9_gongzi_jixiao`

**功能**: 绩效考核评分和结果记录

**字段说明**:

| 字段名  | 类型        | 说明     | 备注             |
| ------- | ----------- | -------- | ---------------- |
| id      | int(11)     | 记录ID   | 主键，自增       |
| userid  | int(9)      | 辅警ID   | 关联v9_fujing.id |
| sfz     | varchar(64) | 身份证号 | 身份验证         |
| bmid    | int(9)      | 部门ID   | 所属部门         |
| gangwei | int(5)      | 岗位ID   | 岗位信息         |
| yue     | varchar(32) | 考核月份 | 格式：YYYYMM     |
| chengji | int(3)      | 总成绩   | 考核总分         |
| kh_dj   | int(5)      | 考核等级 | 考核等级ID       |
| chuqin  | int(3)      | 出勤分   | 出勤得分         |

##### 德的考核

| 字段名      | 类型   | 说明     | 备注       |
| ----------- | ------ | -------- | ---------- |
| kh_de       | int(3) | 德分合计 | 德的总分   |
| de_zhengzhi | int(2) | 政治品德 | 政治表现分 |
| de_zhiye    | int(2) | 职业道德 | 职业道德分 |
| de_shehui   | int(2) | 社会公德 | 社会公德分 |
| de_geren    | int(2) | 个人品德 | 个人品德分 |

##### 能的考核

| 字段名       | 类型   | 说明     | 备注       |
| ------------ | ------ | -------- | ---------- |
| hk_neng      | int(3) | 能分合计 | 能力总分   |
| neng_yewu    | int(2) | 业务能力 | 业务能力分 |
| neng_gongzuo | int(2) | 工作能力 | 工作能力分 |

##### 勤的考核

| 字段名       | 类型   | 说明     | 备注     |
| ------------ | ------ | -------- | -------- |
| kh_qin       | int(3) | 勤分合计 | 勤奋总分 |
| qin_chuqin   | int(2) | 出勤情况 | 出勤得分 |
| qin_biaoxian | int(2) | 工作表现 | 表现得分 |

##### 绩的考核

| 字段名    | 类型   | 说明     | 备注         |
| --------- | ------ | -------- | ------------ |
| kh_ji     | int(3) | 绩分合计 | 工作绩效总分 |
| ji_mubiao | int(2) | 目标完成 | 目标达成分   |
| ji_benzhi | int(2) | 本职工作 | 本职工作分   |

##### 廉的考核

| 字段名       | 类型   | 说明     | 备注     |
| ------------ | ------ | -------- | -------- |
| kh_lian      | int(3) | 廉分合计 | 廉洁总分 |
| lian_lianjie | int(2) | 廉洁自律 | 廉洁得分 |

##### 特殊贡献和任务

| 字段名     | 类型          | 说明     | 备注         |
| ---------- | ------------- | -------- | ------------ |
| tcgongxian | varchar(2048) | 特殊贡献 | 特殊贡献说明 |
| tsrenwu    | varchar(2048) | 特殊任务 | 特殊任务说明 |

##### 审批流程字段

| 字段名   | 类型   | 说明           | 备注             |
| -------- | ------ | -------------- | ---------------- |
| dotime   | int(9) | 提交时间       | Unix时间戳       |
| islock   | int(1) | 锁定状态       | 1=锁定, 0=编辑中 |
| isfinish | int(1) | 完成状态       | 1=完成, 0=进行中 |
| bmuserid | int(9) | 部门用户ID     | 填报人           |
| bmuser   | int(9) | 部门领导       | 部门领导ID       |
| bmok     | int(1) | 部门审核       | 1=通过, 0=未审核 |
| bmdt     | int(9) | 部门审核时间   | Unix时间戳       |
| zguser   | int(9) | 主管领导       | 主管领导ID       |
| zgok     | int(1) | 主管审核       | 1=通过, 0=未审核 |
| zgdt     | int(9) | 主管审核时间   | Unix时间戳       |
| zzcuser  | int(9) | 组织处审核人   | 组织处ID         |
| zzcok    | int(1) | 组织处审核     | 1=通过, 0=未审核 |
| zzcdt    | int(9) | 组织处审核时间 | Unix时间戳       |
| juuser   | int(9) | 局长审核人     | 局长ID           |
| juok     | int(1) | 局长审核       | 1=通过, 0=未审核 |
| judt     | int(9) | 局长审核时间   | Unix时间戳       |

**主要功能**:

- 德能勤绩廉考核
- 分级审批
- 绩效工资计算依据

---

#### 4.4 绩效设置表 (v9_gongzi_jixiao_sets)

**表名**: `v9_gongzi_jixiao_sets`

**功能**: 绩效考核项目和评分标准配置

**主要功能**:

- 考核项目定义
- 评分标准设置
- 考核权重配置

---

#### 4.5 绩效工资表 (v9_gongzi_jxgzb)

**表名**: `v9_gongzi_jxgzb`

**功能**: 根据绩效考核结果计算的绩效工资

**主要功能**:

- 绩效工资计算
- 绩效等级对应工资
- 绩效工资发放记录

---

#### 4.6 考勤工资表 (v9_gongzi_kaoqintables)

**表名**: `v9_gongzi_kaoqintables`

**功能**: 考勤统计结果转化为工资扣款

**主要功能**:

- 考勤统计
- 缺勤扣款计算
- 加班补贴计算

---

#### 4.7 工资设置表 (v9_gongzi_set)

**表名**: `v9_gongzi_set`

**功能**: 工资项目和计算规则配置

**主要功能**:

- 工资项目定义
- 计算公式设置
- 社保基数配置

---

#### 4.8 工资字段表 (v9_gongzi_fies)

**表名**: `v9_gongzi_fies`

**功能**: 工资表动态字段定义

**主要功能**:

- 工资字段管理
- 字段显示控制
- 字段计算公式

---

### 5. 考勤管理模块

#### 5.1 月度考勤表 (v9_kq202412, v9_kq202501, ...)

**表名**: `v9_kq202412` (按月份命名)

**功能**: 记录每月每人每天的出勤情况

**关联模块**: `phpcms/modules/renshi/` (考勤子模块)

**字段说明**:

| 字段名            | 类型          | 说明     | 备注                                       |
| ----------------- | ------------- | -------- | ------------------------------------------ |
| id                | int(9)        | 记录ID   | 主键，自增                                 |
| xingming          | varchar(128)  | 姓名     | 人员姓名                                   |
| sfz               | varchar(128)  | 身份证号 | 唯一标识                                   |
| userid            | int(9)        | 辅警ID   | 关联v9_fujing.id                           |
| bmid              | int(6)        | 部门ID   | 所属部门                                   |
| islock            | int(1)        | 锁定状态 | 1=锁定, 0=可编辑                           |
| beizhu            | varchar(1024) | 备注     | 考勤说明                                   |
| 20241201~20241231 | int(2)        | 每日考勤 | 动态字段，1=正常, 0=休息, 2=病假, 3=事假等 |

##### 审批字段

| 字段名 | 类型   | 说明         | 备注             |
| ------ | ------ | ------------ | ---------------- |
| bmuser | int(9) | 部门审核人   | 部门领导ID       |
| bmok   | int(1) | 部门审核状态 | 1=通过, 0=未审核 |
| bmdt   | int(9) | 部门审核时间 | Unix时间戳       |
| zguser | int(9) | 主管审核人   | 主管领导ID       |
| zgok   | int(1) | 主管审核状态 | 1=通过, 0=未审核 |
| zgdt   | int(9) | 主管审核时间 | Unix时间戳       |

**考勤状态说明**:

- 0: 休息日
- 1: 正常出勤
- 2: 病假
- 3: 事假
- 4: 年假
- 5: 迟到
- 6: 早退
- 7: 旷工
- 8: 出差
- 9: 加班

**主要功能**:

- 每日考勤记录
- 请假管理
- 加班统计
- 考勤统计分析
- 部门审核流程

**关联表**:

- v9_fujing (userid) - 人员档案
- v9_bumen (bmid) - 部门信息
- v9_renshi_xiujia - 请假记录

---

### 6. 教育培训模块

#### 6.1 培训记录表 (v9_peixun)

**表名**: `v9_peixun`

**功能**: 记录辅警参加培训的情况

**关联模块**: `phpcms/modules/peixun/`

**字段说明**:

| 字段名    | 类型         | 说明     | 备注             |
| --------- | ------------ | -------- | ---------------- |
| id        | int(10)      | 记录ID   | 主键，自增       |
| fjid      | int(10)      | 辅警ID   | 关联v9_fujing.id |
| fjname    | varchar(255) | 姓名     | 辅警姓名         |
| sex       | varchar(30)  | 性别     | 男/女            |
| bmid      | int(10)      | 部门ID   | 所属部门         |
| title     | varchar(255) | 培训标题 | 培训项目名称     |
| btime     | int(10)      | 开始时间 | Unix时间戳       |
| etime     | int(10)      | 结束时间 | Unix时间戳       |
| chengji   | varchar(255) | 成绩     | 考试成绩         |
| guo       | int(1)       | 是否通过 | 1=通过, 0=未通过 |
| userid    | int(10)      | 录入人   | 操作员ID         |
| inputtime | int(10)      | 录入时间 | Unix时间戳       |
| shuserid  | int(10)      | 审核人   | 审核人ID         |
| shtime    | int(10)      | 审核时间 | Unix时间戳       |
| shnr      | text         | 审核意见 | 审核内容         |
| status    | int(1)       | 审核状态 | 1=通过, 0=待审核 |

**主要功能**:

- 培训记录管理
- 培训成绩录入
- 培训证书管理
- 培训统计分析

---

#### 6.2 培训档案关联表 (v9_peixun_mj)

**表名**: `v9_peixun_mj`

**功能**: 培训记录与人员档案的多对多关联

**主要功能**:

- 批量培训记录
- 培训人员名单
- 培训统计

---

### 7. 奖惩管理模块

#### 7.1 表彰记录表 (v9_biaozhang)

**表名**: `v9_biaozhang`

**功能**: 记录辅警的奖励和表彰信息

**关联模块**: `phpcms/modules/biaozhang/`

**字段说明**:

| 字段名    | 类型         | 说明     | 备注             |
| --------- | ------------ | -------- | ---------------- |
| id        | int(10)      | 记录ID   | 主键，自增       |
| fjid      | int(10)      | 辅警ID   | 关联v9_fujing.id |
| fjname    | varchar(255) | 姓名     | 辅警姓名         |
| title     | varchar(255) | 奖项标题 | 表彰项目         |
| content   | text         | 奖项内容 | 事迹说明         |
| bztime    | int(10)      | 表彰时间 | Unix时间戳       |
| jl        | text         | 奖励内容 | 奖励措施         |
| gongzi    | float(7,3)   | 奖金金额 | 奖金数额         |
| userid    | int(10)      | 录入人   | 操作员ID         |
| inputtime | int(10)      | 录入时间 | Unix时间戳       |
| shid      | int(10)      | 审核人   | 审核人ID         |
| shtime    | int(10)      | 审核时间 | Unix时间戳       |
| shnr      | text         | 审核意见 | 审核内容         |
| status    | int(1)       | 审核状态 | 1=通过, 0=待审核 |

**主要功能**:

- 奖励记录
- 表彰管理
- 奖金发放
- 荣誉统计

---

#### 7.2 表彰档案关联表 (v9_biaozhang_mj)

**表名**: `v9_biaozhang_mj`

**功能**: 集体表彰的人员关联

**主要功能**:

- 集体奖项管理
- 批量表彰
- 奖项人员名单

---

### 8. 家属信息模块

#### 8.1 家属信息表 (v9_jiashu)

**表名**: `v9_jiashu`

**功能**: 记录辅警家庭成员信息

**关联模块**: `phpcms/modules/jiashu/`

**字段说明**:

| 字段名    | 类型         | 说明     | 备注             |
| --------- | ------------ | -------- | ---------------- |
| id        | int(10)      | 记录ID   | 主键，自增       |
| fjid      | int(10)      | 辅警ID   | 关联v9_fujing.id |
| fjname    | varchar(255) | 辅警姓名 | 本人姓名         |
| xingming  | varchar(255) | 家属姓名 | 家庭成员姓名     |
| sex       | char(20)     | 性别     | 男/女            |
| sfz       | varchar(255) | 身份证号 | 家属身份证       |
| shengri   | varchar(128) | 出生日期 | 家属生日         |
| guanxi    | varchar(255) | 关系     | 与本人关系       |
| dizhi     | varchar(255) | 地址     | 家庭住址         |
| tel       | varchar(255) | 电话     | 联系电话         |
| gzdw      | varchar(244) | 工作单位 | 家属工作单位     |
| zzmm      | int(10)      | 政治面貌 | 政治面貌ID       |
| userid    | int(10)      | 录入人   | 操作员ID         |
| inputtime | int(10)      | 录入时间 | Unix时间戳       |

**主要功能**:

- 家庭成员管理
- 紧急联系人
- 家属信息查询
- 福利发放依据

---

#### 8.2 家属档案关联表 (v9_jiashu_mj)

**表名**: `v9_jiashu_mj`

**功能**: 家属与民警的关联

---

### 9. 装备管理模块

#### 9.1 装备表 (v9_zhuangbei)

**表名**: `v9_zhuangbei`

**功能**: 记录辅警装备的发放和归还情况

**关联模块**: `phpcms/modules/zhuangbei/`

**字段说明**:

| 字段名    | 类型          | 说明       | 备注             |
| --------- | ------------- | ---------- | ---------------- |
| id        | int(10)       | 记录ID     | 主键，自增       |
| fjid      | int(10)       | 辅警ID     | 关联v9_fujing.id |
| fjname    | varchar(255)  | 姓名       | 辅警姓名         |
| bmid      | int(9)        | 部门ID     | 所属部门         |
| zbid      | int(10)       | 装备ID     | 装备类型ID       |
| ffname    | varchar(255)  | 装备名称   | 装备名称         |
| ffshu     | int(3)        | 发放数量   | 数量             |
| fftime    | int(10)       | 发放时间   | Unix时间戳       |
| hhtime    | int(9)        | 归还时间   | Unix时间戳       |
| hhuser    | varchar(32)   | 归还确认人 | 确认人姓名       |
| status    | int(1)        | 状态       | 1=在用, 0=已归还 |
| userid    | int(10)       | 操作员     | 录入人ID         |
| inputtime | int(10)       | 录入时间   | Unix时间戳       |
| beizhu    | varchar(2048) | 备注       | 装备说明         |

**主要功能**:

- 装备发放登记
- 装备归还管理
- 装备在库统计
- 装备使用查询

---

#### 9.2 装备字典表 (v9_zhuangbei_field)

**表名**: `v9_zhuangbei_field`

**功能**: 装备类型和规格定义

**主要功能**:

- 装备类型管理
- 装备规格标准
- 装备库存管理

---

#### 9.3 装备日志表 (v9_zhuangbei_log)

**表名**: `v9_zhuangbei_log`

**功能**: 装备操作日志记录

**主要功能**:

- 操作记录
- 变更追踪
- 审计查询

---

### 10. 人事管理模块

#### 10.1 休假管理表 (v9_renshi_xiujia)

**表名**: `v9_renshi_xiujia`

**功能**: 请假申请和审批管理

**关联模块**: `phpcms/modules/renshi/`

**字段说明**:

| 字段名   | 类型         | 说明       | 备注                     |
| -------- | ------------ | ---------- | ------------------------ |
| id       | int(10)      | 记录ID     | 主键，自增               |
| ns       | int(4)       | 年份       | 请假年份                 |
| ms       | int(2)       | 月份       | 请假月份                 |
| ds       | int(2)       | 日期       | 请假日期                 |
| tjdt     | int(10)      | 提交时间   | Unix时间戳               |
| xingming | varchar(128) | 姓名       | 请假人姓名               |
| uid      | int(10)      | 辅警ID     | 关联v9_fujing.id         |
| danwei   | varchar(512) | 单位       | 所属单位                 |
| dwid     | int(10)      | 单位ID     | 单位ID                   |
| leixing  | varchar(64)  | 请假类型   | 病假/事假/年假等         |
| qtime1   | varchar(64)  | 开始时间   | 请假开始                 |
| qtime2   | varchar(64)  | 结束时间   | 请假结束                 |
| qt1      | int(10)      | 开始时间戳 | Unix时间戳               |
| qt2      | int(10)      | 结束时间戳 | Unix时间戳               |
| shiyou   | varchar(512) | 请假事由   | 请假原因                 |
| beizhu   | varchar(512) | 备注       | 其他说明                 |
| shenhe   | int(1)       | 审核状态   | 1=通过, 0=待审核, 2=拒绝 |
| shuid    | int(10)      | 审核人ID   | 审核人ID                 |
| shdt     | int(10)      | 审核时间   | Unix时间戳               |
| shuser   | varchar(64)  | 审核人     | 审核人姓名               |
| shbeizhu | varchar(512) | 审核意见   | 审核说明                 |
| indt     | int(10)      | 录入时间   | Unix时间戳               |
| isok     | int(1)       | 有效性     | 1=有效, 0=作废           |

**主要功能**:

- 请假申请
- 审批流程
- 假期统计
- 考勤关联

---

#### 10.2 休假清单表 (v9_renshi_xiujialist)

**表名**: `v9_renshi_xiujialist`

**功能**: 休假明细和统计

**主要功能**:

- 假期余额
- 假期使用记录
- 假期到期提醒

---

#### 10.3 人事审批表 (v9_renshi_sx)

**表名**: `v9_renshi_sx`

**功能**: 人事事项审批流转

**主要功能**:

- 调动审批
- 晋升审批
- 奖惩审批

---

### 11. 监督管理模块

#### 11.1 监督类型表

系统包含多个监督管理表，用于不同类型的监督工作：

- **v9_jiandu_gongwu** - 公务监督
- **v9_jiandu_wang** - 网络监督
- **v9_jiandu_xinfang** - 信访监督
- **v9_jiandu_yuqing** - 舆情监督
- **v9_jiandu_zhifa** - 执法监督

**关联模块**: `phpcms/modules/jiandu/`

**主要功能**:

- 监督事项登记
- 处理流程跟踪
- 结果反馈
- 统计分析

---

### 12. 内容管理模块

#### 12.1 栏目分类表 (v9_category)

**表名**: `v9_category`

**功能**: 系统栏目分类和权限控制

**字段说明**:

| 字段名      | 类型         | 说明         | 备注           |
| ----------- | ------------ | ------------ | -------------- |
| catid       | smallint(5)  | 栏目ID       | 主键，自增     |
| siteid      | smallint(5)  | 站点ID       | 多站点支持     |
| module      | varchar(15)  | 模块名       | 所属模块       |
| type        | tinyint(1)   | 栏目类型     | 0=列表, 1=单页 |
| modelid     | smallint(5)  | 模型ID       | 内容模型       |
| parentid    | smallint(5)  | 父栏目ID     | 树形结构       |
| arrparentid | varchar(255) | 父级路径     | 所有父级ID     |
| child       | tinyint(1)   | 是否有子栏目 | 1=是, 0=否     |
| arrchildid  | mediumtext   | 子级路径     | 所有子级ID     |
| catname     | varchar(30)  | 栏目名称     | 栏目标题       |
| catdir      | varchar(30)  | 栏目目录     | URL目录名      |
| url         | varchar(100) | 链接地址     | 访问URL        |
| items       | mediumint(8) | 内容数量     | 文章数量       |
| listorder   | smallint(5)  | 排序         | 显示顺序       |
| ismenu      | tinyint(1)   | 是否菜单     | 1=显示, 0=隐藏 |

**主要功能**:

- 栏目管理
- 权限控制
- 内容分类
- 导航生成

---

#### 12.2 新闻内容表 (v9_news)

**表名**: `v9_news`

**功能**: 新闻文章主表

**关联表**: v9_news_data (内容副表)

**主要功能**:

- 新闻发布
- 文章管理
- 内容审核

---

### 13. 附件管理模块

#### 13.1 附件表 (v9_attachment)

**表名**: `v9_attachment`

**功能**: 系统文件上传和管理

**字段说明**:

| 字段名     | 类型         | 说明       | 备注           |
| ---------- | ------------ | ---------- | -------------- |
| aid        | int(10)      | 附件ID     | 主键，自增     |
| module     | char(15)     | 模块名     | 所属模块       |
| catid      | smallint(5)  | 栏目ID     | 所属栏目       |
| filename   | char(50)     | 文件名     | 原始文件名     |
| filepath   | char(200)    | 文件路径   | 存储路径       |
| filesize   | int(10)      | 文件大小   | 字节数         |
| fileext    | char(10)     | 文件扩展名 | 文件类型       |
| isimage    | tinyint(1)   | 是否图片   | 1=是, 0=否     |
| isthumb    | tinyint(1)   | 是否缩略图 | 1=是, 0=否     |
| downloads  | mediumint(8) | 下载次数   | 下载统计       |
| userid     | mediumint(8) | 上传用户   | 用户ID         |
| uploadtime | int(10)      | 上传时间   | Unix时间戳     |
| uploadip   | char(15)     | 上传IP     | 上传者IP       |
| status     | tinyint(1)   | 状态       | 0=临时, 1=正式 |
| authcode   | char(32)     | 授权码     | 访问验证码     |
| siteid     | smallint(5)  | 站点ID     | 所属站点       |

**主要功能**:

- 文件上传
- 附件管理
- 权限控制
- 下载统计

---

#### 13.2 附件索引表 (v9_attachment_index)

**表名**: `v9_attachment_index`

**功能**: 附件与内容的关联索引

**主要功能**:

- 附件关联
- 快速查询
- 批量操作

---

## 三、数据表关系图

### 3.1 核心关系

```
v9_fujing (辅警档案)
    ├─ dwid → v9_bumen (部门)
    ├─ gangwei → v9_gangwei (岗位)
    ├─ zhiwu → v9_zhiwu (职务)
    ├─ cengji → v9_cengji (层级)
    ├─ id → v9_gongzi_jixiao.userid (绩效考核)
    ├─ id → v9_kq*.userid (考勤记录)
    ├─ id → v9_peixun.fjid (培训记录)
    ├─ id → v9_biaozhang.fjid (表彰记录)
    ├─ id → v9_jiashu.fjid (家属信息)
    ├─ id → v9_zhuangbei.fjid (装备发放)
    └─ id → v9_renshi_xiujia.uid (请假记录)

v9_bumen (部门)
    ├─ id → v9_admin.bmid (管理员)
    └─ id → v9_fujing.dwid (辅警)

v9_gongzi_tables (工资表管理)
    └─ tname → v9_gz*.表名 (月度工资表)

v9_gongzi_jixiao (绩效考核)
    ├─ userid → v9_fujing.id (辅警)
    └─ yue → v9_gongzi_jxgzb.yue (绩效工资)
```

### 3.2 审批流程关系

大多数业务表都包含审批流程字段：

- **部门审核**: bmuser, bmok, bmdt
- **主管审核**: zguser, zgok, zgdt
- **组织处审核**: zzcuser, zzcok, zzcdt
- **政委审核**: zhengweiuser, zhengweiok, zhengweidt
- **局长审核**: juuser, juok, judt

---

## 四、字段命名规范

### 4.1 常用字段前缀

| 前缀 | 说明     | 示例                 |
| ---- | -------- | -------------------- |
| fj   | 辅警相关 | fjid, fjname         |
| dw   | 单位相关 | dwid, dwname         |
| bm   | 部门相关 | bmid, bmuser, bmok   |
| gw   | 岗位相关 | gwname, gwdj         |
| zw   | 职务相关 | zwname               |
| cj   | 层级相关 | cjname               |
| kh   | 考核相关 | kh_de, kh_neng       |
| gz   | 工资相关 | gzjs, gongzi         |
| zb   | 装备相关 | zbid, zbname         |
| sh   | 审核相关 | shuser, shtime, shnr |
| is   | 布尔标识 | islock, isok, ismenu |

### 4.2 常用字段后缀

| 后缀 | 说明        | 示例                      |
| ---- | ----------- | ------------------------- |
| id   | ID标识      | userid, catid, fjid       |
| time | 时间戳      | inputtime, dotime, shtime |
| dt   | 日期时间    | bmdt, zgdt, indt          |
| ok   | 审核状态    | bmok, zgok, zzcok         |
| user | 用户/操作人 | inputuser, douser, shuser |
| nr   | 内容        | shnr (审核内容)           |
| name | 名称        | xingming, gwname, zwname  |

### 4.3 审批流程字段规范

审批相关字段通常成组出现：

```
{角色}user   - 审核人ID     (int)
{角色}ok     - 审核状态     (int, 1=通过, 0=待审核)
{角色}dt     - 审核时间     (int, Unix时间戳)
```

常见角色标识：

- **bm** - 部门
- **zg** - 主管
- **zzc** - 组织处
- **zhengwei** - 政委
- **ju** - 局长

### 4.4 时间字段规范

| 字段类型     | 数据类型 | 格式       | 示例            |
| ------------ | -------- | ---------- | --------------- |
| Unix时间戳   | int(10)  | 秒级时间戳 | 1702368000      |
| 日期字符串   | varchar  | YYYY-MM-DD | 2024-12-12      |
| 月份字符串   | varchar  | YYYYMM     | 202412          |
| 动态日期字段 | int(2)   | 考勤值     | 20241212 (列名) |

### 4.5 状态字段规范

| 字段名   | 含义     | 值说明                   |
| -------- | -------- | ------------------------ |
| status   | 通用状态 | 1=正常/在职, 0=停用/离职 |
| islock   | 锁定状态 | 1=锁定, 0=未锁定         |
| isok     | 有效性   | 1=有效, 0=作废           |
| isfinish | 完成状态 | 1=完成, 0=进行中         |
| shenhe   | 审核状态 | 1=通过, 0=待审核, 2=拒绝 |

---

## 五、备注说明

### 5.1 表命名特点

1. **月度表**: 工资表(v9_gz*)和考勤表(v9_kq*)按月份命名，如 v9_gz202412, v9_kq202412
2. **备份表**: 带有 _bak, _copy, _beifen 等后缀的为备份表
3. **关联表**: 带有 _mj 后缀的为民警关联表，用于多对多关系
4. **日志表**: 带有 _log 后缀的为操作日志表

### 5.2 数据维护建议

1. **月度表管理**: 每月自动生成新的工资表和考勤表，旧表建议保留至少3年
2. **归档策略**: 超过3年的历史数据可以归档到独立的历史库
3. **备份策略**: 重要表(v9_fujing, v9_admin)建议每日备份
4. **索引优化**: 频繁查询的字段(sfz, userid, bmid)建议添加索引

### 5.3 系统扩展性

系统支持以下扩展：

1. **自定义字段**: 通过 model_field 表可扩展字段
2. **多数据库**: 支持配置多个数据库连接
3. **模块化**: 新增模块按照现有模块结构开发
4. **审批流程**: 统一的审批字段设计便于扩展审批级别

---

## 附录：常用查询示例

### A.1 查询在职辅警列表

```sql
SELECT
    id, xingming, sfz, tel,
    (SELECT name FROM v9_bumen WHERE id = v9_fujing.dwid) as danwei,
    (SELECT gwname FROM v9_gangwei WHERE id = v9_fujing.gangwei) as gangwei,
    (SELECT cjname FROM v9_cengji WHERE id = v9_fujing.cengji) as cengji
FROM v9_fujing
WHERE status = 1 AND isok = 1
ORDER BY dwid, xingming
```

### A.2 查询某月工资审批状态

```sql
SELECT
    tname, yue, rows,
    CASE
        WHEN juok = 1 THEN '已完成'
        WHEN zhengweiok = 1 THEN '政委已审'
        WHEN zzcok = 1 THEN '组织处已审'
        ELSE '待审核'
    END as status
FROM v9_gongzi_tables
WHERE yue = '202412'
```

### A.3 统计部门人数

```sql
SELECT
    b.name as 部门,
    COUNT(*) as 人数
FROM v9_fujing f
LEFT JOIN v9_bumen b ON f.dwid = b.id
WHERE f.status = 1 AND f.isok = 1
GROUP BY f.dwid, b.name
ORDER BY b.id
```

### A.4 查询某人考勤明细

```sql
-- 假设查询2024年12月的考勤
SELECT
    xingming, sfz,
    -- 这里需要根据实际月份调整字段名
    CONCAT_WS(',',
        IF(`20241201`=1,'1日正常',''),
        IF(`20241202`=1,'2日正常','')
        -- ... 其他日期
    ) as 考勤明细
FROM v9_kq202412
WHERE sfz = '身份证号'
```

### A.5 查询即将过生日的人员

```sql
SELECT
    xingming, tel, shengri,
    (SELECT name FROM v9_bumen WHERE id = v9_fujing.dwid) as danwei
FROM v9_fujing
WHERE
    status = 1
    AND isok = 1
    AND sr_yue = MONTH(CURDATE())
    AND DAY(FROM_UNIXTIME(shengri)) BETWEEN DAY(CURDATE()) AND DAY(CURDATE()) + 7
ORDER BY DAY(FROM_UNIXTIME(shengri))
```

---

**文档结束**

*如需更详细的字段说明或操作手册，请联系系统管理员。*
