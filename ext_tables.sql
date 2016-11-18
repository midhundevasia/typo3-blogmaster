#
# Table structure for table 'tx_blogmaster_domain_model_blog'
#
CREATE TABLE tx_blogmaster_domain_model_blog (
  uid bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  pid bigint(20) DEFAULT '0' NOT NULL,

  title varchar(255) DEFAULT '' NOT NULL,
  description text NOT NULL,

  tstamp int(11) unsigned DEFAULT '0' NOT NULL,
  crdate int(11) unsigned DEFAULT '0' NOT NULL,
  deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
  hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
  fe_group varchar(100) DEFAULT '0' NOT NULL,

  t3ver_oid int(11) DEFAULT '0' NOT NULL,
  t3ver_id int(11) DEFAULT '0' NOT NULL,
  t3ver_wsid int(11) DEFAULT '0' NOT NULL,
  t3ver_label varchar(30) DEFAULT '' NOT NULL,
  t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
  t3ver_stage tinyint(4) DEFAULT '0' NOT NULL,
  t3ver_count int(11) DEFAULT '0' NOT NULL,
  t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
  t3ver_move_id int(11) DEFAULT '0' NOT NULL,
  t3_origuid int(11) DEFAULT '0' NOT NULL,

  sys_language_uid int(11) DEFAULT '0' NOT NULL,
  l18n_parent int(11) DEFAULT '0' NOT NULL,
  l18n_diffsource mediumblob NOT NULL,

  PRIMARY KEY (uid),
  KEY parent (pid),
  KEY t3ver_oid (t3ver_oid,t3ver_wsid)
);

#
# Table structure for table 'tx_blogmaster_domain_model_post'
#
CREATE TABLE tx_blogmaster_domain_model_post (
  uid bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  pid bigint(20) DEFAULT '0' NOT NULL,

  blog int(11) DEFAULT '0' NOT NULL,

  title text COLLATE utf8mb4_unicode_ci NOT NULL,
  content longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  slug varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  excerpt text COLLATE utf8mb4_unicode_ci NOT NULL,
  status varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'publish',
  comment_status varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  modified datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  modified_gmt datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  parent bigint(20) unsigned NOT NULL DEFAULT '0',
  comment_count bigint(20) NOT NULL DEFAULT '0',
  cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
  created datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  created_gmt datetime NOT NULL DEFAULT '0000-00-00 00:00:00',

  categories int(11) unsigned DEFAULT '0' NOT NULL,
  tags int(11) unsigned DEFAULT '0' NOT NULL,
  image int(11) DEFAULT '0' NOT NULL,

  tstamp int(11) unsigned DEFAULT '0' NOT NULL,
  crdate int(11) unsigned DEFAULT '0' NOT NULL,
  deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
  hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
  sorting tinyint(4) unsigned DEFAULT '0' NOT NULL,

  t3ver_oid int(11) DEFAULT '0' NOT NULL,
  t3ver_id int(11) DEFAULT '0' NOT NULL,
  t3ver_wsid int(11) DEFAULT '0' NOT NULL,
  t3ver_label varchar(30) DEFAULT '' NOT NULL,
  t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
  t3ver_stage tinyint(4) DEFAULT '0' NOT NULL,
  t3ver_count int(11) DEFAULT '0' NOT NULL,
  t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
  t3ver_move_id int(11) DEFAULT '0' NOT NULL,
  t3_origuid int(11) DEFAULT '0' NOT NULL,

  sys_language_uid int(11) DEFAULT '0' NOT NULL,
  l18n_parent int(11) DEFAULT '0' NOT NULL,
  l18n_diffsource mediumblob NOT NULL,

  PRIMARY KEY (uid),
  KEY slug (slug(191)),
  KEY status_date (status,created,uid),
  KEY parent (parent),
  KEY author (cruser_id)
);

