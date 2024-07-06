create table m_address
(
    id        int unsigned auto_increment
        primary key,
    realname  varchar(10)       not null,
    phone     varchar(11)       not null,
    address   varchar(100)      not null,
    `default` tinyint default 0 not null,
    user_id   int unsigned      not null
);

create index fk_m_address_m_user_idx
    on m_address (user_id);

create table m_goods
(
    id          int unsigned auto_increment
        primary key,
    title       varchar(40)            not null comment '商品名称',
    thumb       varchar(255)           not null comment '商品缩略图',
    description varchar(100)           null comment '商品简介',
    price       decimal(6, 2) unsigned not null comment '价格',
    stock       int                    not null comment '库存',
    status      tinyint unsigned       not null comment '状态',
    images      json                   null comment '内容图片',
    content     text                   null comment '商品详情',
    tags        json                   null comment '商品标签',
    created_at  int                    not null,
    updated_at  int                    not null
);

create table m_order
(
    order_id   bigint unsigned auto_increment
        primary key,
    title      varchar(40)   not null comment '订单名称',
    price      decimal(6, 2) not null comment '订单价格',
    status     tinyint       not null comment '订单状态',
    realname   varchar(10)   not null comment '收货人名称',
    phone      varchar(11)   not null comment '收货人手机',
    address    varchar(100)  not null comment '收货人地址',
    remark     varchar(100)  null comment '备注',
    snapshot   json          not null comment '商品快照',
    created_at int           not null,
    pay_at     int default 0 not null,
    goods_id   int unsigned  not null,
    user_id    int unsigned  not null
);

create index fk_m_order_m_goods1_idx
    on m_order (goods_id);

create index fk_m_order_m_user1_idx
    on m_order (user_id);

create table m_user
(
    id         int unsigned auto_increment
        primary key,
    nickname   varchar(40)  null comment '昵称',
    avatar     varchar(255) null comment '头像',
    openid     varchar(40)  not null,
    created_at int          not null,
    created_ip varchar(15)  not null,
    constraint openid_UNIQUE
        unique (openid)
);

