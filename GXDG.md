# GXDG 数据库结构和功能说明文档

> 基于 PHPCMS V9 框架开发的公安管理系统主数据库
>
> 数据库：gxdg @ 192.168.1.66:3306
>
> 表前缀：mj_
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
  - [10. 被装管理模块](#10-被装管理模块)
  - [11. 人事管理模块](#11-人事管理模块)
  - [12. 监督管理模块](#12-监督管理模块)
  - [13. 招录考试模块](#13-招录考试模块)
  - [14. 优抚管理模块](#14-优抚管理模块)
  - [15. 宣传管理模块](#15-宣传管理模块)
  - [16. 内容管理模块](#16-内容管理模块)
  - [17. 附件管理模块](#17-附件管理模块)
- [三、数据表关系图](#三数据表关系图)
- [四、字段命名规范](#四字段命名规范)

---

## 一、系统概述

### 1.1 系统架构

本系统是基于 PHPCMS V9 框架构建的公安管理系统主数据库，采用 MVC 架构模式。主要功能包括：

- 辅警人员档案管理
- 工资绩效管理
- 考勤管理
- 教育培训管理
- 奖惩记录
- 装备和被装管理
- 招录考试管理
- 优抚管理
- 宣传素材管理
- 监督管理等

### 1.2 数据库配置

**主数据库 (default)**

- 数据库名：gxdg
- 表前缀：mj_
- 主机：192.168.1.66:3306
- 表数量：180张

### 1.3 与 fujing 数据库的关系

- **gxdg 数据库**: 主数据库，表前缀为 mj_，用于系统主要功能
- **fujing 数据库**: 辅助数据库，表前缀为 v9_，用于辅警管理相关功能
- 两个数据库结构相似，但 gxdg 包含更多扩展模块

---

## 二、核心模块及数据表

### 1. 用户权限管理模块

#### 1.1 管理员表 (mj_admin)

**表名**: `mj_admin`

**功能**: 存储系统管理员账户信息和权限

**字段说明**:

| 字段名        | 类型         | 说明         | 备注           |
| ------------- | ------------ | ------------ | -------------- |
| userid        | mediumint(6) | 用户ID       | 主键，自增     |
| px            | int(3)       | 排序         | 用于显示顺序   |
| username      | varchar(20)  | 用户名       | 登录账号，索引 |
| password      | varchar(32)  | 密码         | MD5加密        |
| roleid        | smallint(5)  | 角色ID       | 关联角色权限   |
| encrypt       | varchar(6)   | 加密盐       | 密码加密使用   |
| lastloginip   | varchar(15)  | 最后登录IP   | 记录登录IP     |
| lastlogintime | int(10)      | 最后登录时间 | Unix时间戳     |
| email         | varchar(40)  | 邮箱         | 联系邮箱       |
| realname      | varchar(50)  | 真实姓名     | 管理员姓名     |
| card          | varchar(255) | 身份证号     | 管理员身份证   |
| lang          | varchar(6)   | 语言         | 系统语言设置   |
| bmid          | int(10)      | 部门ID       | 所属部门       |
| qianzipic     | varchar(512) | 签字图片     | 电子签名       |
| gongzhangpic  | varchar(512) | 公章图片     | 公章图片路径   |
| isbmuser      | int(1)       | 是否部门用户 | 0=否, 1=是     |
| qxkuo         | varchar(512) | 权限扩展     | 扩展权限设置   |
| uuid          | int(6)       | 唯一ID       | 默认100000     |
| ismj          | int(1)       | 是否民警     | 0=否, 1=是     |
| ys            | int(4)       | 年份         | 默认2000       |
| ms            | int(2)       | 月份         | 默认1          |
| ds            | int(2)       | 日期         | 默认1          |
| isman         | int(1)       | 是否管理员   | 0=否, 1=是     |

**关联模块**: `phpcms/modules/admin/`

**主要功能**:

- 系统登录验证
- 权限控制
- 操作日志记录
- 部门权限管理

---

#### 1.2 角色表 (mj_admin_role)

**表名**: `mj_admin_role`

**功能**: 定义管理员角色和权限组

**主要功能**:

- 角色定义
- 权限分组
- 权限继承

---

#### 1.3 部门表 (mj_bumen)

**表名**: `mj_bumen`

**功能**: 组织架构和部门信息管理

**字段说明**:

| 字段名     | 类型          | 说明       | 备注             |
| ---------- | ------------- | ---------- | ---------------- |
| id         | smallint(6)   | 部门ID     | 主键，自增       |
| ubmid      | int(10)       | 上级部门ID | 部门层级         |
| name       | char(40)      | 部门名称   | 部门全称         |
| parentid   | smallint(6)   | 父部门ID   | 树形结构         |
| m          | char(20)      | 模块       | 关联模块         |
| c          | char(20)      | 控制器     | 关联控制器       |
| a          | char(20)      | 动作       | 关联动作方法     |
| data       | char(100)     | 扩展数据   | JSON或序列化数据 |
| listorder  | smallint(6)   | 排序       | 显示顺序         |
| display    | enum('1','0') | 是否显示   | 1=显示, 0=隐藏   |
| project1-5 | tinyint(1)    | 项目标识   | 项目归属标识     |

**关联表**:

- mj_admin (bmid)
- mj_fujing (dwid)

---

#### 1.4 会员表 (mj_member)

**表名**: `mj_member`

**功能**: 前台会员账户管理

**主要功能**:

- 会员注册登录
- 会员信息管理
- 会员等级管理

---

### 2. 辅警档案管理模块

#### 2.1 辅警主表 (mj_fujing)

**表名**: `mj_fujing`

**功能**: 辅警人员基本档案信息，系统核心表

**关联模块**: `phpcms/modules/fujing/`

**字段详细说明**:

##### 基本信息字段

| 字段名   | 类型         | 说明     | 备注               |
| -------- | ------------ | -------- | ------------------ |
| id       | int(10)      | 辅警ID   | 主键，自增         |
| xingming | varchar(255) | 姓名     | 辅警姓名           |
| sfz      | varchar(20)  | 身份证号 | 18位身份证         |
| dwid     | int(10)      | 单位ID   | 关联mj_bumen.id    |
| tel      | char(15)     | 电话     | 联系电话           |
| thumb    | varchar(255) | 照片     | 照片路径           |
| sex      | char(10)     | 性别     | 男/女              |
| age      | int(3)       | 年龄     | 根据生日自动计算   |
| shengri  | varchar(32)  | 出生日期 | 生日               |
| sr_yue   | int(1)       | 生日月份 | 1-12，用于生日提醒 |
| minzu    | varchar(30)  | 民族     | 民族名称           |
| hun      | varchar(30)  | 婚姻状况 | 已婚/未婚          |
| jiguan   | varchar(255) | 籍贯     | 籍贯地址           |
| hjdizhi  | varchar(255) | 户籍地址 | 户口所在地         |
| jzd      | varchar(255) | 居住地   | 现居住地址         |
| oldname  | varchar(30)  | 曾用名   | 原名字             |

##### 学历信息字段

| 字段名  | 类型         | 说明     | 备注     |
| ------- | ------------ | -------- | -------- |
| xueli   | varchar(100) | 学历     | 最高学历 |
| xuexiao | varchar(255) | 毕业学校 | 学校名称 |
| zhuanye | varchar(255) | 专业     | 所学专业 |

##### 岗位职务字段

| 字段名    | 类型         | 说明      | 备注              |
| --------- | ------------ | --------- | ----------------- |
| gangwei   | int(10)      | 岗位ID    | 关联mj_gangwei.id |
| gangweifz | int(9)       | 岗位副职  | 副岗位ID          |
| gw        | varchar(255) | 岗位名称  | 岗位文本          |
| gwdj      | int(9)       | 岗位等级  | 关联mj_gwdj.id    |
| zhiwu     | int(10)      | 职务ID    | 关联mj_zhiwu.id   |
| cengji    | int(9)       | 层级ID    | 关联mj_cengji.id  |
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

| 字段名   | 类型         | 说明     | 备注                 |
| -------- | ------------ | -------- | -------------------- |
| zzmm     | int(2)       | 政治面貌 | 党员/群众等          |
| shengao  | double(4,2)  | 身高     | 单位：米             |
| tizhong  | float(4,2)   | 体重     | 单位：公斤           |
| bmi      | float(4,2)   | BMI指数  | 体重指数             |
| dfmj     | varchar(255) | 地方民警 | 地方民警标识         |
| fzlx     | varchar(50)  | 辅助类型 | 辅警类型             |
| scbz     | int(10)      | 生产标准 | 标准编号             |
| jhid     | int(5)       | 计划ID   | 关联计划             |
| ddid     | varchar(64)  | 钉钉ID   | 钉钉用户ID           |
| password | varchar(255) | 密码     | 登录密码，默认123456 |
| beizhu   | text         | 备注     | 其他说明             |

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

---

### 3. 岗位层级管理模块

#### 3.1 岗位表 (mj_gangwei)

**表名**: `mj_gangwei`

**功能**: 定义岗位类型和岗位工资标准

**关联模块**: `phpcms/modules/gangwei/`

**字段说明**:

| 字段名 | 类型         | 说明     | 备注         |
| ------ | ------------ | -------- | ------------ |
| id     | int(10)      | 岗位ID   | 主键，自增   |
| gwname | varchar(255) | 岗位名称 | 岗位全称     |
| gongzi | float(7,3)   | 岗位工资 | 岗位工资标准 |

---

#### 3.2 职务表 (mj_zhiwu)

**表名**: `mj_zhiwu`

**功能**: 定义职务类型和职务津贴标准

**字段说明**:

| 字段名 | 类型         | 说明     | 备注         |
| ------ | ------------ | -------- | ------------ |
| id     | int(10)      | 职务ID   | 主键，自增   |
| zwname | varchar(255) | 职务名称 | 职务全称     |
| gongzi | float(7,3)   | 职务津贴 | 职务津贴标准 |

---

#### 3.3 层级表 (mj_cengji)

**表名**: `mj_cengji`

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

---

### 4. 工资管理模块

#### 4.1 工资表设置表 (mj_gongzi_tables)

**表名**: `mj_gongzi_tables`

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

---

#### 4.2 绩效考核表 (mj_gongzi_jixiao)

**表名**: `mj_gongzi_jixiao`

**功能**: 绩效考核评分和结果记录

**字段说明**:

| 字段名  | 类型        | 说明     | 备注             |
| ------- | ----------- | -------- | ---------------- |
| id      | int(11)     | 记录ID   | 主键，自增       |
| userid  | int(9)      | 辅警ID   | 关联mj_fujing.id |
| sfz     | varchar(64) | 身份证号 | 身份验证         |
| bmid    | int(9)      | 部门ID   | 所属部门         |
| gangwei | int(5)      | 岗位ID   | 岗位信息         |
| yue     | varchar(32) | 考核月份 | 格式：YYYYMM     |
| chengji | int(3)      | 总成绩   | 考核总分         |
| kh_dj   | int(5)      | 考核等级 | 考核等级ID       |
| chuqin  | int(3)      | 出勤分   | 出勤得分         |

##### 德能勤绩廉考核字段

| 分类 | 字段名       | 类型   | 说明     |
| ---- | ------------ | ------ | -------- |
| 德   | kh_de        | int(3) | 德分合计 |
| 德   | de_zhengzhi  | int(2) | 政治品德 |
| 德   | de_zhiye     | int(2) | 职业道德 |
| 德   | de_shehui    | int(2) | 社会公德 |
| 德   | de_geren     | int(2) | 个人品德 |
| 能   | hk_neng      | int(3) | 能分合计 |
| 能   | neng_yewu    | int(2) | 业务能力 |
| 能   | neng_gongzuo | int(2) | 工作能力 |
| 勤   | kh_qin       | int(3) | 勤分合计 |
| 勤   | qin_chuqin   | int(2) | 出勤情况 |
| 勤   | qin_biaoxian | int(2) | 工作表现 |
| 绩   | kh_ji        | int(3) | 绩分合计 |
| 绩   | ji_mubiao    | int(2) | 目标完成 |
| 绩   | ji_benzhi    | int(2) | 本职工作 |
| 廉   | kh_lian      | int(3) | 廉分合计 |
| 廉   | lian_lianjie | int(2) | 廉洁自律 |

##### 特殊项目字段

| 字段名     | 类型          | 说明     | 备注         |
| ---------- | ------------- | -------- | ------------ |
| tcgongxian | varchar(2048) | 特殊贡献 | 特殊贡献说明 |
| tsrenwu    | varchar(2048) | 特殊任务 | 特殊任务说明 |

##### 审批流程字段（部门-主管-组织处-局长）

**主要功能**:

- 德能勤绩廉考核
- 分级审批
- 绩效工资计算依据

---

### 5. 考勤管理模块

#### 5.1 月度考勤表 (mj_kq202404)

**表名**: `mj_kq202404` (按月份命名，如202404表示2024年4月)

**功能**: 记录每月每人每天的出勤情况

**关联模块**: `phpcms/modules/renshi/` (考勤子模块)

**主要字段**:

- 基本信息：xingming, sfz, userid, bmid
- 状态控制：islock, beizhu
- 动态日期字段：每天一个字段
- 审批字段：bmuser, bmok, bmdt, zguser, zgok, zgdt

**考勤状态值**:

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

---

### 6. 教育培训模块

#### 6.1 培训记录表 (mj_peixun)

**表名**: `mj_peixun`

**功能**: 记录辅警参加培训的情况

**关联模块**: `phpcms/modules/peixun/`

**字段说明**:

| 字段名    | 类型         | 说明     | 备注             |
| --------- | ------------ | -------- | ---------------- |
| id        | int(10)      | 记录ID   | 主键，自增       |
| fjid      | int(10)      | 辅警ID   | 关联mj_fujing.id |
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

---

### 7. 奖惩管理模块

#### 7.1 表彰记录表 (mj_biaozhang)

**表名**: `mj_biaozhang`

**功能**: 记录辅警的奖励和表彰信息

**关联模块**: `phpcms/modules/biaozhang/`

**字段说明**:

| 字段名    | 类型         | 说明     | 备注             |
| --------- | ------------ | -------- | ---------------- |
| id        | int(10)      | 记录ID   | 主键，自增       |
| fjid      | int(10)      | 辅警ID   | 关联mj_fujing.id |
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

---

### 8. 家属信息模块

#### 8.1 家属信息表 (mj_jiashu)

**表名**: `mj_jiashu`

**功能**: 记录辅警家庭成员信息

**关联模块**: `phpcms/modules/jiashu/`

**字段说明**:

| 字段名    | 类型         | 说明     | 备注             |
| --------- | ------------ | -------- | ---------------- |
| id        | int(10)      | 记录ID   | 主键，自增       |
| fjid      | int(10)      | 辅警ID   | 关联mj_fujing.id |
| fjname    | varchar(255) | 辅警姓名 | 本人姓名         |
| xingming  | varchar(255) | 家属姓名 | 家庭成员姓名     |
| sex       | char(20)     | 性别     | 男/女            |
| sfz       | varchar(255) | 身份证号 | 家属身份证       |
| dizhi     | varchar(255) | 地址     | 家庭住址         |
| guanxi    | varchar(255) | 关系     | 与本人关系       |
| tel       | varchar(255) | 电话     | 联系电话         |
| gzdw      | varchar(244) | 工作单位 | 家属工作单位     |
| userid    | int(10)      | 录入人   | 操作员ID         |
| inputtime | int(10)      | 录入时间 | Unix时间戳       |

---

### 9. 装备管理模块

#### 9.1 装备表 (mj_zhuangbei)

**表名**: `mj_zhuangbei`

**功能**: 记录辅警装备的发放和归还情况

**关联模块**: `phpcms/modules/zhuangbei/`

**字段说明**:

| 字段名    | 类型          | 说明       | 备注             |
| --------- | ------------- | ---------- | ---------------- |
| id        | int(10)       | 记录ID     | 主键，自增       |
| fjid      | int(10)       | 辅警ID     | 关联mj_fujing.id |
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

---

### 10. 被装管理模块

#### 10.1 被装字典表 (mj_beizhuang_zidian)

**表名**: `mj_beizhuang_zidian`

**功能**: 被装类型和规格定义

**关联模块**: `phpcms/modules/beizhuang/` (可能)

**主要功能**:

- 被装类型管理
- 规格尺码定义
- 配发标准设置

---

#### 10.2 被装批次表 (mj_beizhuang_pici)

**表名**: `mj_beizhuang_pici`

**功能**: 被装发放批次管理

**主要功能**:

- 批次创建
- 发放计划
- 批次统计

---

#### 10.3 被装领取日志 (mj_beizhuang_linglog)

**表名**: `mj_beizhuang_linglog`

**功能**: 被装领取记录

**主要功能**:

- 领取登记
- 尺码记录
- 签收确认

---

#### 10.4 被装用户日志 (mj_beizhuang_ulog)

**表名**: `mj_beizhuang_ulog`

**功能**: 被装使用和归还记录

**主要功能**:

- 使用记录
- 损坏登记
- 更换记录

---

### 11. 人事管理模块

#### 11.1 休假管理表 (mj_renshi_xiujia)

**表名**: `mj_renshi_xiujia`

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
| uid      | int(10)      | 辅警ID     | 关联mj_fujing.id         |
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

---

### 12. 监督管理模块

#### 12.1 监督类型表

系统包含多个监督管理表，用于不同类型的监督工作：

- **mj_jiandu_gongwu** - 公务监督
- **mj_jiandu_wang** - 网络监督
- **mj_jiandu_xinfang** - 信访监督
- **mj_jiandu_yuqing** - 舆情监督
- **mj_jiandu_zhifa** - 执法监督

**关联模块**: `phpcms/modules/jiandu/`

**主要功能**:

- 监督事项登记
- 处理流程跟踪
- 结果反馈
- 统计分析

---

### 13. 招录考试模块

#### 13.1 笔试信息表 (gx_bishi)

**表名**: `gx_bishi`

**功能**: 招录考试笔试考生信息

**字段说明**:

| 字段名   | 类型         | 说明         | 备注       |
| -------- | ------------ | ------------ | ---------- |
| id       | int(10)      | 记录ID       | 主键，自增 |
| xh       | varchar(255) | 序号         | 考生序号   |
| xingming | varchar(255) | 姓名         | 考生姓名   |
| sfz      | varchar(255) | 身份证号     | 身份证     |
| sex      | varchar(255) | 性别         | 男/女      |
| kch      | varchar(255) | 考场号       | 考场编号   |
| zwh      | varchar(255) | 座位号       | 座位编号   |
| zkzh     | varchar(255) | 准考证号     | 准考证编号 |
| xcdt     | int(10)      | 现场登记时间 | Unix时间戳 |
| dndt     | int(10)      | 电脑登记时间 | Unix时间戳 |

**关联模块**: 招录管理模块

---

#### 13.2 笔试成绩表 (gx_bishi_cj)

**表名**: `gx_bishi_cj`

**功能**: 笔试成绩记录

**主要功能**:

- 成绩录入
- 成绩查询
- 成绩统计

---

#### 13.3 笔试报表 (gx_bishibb)

**表名**: `gx_bishibb`

**功能**: 笔试统计报表

---

#### 13.4 面试成绩表 (gx_mianshi_cj)

**表名**: `gx_mianshi_cj`

**功能**: 面试成绩记录

**主要功能**:

- 面试成绩录入
- 面试评分管理
- 综合成绩计算

---

#### 13.5 体测信息表 (gx_tice)

**表名**: `gx_tice`

**功能**: 体能测试信息

**主要功能**:

- 体测项目管理
- 体测成绩录入
- 体测标准判定

---

#### 13.6 体测成绩表 (gx_tice_cj)

**表名**: `gx_tice_cj`

**功能**: 体测成绩记录

---

### 14. 优抚管理模块

#### 14.1 优抚申报表 (mj_youfu_shenbao)

**表名**: `mj_youfu_shenbao`

**功能**: 优抚事项申报管理

**关联模块**: `phpcms/modules/youfu/` (可能)

**字段说明**:

| 字段名   | 类型         | 说明     | 备注             |
| -------- | ------------ | -------- | ---------------- |
| id       | int(10)      | 记录ID   | 主键，自增       |
| xingming | varchar(256) | 姓名     | 申请人姓名       |
| uid      | int(10)      | 用户ID   | 关联mj_fujing.id |
| danwei   | varchar(256) | 单位     | 所属单位         |
| dwid     | int(10)      | 单位ID   | 单位ID           |
| sblx     | varchar(32)  | 申报类型 | 默认"优抚"       |
| leixing  | varchar(256) | 具体类型 | 优抚类别         |
| cont     | text         | 内容     | 申报内容         |
| ns       | int(4)       | 年份     | 申报年份         |
| ms       | int(2)       | 月份     | 申报月份         |
| ds       | int(2)       | 日期     | 申报日期         |
| tjdt     | int(10)      | 提交时间 | Unix时间戳       |
| indt     | int(10)      | 录入时间 | Unix时间戳       |
| zmup     | text         | 证明文件 | 附件路径         |
| qtup     | text         | 其他文件 | 其他附件         |
| isok     | int(1)       | 有效性   | 1=有效, 0=作废   |
| shenhe   | int(1)       | 审核状态 | 1=通过, 0=待审核 |
| shdt     | int(10)      | 审核时间 | Unix时间戳       |
| shuser   | varchar(255) | 审核人   | 审核人姓名       |
| shbz     | text         | 审核备注 | 审核意见         |
| clbz     | text         | 处理备注 | 处理说明         |
| inuser   | varchar(256) | 录入人   | 录入人姓名       |
| inuid    | int(10)      | 录入人ID | 录入人ID         |
| bjzt     | int(1)       | 办结状态 | 1=办结, 0=进行中 |
| bjdt     | int(10)      | 办结时间 | Unix时间戳       |
| sfje     | varchar(20)  | 实发金额 | 发放金额         |

**主要功能**:

- 优抚申请
- 审批流程
- 发放管理
- 统计查询

---

#### 14.2 优抚政策表 (mj_youfu_zhengce)

**表名**: `mj_youfu_zhengce`

**功能**: 优抚政策文件管理

---

#### 14.3 优抚体检表 (mj_youfu_tijian)

**表名**: `mj_youfu_tijian`

**功能**: 优抚对象体检记录

---

#### 14.4 优抚工会社保表 (mj_youfu_gonghuisb)

**表名**: `mj_youfu_gonghuisb`

**功能**: 工会和社保福利管理

---

#### 14.5 优抚风险表 (mj_youfu_fengxian)

**表名**: `mj_youfu_fengxian`

**功能**: 优抚风险管控

---

#### 14.6 优抚标签表 (mj_youfu_tags)

**表名**: `mj_youfu_tags`

**功能**: 优抚对象标签分类

---

### 15. 宣传管理模块

#### 15.1 宣传素材表 (mj_xuanchuan_sucai)

**表名**: `mj_xuanchuan_sucai`

**功能**: 宣传素材库管理

**关联模块**: `phpcms/modules/xuanchuan/` (可能)

**主要功能**:

- 素材上传
- 素材分类
- 素材检索
- 素材下载

---

#### 15.2 宣传稿件表 (mj_xuanchuan_gaojian)

**表名**: `mj_xuanchuan_gaojian`

**功能**: 宣传稿件管理

**主要功能**:

- 稿件撰写
- 稿件审核
- 稿件发布
- 稿件统计

---

#### 15.3 宣传标签表 (mj_xuanchuan_tags)

**表名**: `mj_xuanchuan_tags`

**功能**: 宣传素材标签分类

---

### 16. 内容管理模块

#### 16.1 栏目分类表 (mj_category)

**表名**: `mj_category`

**功能**: 系统栏目分类和权限控制

**主要功能**:

- 栏目管理
- 权限控制
- 内容分类
- 导航生成

---

#### 16.2 新闻内容表 (mj_news)

**表名**: `mj_news`

**功能**: 新闻文章主表

**关联表**: mj_news_data (内容副表)

---

#### 16.3 图片内容表 (mj_picture)

**表名**: `mj_picture`

**功能**: 图片管理

**关联表**: mj_picture_data (图片数据表)

---

#### 16.4 视频内容表 (mj_video)

**表名**: `mj_video`

**功能**: 视频管理

**关联表**: mj_video_data, mj_video_content, mj_video_store

---

### 17. 附件管理模块

#### 17.1 附件表 (mj_attachment)

**表名**: `mj_attachment`

**功能**: 系统文件上传和管理

**主要字段**:

- aid: 附件ID
- module: 所属模块
- catid: 所属栏目
- filename: 文件名
- filepath: 文件路径
- filesize: 文件大小
- fileext: 文件扩展名
- isimage: 是否图片
- downloads: 下载次数
- userid: 上传用户
- uploadtime: 上传时间
- status: 状态
- authcode: 授权码

---

#### 17.2 附件索引表 (mj_attachment_index)

**表名**: `mj_attachment_index`

**功能**: 附件与内容的关联索引

---

## 三、数据表关系图

### 3.1 核心关系

```
mj_fujing (辅警档案)
    ├─ dwid → mj_bumen (部门)
    ├─ gangwei → mj_gangwei (岗位)
    ├─ zhiwu → mj_zhiwu (职务)
    ├─ cengji → mj_cengji (层级)
    ├─ id → mj_gongzi_jixiao.userid (绩效考核)
    ├─ id → mj_kq*.userid (考勤记录)
    ├─ id → mj_peixun.fjid (培训记录)
    ├─ id → mj_biaozhang.fjid (表彰记录)
    ├─ id → mj_jiashu.fjid (家属信息)
    ├─ id → mj_zhuangbei.fjid (装备发放)
    ├─ id → mj_renshi_xiujia.uid (请假记录)
    └─ id → mj_youfu_shenbao.uid (优抚申报)

mj_bumen (部门)
    ├─ id → mj_admin.bmid (管理员)
    ├─ id → mj_fujing.dwid (辅警)
    └─ ubmid → mj_bumen.id (上级部门)

mj_gongzi_tables (工资表管理)
    └─ tname → 动态工资表 (月度工资表)

mj_gongzi_jixiao (绩效考核)
    ├─ userid → mj_fujing.id (辅警)
    └─ yue → mj_gongzi_jxgzb.yue (绩效工资)
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
| gx   | 公选相关 | gx_bishi, gx_mianshi |
| yf   | 优抚相关 | mj_youfu_*           |

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
| bz   | 备注        | beizhu, shbz, clbz        |

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

| 字段类型   | 数据类型 | 格式       | 示例         |
| ---------- | -------- | ---------- | ------------ |
| Unix时间戳 | int(10)  | 秒级时间戳 | 1702368000   |
| 日期字符串 | varchar  | YYYY-MM-DD | 2024-12-12   |
| 月份字符串 | varchar  | YYYYMM     | 202412       |
| 年月日分离 | int      | ns, ms, ds | 2024, 12, 12 |

### 4.5 状态字段规范

| 字段名   | 含义     | 值说明                   |
| -------- | -------- | ------------------------ |
| status   | 通用状态 | 1=正常/在职, 0=停用/离职 |
| islock   | 锁定状态 | 1=锁定, 0=未锁定         |
| isok     | 有效性   | 1=有效, 0=作废           |
| isfinish | 完成状态 | 1=完成, 0=进行中         |
| shenhe   | 审核状态 | 1=通过, 0=待审核, 2=拒绝 |
| bjzt     | 办结状态 | 1=办结, 0=进行中         |

---

## 五、GXDG 数据库特色功能

### 5.1 招录考试系统

GXDG 数据库独有的招录考试管理功能，包括：

- **笔试管理** (gx_bishi系列表)

  - 考生信息管理
  - 考场座位分配
  - 成绩录入统计
- **面试管理** (gx_mianshi_cj)

  - 面试评分
  - 综合成绩计算
- **体能测试** (gx_tice系列表)

  - 体测项目管理
  - 体测成绩记录
  - 标准判定

### 5.2 优抚管理系统

完整的优抚管理功能模块：

- **优抚申报** (mj_youfu_shenbao)

  - 申请提交
  - 审批流程
  - 发放管理
- **优抚福利** (mj_youfu_gonghuisb)

  - 工会福利
  - 社保管理
- **优抚体检** (mj_youfu_tijian)

  - 体检安排
  - 体检记录
- **优抚政策** (mj_youfu_zhengce)

  - 政策文件管理
  - 政策查询

### 5.3 被装管理系统

专业的被装管理功能：

- 被装类型管理
- 批次管理
- 领取登记
- 尺码管理
- 损坏更换

### 5.4 宣传素材系统

宣传工作支持：

- 素材库管理
- 稿件管理
- 标签分类
- 检索下载

---

## 六、备注说明

### 6.1 表命名特点

1. **主表前缀**: mj_ 开头的为主业务表
2. **考试系列**: gx_ 开头的为招录考试相关表
3. **备份表**: 带有 _bak, _copy, _fz 等后缀的为备份表
4. **新表**: 带有 _new 后缀的为新版本表

### 6.2 与 fujing 数据库的区别

| 特性       | GXDG 数据库 (mj_)       | FUJING 数据库 (v9_)  |
| ---------- | ----------------------- | -------------------- |
| 表数量     | 180张                   | 337张                |
| 工资考勤表 | 较少历史表              | 按月保存大量历史表   |
| 特色功能   | 招录、优抚、被装、宣传  | 更多月度工资/考勤表  |
| 管理员表   | mj_admin (扩展字段更多) | v9_admin             |
| 辅警表     | mj_fujing (字段较少)    | v9_fujing (字段更多) |

### 6.3 数据维护建议

1. **数据同步**: GXDG 和 FUJING 数据库需要保持人员档案同步
2. **备份策略**: 重要表(mj_fujing, mj_admin)建议每日备份
3. **索引优化**: 频繁查询的字段(sfz, userid, bmid)建议添加索引
4. **归档策略**: 考试、优抚等历史数据可定期归档

### 6.4 系统扩展性

系统支持以下扩展：

1. **自定义字段**: 通过 mj_model_field 表可扩展字段
2. **多数据库**: 支持配置多个数据库连接
3. **模块化**: 新增模块按照现有模块结构开发
4. **审批流程**: 统一的审批字段设计便于扩展审批级别

---

## 附录：常用查询示例

### A.1 查询在职辅警列表

```sql
SELECT
    id, xingming, sfz, tel,
    (SELECT name FROM mj_bumen WHERE id = mj_fujing.dwid) as danwei,
    (SELECT gwname FROM mj_gangwei WHERE id = mj_fujing.gangwei) as gangwei,
    (SELECT cjname FROM mj_cengji WHERE id = mj_fujing.cengji) as cengji
FROM mj_fujing
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
FROM mj_gongzi_tables
WHERE yue = '202404'
```

### A.3 统计部门人数

```sql
SELECT
    b.name as 部门,
    COUNT(*) as 人数
FROM mj_fujing f
LEFT JOIN mj_bumen b ON f.dwid = b.id
WHERE f.status = 1 AND f.isok = 1
GROUP BY f.dwid, b.name
ORDER BY b.id
```

### A.4 查询优抚申报进度

```sql
SELECT
    xingming, danwei, leixing,
    CASE shenhe
        WHEN 1 THEN '已审核'
        WHEN 0 THEN '待审核'
        ELSE '已拒绝'
    END as 审核状态,
    CASE bjzt
        WHEN 1 THEN '已办结'
        ELSE '进行中'
    END as 办结状态,
    sfje as 实发金额
FROM mj_youfu_shenbao
WHERE ns = 2024 AND isok = 1
ORDER BY tjdt DESC
```

### A.5 查询招录考试成绩

```sql
SELECT
    b.xingming, b.sfz, b.zkzh,
    bc.笔试成绩,
    mc.面试成绩,
    tc.体测成绩,
    (bc.笔试成绩 + mc.面试成绩 + tc.体测成绩) as 总成绩
FROM gx_bishi b
LEFT JOIN gx_bishi_cj bc ON b.id = bc.bsid
LEFT JOIN gx_mianshi_cj mc ON b.id = mc.bsid
LEFT JOIN gx_tice_cj tc ON b.id = tc.bsid
ORDER BY 总成绩 DESC
```

---

**文档结束**

*如需更详细的字段说明或操作手册，请联系系统管理员。*