#
# Table structure for table 'tx_blogmaster_domain_model_category'
#
CREATE TABLE tx_blogmaster_domain_model_category (
  uid bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  pid bigint(20) DEFAULT '0' NOT NULL,

  blog int(11) DEFAULT '0' NOT NULL,

  title varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  description longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  slug varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  parent bigint(20) unsigned NOT NULL DEFAULT '0',
  posts int(11) unsigned DEFAULT '0' NOT NULL,
  
  cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
  tstamp int(11) unsigned DEFAULT '0' NOT NULL,
  crdate int(11) unsigned DEFAULT '0' NOT NULL,
  deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
  hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
  sorting tinyint(4) unsigned DEFAULT '0' NOT NULL,

  sys_language_uid int(11) DEFAULT '0' NOT NULL,
  l18n_parent int(11) DEFAULT '0' NOT NULL,
  l18n_diffsource mediumblob NOT NULL,

  PRIMARY KEY (uid),
  KEY slug (slug(191)),
  KEY cdate (crdate,uid),
  KEY parent (parent)
);

#
# Table structure for table 'tx_blogmaster_domain_model_tag'
#
CREATE TABLE tx_blogmaster_domain_model_tag (
  uid bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  pid bigint(20) DEFAULT '0' NOT NULL,

  blog int(11) DEFAULT '0' NOT NULL,

  title varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  description longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  slug varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  posts bigint(20) NOT NULL DEFAULT '0',
  
  cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
  tstamp int(11) unsigned DEFAULT '0' NOT NULL,
  crdate int(11) unsigned DEFAULT '0' NOT NULL,
  deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
  hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
  sorting tinyint(4) unsigned DEFAULT '0' NOT NULL,

  sys_language_uid int(11) DEFAULT '0' NOT NULL,
  l18n_parent int(11) DEFAULT '0' NOT NULL,
  l18n_diffsource mediumblob NOT NULL,

  PRIMARY KEY (uid),
  KEY slug (slug(191)),
  KEY cdate (crdate,uid)
);

#
# Table structure for table 'tx_blogmaster_domain_model_comment'
#
CREATE TABLE tx_blogmaster_domain_model_comment (
  uid bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  pid bigint(20) DEFAULT '0' NOT NULL,

  blog int(11) DEFAULT '0' NOT NULL,
  post int(11) DEFAULT '0' NOT NULL,

  author_name tinytext COLLATE utf8mb4_unicode_ci NOT NULL,
  author_email varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  author_url varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  author_Ip varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  created datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  created_gmt datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  content text COLLATE utf8mb4_unicode_ci NOT NULL,
  status varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  agent varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  type varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'comment',
  parent bigint(20) unsigned NOT NULL DEFAULT '0',
  
  user_id bigint(20) unsigned NOT NULL DEFAULT '0',
  
  cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
  tstamp int(11) unsigned DEFAULT '0' NOT NULL,
  crdate int(11) unsigned DEFAULT '0' NOT NULL,
  deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
  hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
  sorting tinyint(4) unsigned DEFAULT '0' NOT NULL,

  PRIMARY KEY (uid),
  KEY post (post),
  KEY status_date_gmt (status,created_gmt),
  KEY date_gmt (created_gmt),
  KEY parent (parent),
  KEY author_email (author_email(10))
);

#
# Table structure for table 'tx_blogmaster_post_category_mm'
#
CREATE TABLE tx_blogmaster_post_category_mm (
    uid_local int(11) unsigned DEFAULT '0' NOT NULL,
    uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
    sorting int(11) unsigned DEFAULT '0' NOT NULL,
    sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,
 
    KEY uid_local (uid_local),
    KEY uid_foreign (uid_foreign)
);

#
# Table structure for table 'tx_blogmaster_post_category_mm'
#
CREATE TABLE tx_blogmaster_post_tag_mm (
    uid_local int(11) unsigned DEFAULT '0' NOT NULL,
    uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
    sorting int(11) unsigned DEFAULT '0' NOT NULL,
    sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,
 
    KEY uid_local (uid_local),
    KEY uid_foreign (uid_foreign)
);
