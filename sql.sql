--
-- 后台管理员表 `admin_users`
--
DROP TABLE IF EXISTS `admin_users`;
CREATE TABLE `admin_users`
(
    `id`             int UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `username`       varchar(191) NOT NULL COMMENT '用户名',
    `password`       varchar(60)  NOT NULL COMMENT '密码',
    `name`           varchar(191) NOT NULL COMMENT '管理员名称',
    `avatar`         varchar(191) DEFAULT NULL COMMENT '头像',
    `remember_token` varchar(100) DEFAULT NULL COMMENT '记住我',
    `created_at`     timestamp NULL DEFAULT NULL,
    `updated_at`     timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 后台角色表 `admin_roles`
--
DROP TABLE IF EXISTS `admin_roles`;
CREATE TABLE `admin_roles`
(
    `id`         int UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name`       varchar(50) NOT NULL COMMENT '角色名称',
    `slug`       varchar(50) NOT NULL COMMENT '角色标识',
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 后台菜单表 `admin_menu`
--
DROP TABLE IF EXISTS `admin_menu`;
CREATE TABLE `admin_menu`
(
    `id`         int UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `parent_id`  int         NOT NULL DEFAULT '0' COMMENT '菜单父id',
    `order`      int         NOT NULL DEFAULT '0' COMMENT '菜单排序',
    `title`      varchar(50) NOT NULL COMMENT '菜单标题',
    `icon`       varchar(50) NOT NULL COMMENT '菜单图标',
    `uri`        varchar(191)         DEFAULT NULL COMMENT '菜单路径',
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 后台权限表 `admin_permissions`
--

DROP TABLE IF EXISTS `admin_permissions`;
CREATE TABLE `admin_permissions`
(
    `id`          int UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name`        varchar(50) NOT NULL COMMENT '权限名称',
    `slug`        varchar(50) NOT NULL COMMENT '权限标识',
    `http_method` varchar(191) DEFAULT NULL COMMENT 'http请求方法',
    `http_path`   text COMMENT 'http请求路由',
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 后台用户、角色关系表 `admin_role_users`
--

DROP TABLE IF EXISTS `admin_role_users`;
CREATE TABLE `admin_role_users`
(
    `id`         int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `role_id`    int NOT NULL DEFAULT '0' COMMENT '角色id',
    `user_id`    int NOT NULL DEFAULT '0' COMMENT '用户id',
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 后台角色、权限关系表 `admin_role_permissions`
--
DROP TABLE IF EXISTS `admin_role_permissions`;
CREATE TABLE `admin_role_permissions`
(
    `id`            int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `role_id`       int NOT NULL DEFAULT '0' COMMENT '角色id',
    `permission_id` int NOT NULL DEFAULT '0' COMMENT '权限id',
    `created_at`    timestamp NULL DEFAULT NULL,
    `updated_at`    timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 后台角色、菜单关系表 `admin_role_menu`
--
DROP TABLE IF EXISTS `admin_role_menu`;
CREATE TABLE `admin_role_menu`
(
    `id`         int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `role_id`    int NOT NULL DEFAULT '0' COMMENT '角色id',
    `menu_id`    int NOT NULL DEFAULT '0' COMMENT '菜单id',
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
