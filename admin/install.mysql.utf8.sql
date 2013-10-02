SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
--
-- Table structure for table `jos_orders_fields`
--

CREATE TABLE `jos_orders_fields` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `orders_form_id` int(11) NOT NULL,
  `order` int(11) NOT NULL,
  `label_after` tinyint(1) NOT NULL default '0',
  `display_only` tinyint(1) NOT NULL default '0',
  `validator` varchar(200) collate utf8_unicode_ci NOT NULL,
  `validate_err` varchar(200) collate utf8_unicode_ci NOT NULL,
  `is_mandatory` tinyint(1) NOT NULL default '0',
  `style` varchar(200) collate utf8_unicode_ci NOT NULL,
  `type` enum('static','text','checkbox','textarea','dropdown-list') collate utf8_unicode_ci NOT NULL default 'text',
  `name` varchar(100) collate utf8_unicode_ci NOT NULL,
  `default_value` text collate utf8_unicode_ci NOT NULL,
  `class` varchar(100) collate utf8_unicode_ci NOT NULL,
  `label` text collate utf8_unicode_ci NOT NULL,
  `help_text` text collate utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=0 ;


-- --------------------------------------------------------

--
-- Table structure for table `jos_orders_forms`
--

CREATE TABLE `jos_orders_forms` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `title` varchar(200) collate utf8_unicode_ci NOT NULL,
  `fields_included` varchar(500) collate utf8_unicode_ci NOT NULL COMMENT 'Fields included in email. Comma separated fieldnames',
  `recipient` varchar(100) collate utf8_unicode_ci NOT NULL,
  `recipient_subject` varchar(200) collate utf8_unicode_ci NOT NULL,
  `recipient_template` text collate utf8_unicode_ci NOT NULL,
  `sender_field_name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `sender_subject` varchar(200) collate utf8_unicode_ci NOT NULL,
  `sender_template` text collate utf8_unicode_ci NOT NULL,
  `send_copy` tinyint(1) NOT NULL default '1',
  `thankyou_text` text collate utf8_unicode_ci NOT NULL,
  `gss_form_send` tinyint(1) NOT NULL default '1',
  `gss_form_key` varchar(100) collate utf8_unicode_ci NOT NULL,
  `gss_id` varchar(100) collate utf8_unicode_ci NOT NULL,
  `gss_sheet_id` varchar(10) collate utf8_unicode_ci NOT NULL,
  `surround_fields` varchar(300) collate utf8_unicode_ci NOT NULL,
  `products_after` varchar(100) collate utf8_unicode_ci NOT NULL,
  `products_fields_class` varchar(100) collate utf8_unicode_ci NOT NULL,
  `products_fields_style` varchar(200) collate utf8_unicode_ci NOT NULL,
  `products_mail_template` text collate utf8_unicode_ci NOT NULL,
  `use_captcha` tinyint(1) NOT NULL default '0',
  `gss_form_version` tinyint(2) NOT NULL default '1',
  `captcha_type` enum('reCaptcha','simple') collate utf8_unicode_ci NOT NULL default 'reCaptcha',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=0 ;

--
-- Dumping data for table `jos_orders_forms`
--

INSERT INTO `jos_orders_forms` VALUES(1, 'Order for April', '', 'email@example.com, info@email.com', 'Order from {firstname}', 'Order received\r\n		\r\nFirstname ....: {firstname}\r\nLastname .....: {lastname}   \r\nAddress         {address}\r\nContact person  {contact_person}\r\nPhone #         {phone}\r\nOrganisation    {organization}\r\n\r\n----------------------------------\r\nDelivery notes:\r\n{delivery_notes}\r\n\r\n----------------------------------\r\nProducts ordered: \r\n		\r\n{products}\r\n\r\nThank you.', 'email', 'Order copy for {firstname}', 'Hello Mr/Ms {lastname}\r\n\r\nThank you for ordering produce from http://naturevalley.md\r\nWe will process your order shortly.\r\nPlease contact us with any questions or concerns, your satisfaction and continued support is our ultimate reward.\r\n\r\nList of products and quantities:\r\n\r\n{products}\r\n\r\n--\r\nWe will contact {contact_person} with any questions about your order.\r\n	\r\nThank you', 1, 'Thank you for ordering your produce from Us.\r\nWe will contact you shortly to verify your order.\r\n\r\nThank you for your support!', 1, 'dHZjejFsR1dqcEt2MXBZX29kdHdyQ2c6MQ', '0Ai-YMPkK8THcdG1QcF9JX0RLaXlHM1ljTkRRUzdCRHc', '1', '<div class="row">|</div>', 'select_products', 'inputbox', '', '* {title} ({price}{currency}) .......... {count}', 1, 1, 'simple');

-- --------------------------------------------------------

--
-- Table structure for table `jos_orders_inbox`
--

CREATE TABLE `jos_orders_inbox` (
  `id` int(11) NOT NULL auto_increment,
  `recipient_email` text collate utf8_unicode_ci NOT NULL,
  `sender_email` text collate utf8_unicode_ci NOT NULL,
  `fields` text collate utf8_unicode_ci NOT NULL,
  `products` text collate utf8_unicode_ci NOT NULL,
  `date_created` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Holds a copy of placed orders' AUTO_INCREMENT=0 ;

--
-- Dumping data for table `jos_orders_inbox`
--


-- --------------------------------------------------------

--
-- Table structure for table `jos_orders_products`
--

CREATE TABLE `jos_orders_products` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `orders_form_id` int(10) unsigned NOT NULL,
  `order` int(10) unsigned NOT NULL,
  `type` enum('quantity','yes_no') collate utf8_unicode_ci NOT NULL default 'quantity',
  `title` varchar(200) collate utf8_unicode_ci NOT NULL,
  `description` text collate utf8_unicode_ci NOT NULL,
  `picture` varchar(200) collate utf8_unicode_ci NOT NULL,
  `price` float NOT NULL,
  `currency` varchar(4) collate utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=0 ;

--
-- Dumping data for table `jos_orders_products`
--

