-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 03, 2019 at 07:55 AM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `igniteradmin`
--

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `company_name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `address` text COLLATE utf8_unicode_ci,
  `city` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `state` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `zip` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_date` date NOT NULL,
  `website` text COLLATE utf8_unicode_ci,
  `phone` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `currency_symbol` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `starred_by` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `group_ids` text COLLATE utf8_unicode_ci NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `vat_number` text COLLATE utf8_unicode_ci,
  `currency` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `disable_online_payment` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `company_name`, `address`, `city`, `state`, `zip`, `country`, `created_date`, `website`, `phone`, `currency_symbol`, `starred_by`, `group_ids`, `deleted`, `vat_number`, `currency`, `disable_online_payment`) VALUES
(1, 'Test Company', NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL, NULL, NULL, '', '', 0, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customers_id` int(121) NOT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customers_id`, `user_id`, `name`) VALUES
(1, '1', 'Lokesh Sharma');

-- --------------------------------------------------------

--
-- Table structure for table `ia_custom_fields`
--

CREATE TABLE `ia_custom_fields` (
  `ia_custom_fields_id` int(11) UNSIGNED NOT NULL,
  `rel_crud` varchar(250) DEFAULT NULL,
  `name` varchar(250) DEFAULT NULL,
  `type` varchar(250) DEFAULT NULL,
  `required` int(11) DEFAULT NULL,
  `options` varchar(250) DEFAULT NULL,
  `status` varchar(250) DEFAULT NULL,
  `show_in_grid` int(11) DEFAULT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ia_custom_fields_values`
--

CREATE TABLE `ia_custom_fields_values` (
  `ia_custom_fields_values_id` int(11) UNSIGNED NOT NULL,
  `rel_crud_id` int(11) DEFAULT NULL,
  `cf_id` int(11) DEFAULT NULL,
  `curd` varchar(250) DEFAULT NULL,
  `value` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ia_demo_plugin`
--

CREATE TABLE `ia_demo_plugin` (
  `id` int(11) NOT NULL,
  `description` longtext,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ia_document_maker`
--

CREATE TABLE `ia_document_maker` (
  `document_maker_id` int(121) NOT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `document_maker_titlea` varchar(255) DEFAULT NULL,
  `document_maker_description` text,
  `document_maker_status` varchar(255) DEFAULT NULL,
  `document_maker_public` varchar(255) DEFAULT NULL,
  `document_maker_enable_attachment` varchar(255) DEFAULT NULL,
  `document_template` longtext,
  `document_data` longtext,
  `user_email` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ia_document_makerfield_type`
--

CREATE TABLE `ia_document_makerfield_type` (
  `field_type_id` int(121) NOT NULL,
  `formBuider_id` varchar(225) DEFAULT NULL,
  `user_id` varchar(225) DEFAULT NULL,
  `title` varchar(225) DEFAULT NULL,
  `placeholder` varchar(225) DEFAULT NULL,
  `field_type` varchar(225) DEFAULT NULL,
  `options` varchar(225) DEFAULT NULL,
  `required` varchar(225) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ia_document_settings`
--

CREATE TABLE `ia_document_settings` (
  `id` int(11) NOT NULL,
  `key` varchar(250) DEFAULT NULL,
  `value` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ia_document_settings`
--

INSERT INTO `ia_document_settings` (`id`, `key`, `value`) VALUES
(2, 'email_to_receive_document', 'manoj@dispostable.com');

-- --------------------------------------------------------

--
-- Table structure for table `ia_email_templates`
--

CREATE TABLE `ia_email_templates` (
  `id` int(121) UNSIGNED NOT NULL,
  `module` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `template_name` varchar(255) DEFAULT NULL,
  `html` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ia_email_templates`
--

INSERT INTO `ia_email_templates` (`id`, `module`, `code`, `template_name`, `html`) VALUES
(1, 'forgot_pass', 'forgot_password', 'Forgot password', '<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\"><meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">\r\n<style media=\"all\" rel=\"stylesheet\" type=\"text/css\">/* Base ------------------------------ */\r\n    *:not(br):not(tr):not(html) {\r\n      font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif;\r\n      -webkit-box-sizing: border-box;\r\n      box-sizing: border-box;\r\n    }\r\n    body {\r\n      \r\n    }\r\n    a {\r\n      color: #3869D4;\r\n    }\r\n\r\n\r\n    /* Masthead ----------------------- */\r\n    .email-masthead {\r\n      padding: 25px 0;\r\n      text-align: center;\r\n    }\r\n    .email-masthead_logo {\r\n      max-width: 400px;\r\n      border: 0;\r\n    }\r\n    .email-footer {\r\n      width: 570px;\r\n      margin: 0 auto;\r\n      padding: 0;\r\n      text-align: center;\r\n    }\r\n    .email-footer p {\r\n      color: #AEAEAE;\r\n    }\r\n  \r\n    .content-cell {\r\n      padding: 35px;\r\n    }\r\n    .align-right {\r\n      text-align: right;\r\n    }\r\n\r\n    /* Type ------------------------------ */\r\n    h1 {\r\n      margin-top: 0;\r\n      color: #2F3133;\r\n      font-size: 19px;\r\n      font-weight: bold;\r\n      text-align: left;\r\n    }\r\n    h2 {\r\n      margin-top: 0;\r\n      color: #2F3133;\r\n      font-size: 16px;\r\n      font-weight: bold;\r\n      text-align: left;\r\n    }\r\n    h3 {\r\n      margin-top: 0;\r\n      color: #2F3133;\r\n      font-size: 14px;\r\n      font-weight: bold;\r\n      text-align: left;\r\n    }\r\n    p {\r\n      margin-top: 0;\r\n      color: #74787E;\r\n      font-size: 16px;\r\n      line-height: 1.5em;\r\n      text-align: left;\r\n    }\r\n    p.sub {\r\n      font-size: 12px;\r\n    }\r\n    p.center {\r\n      text-align: center;\r\n    }\r\n\r\n    /* Buttons ------------------------------ */\r\n    .button {\r\n      display: inline-block;\r\n      width: 200px;\r\n      background-color: #3869D4;\r\n      border-radius: 3px;\r\n      color: #ffffff;\r\n      font-size: 15px;\r\n      line-height: 45px;\r\n      text-align: center;\r\n      text-decoration: none;\r\n      -webkit-text-size-adjust: none;\r\n      mso-hide: all;\r\n    }\r\n    .button--green {\r\n      background-color: #22BC66;\r\n    }\r\n    .button--red {\r\n      background-color: #dc4d2f;\r\n    }\r\n    .button--blue {\r\n      background-color: #3869D4;\r\n    }\r\n</style>\r\n<table cellpadding=\"0\" cellspacing=\"0\" class=\"email-wrapper\" style=\"\r\n    width: 100%;\r\n    margin: 0;\r\n    padding: 0;\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td align=\"center\">\r\n			<table cellpadding=\"0\" cellspacing=\"0\" class=\"email-content\" style=\"width: 100%;\r\n      margin: 0;\r\n      padding: 0;\" width=\"100%\"><!-- Logo -->\r\n				<tbody><!-- Email Body -->\r\n					<tr>\r\n						<td class=\"email-body\" style=\"width: 100%;\r\n    margin: 0;\r\n    padding: 0;\r\n    border-top: 1px solid #edeef2;\r\n    border-bottom: 1px solid #edeef2;\r\n    background-color: #edeef2;\" width=\"100%\">\r\n						<table align=\"center\" cellpadding=\"0\" cellspacing=\"0\" class=\"email-body_inner\" style=\" width: 570px;\r\n    margin:  14px auto;\r\n    background: #fff;\r\n    padding: 0;\r\n    border: 1px outset rgba(136, 131, 131, 0.26);\r\n    box-shadow: 0px 6px 38px rgb(0, 0, 0);\r\n       \" width=\"570\"><!-- Body content -->\r\n							<thead style=\"background: #3869d4;\">\r\n								<tr>\r\n									<th>\r\n									<div align=\"center\" style=\"padding: 15px; color: #000;\"><a class=\"email-masthead_name\" href=\"{var_action_url}\" style=\"font-size: 16px;\r\n      font-weight: bold;\r\n      color: #bbbfc3;\r\n      text-decoration: none;\r\n      text-shadow: 0 1px 0 white;\">{var_sender_name}</a></div>\r\n									</th>\r\n								</tr>\r\n							</thead>\r\n							<tbody>\r\n								<tr>\r\n									<td class=\"content-cell\" style=\"padding: 35px;\">\r\n									<h1>Hi {var_user_name},</h1>\r\n\r\n									<p>You recently requested to reset your password for your {var_website_name} account. Click the button below to reset it.</p>\r\n									<!-- Action -->\r\n\r\n									<table align=\"center\" cellpadding=\"0\" cellspacing=\"0\" class=\"body-action\" style=\"\r\n      width: 100%;\r\n      margin: 30px auto;\r\n      padding: 0;\r\n      text-align: center;\" width=\"100%\">\r\n										<tbody>\r\n											<tr>\r\n												<td align=\"center\">\r\n												<div><!--[if mso]><v:roundrect xmlns:v=\"urn:schemas-microsoft-com:vml\" xmlns:w=\"urn:schemas-microsoft-com:office:word\" href=\"{{var_action_url}}\" style=\"height:45px;v-text-anchor:middle;width:200px;\" arcsize=\"7%\" stroke=\"f\" fill=\"t\">\r\n                              <v:fill type=\"tile\" color=\"#dc4d2f\" ></v:fill>\r\n                              <w:anchorlock></w:anchorlock>\r\n                              <center style=\"color:#ffffff;font-family:sans-serif;font-size:15px;\">Reset your password</center>\r\n                            </v:roundrect><![endif]--><a class=\"button button--red\" href=\"{var_varification_link}\" style=\"background-color: #dc4d2f;display: inline-block;\r\n      width: 200px;\r\n      background-color: #3869D4;\r\n      border-radius: 3px;\r\n      color: #ffffff;\r\n      font-size: 15px;\r\n      line-height: 45px;\r\n      text-align: center;\r\n      text-decoration: none;\r\n      -webkit-text-size-adjust: none;\r\n      mso-hide: all;\">Reset your password</a></div>\r\n												</td>\r\n											</tr>\r\n										</tbody>\r\n									</table>\r\n\r\n									<p>If you did not request a password reset, please ignore this email or reply to let us know.</p>\r\n\r\n									<p>Thanks,<br />\r\n									{var_sender_name} and the {var_website_name} Team</p>\r\n									<!-- Sub copy -->\r\n\r\n									<table class=\"body-sub\" style=\"margin-top: 25px;\r\n      padding-top: 25px;\r\n      border-top: 1px solid #EDEFF2;\">\r\n										<tbody>\r\n											<tr>\r\n												<td>\r\n												<p class=\"sub\" style=\"font-size:12px;\">If you are having trouble clicking the password reset button, copy and paste the URL below into your web browser.</p>\r\n\r\n												<p class=\"sub\" style=\"font-size:12px;\"><a href=\"{var_varification_link}\">{var_varification_link}</a></p>\r\n												</td>\r\n											</tr>\r\n										</tbody>\r\n									</table>\r\n									</td>\r\n								</tr>\r\n							</tbody>\r\n						</table>\r\n						</td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n'),
(2, 'users', 'invitation', 'Invitation', '<p>Hello <strong>{var_user_email}</strong></p>\r\n\r\n<p>Click below link to register&nbsp;<br />\r\n{var_inviation_link}</p>\r\n\r\n<p>Thanks&nbsp;</p>\r\n'),
(3, 'registration', 'registration', 'Registration', '<p>Hello <strong>{var_user_name}</strong></p>\r\n\r\n<p>Welcome to Notes&nbsp;</p>\r\n\r\n<p>To complete your registration&nbsp;<br />\r\n<br />\r\n<a href=\"{var_varification_link}\">please click here</a></p>\r\n\r\n<p>Thanks&nbsp;</p>\r\n'),
(7, 'Undead Post Notification', 'undead_post_notification', 'Undead Post Notification', '<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\"><meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">\n<style media=\"all\" rel=\"stylesheet\" type=\"text/css\">/* Base ------------------------------ */\n    *:not(br):not(tr):not(html) {\n      font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif;\n      -webkit-box-sizing: border-box;\n      box-sizing: border-box;\n    }\n    body {\n      \n    }\n    a {\n      color: #3869D4;\n    }\n\n\n    /* Masthead ----------------------- */\n    .email-masthead {\n      padding: 25px 0;\n      text-align: center;\n    }\n    .email-masthead_logo {\n      max-width: 400px;\n      border: 0;\n    }\n    .email-footer {\n      width: 570px;\n      margin: 0 auto;\n      padding: 0;\n      text-align: center;\n    }\n    .email-footer p {\n      color: #AEAEAE;\n    }\n  \n    .content-cell {\n      padding: 35px;\n    }\n    .align-right {\n      text-align: right;\n    }\n\n    /* Type ------------------------------ */\n    h1 {\n      margin-top: 0;\n      color: #2F3133;\n      font-size: 19px;\n      font-weight: bold;\n      text-align: left;\n    }\n    h2 {\n      margin-top: 0;\n      color: #2F3133;\n      font-size: 16px;\n      font-weight: bold;\n      text-align: left;\n    }\n    h3 {\n      margin-top: 0;\n      color: #2F3133;\n      font-size: 14px;\n      font-weight: bold;\n      text-align: left;\n    }\n    p {\n      margin-top: 0;\n      color: #74787E;\n      font-size: 16px;\n      line-height: 1.5em;\n      text-align: left;\n    }\n    p.sub {\n      font-size: 12px;\n    }\n    p.center {\n      text-align: center;\n    }\n\n    /* Buttons ------------------------------ */\n    .button {\n      display: inline-block;\n      width: 200px;\n      background-color: #3869D4;\n      border-radius: 3px;\n      color: #ffffff;\n      font-size: 15px;\n      line-height: 45px;\n      text-align: center;\n      text-decoration: none;\n      -webkit-text-size-adjust: none;\n      mso-hide: all;\n    }\n    .button--green {\n      background-color: #22BC66;\n    }\n    .button--red {\n      background-color: #dc4d2f;\n    }\n    .button--blue {\n      background-color: #3869D4;\n    }\n</style>\n<table cellpadding=\"0\" cellspacing=\"0\" class=\"email-wrapper\" style=\"\n    width: 100%;\n    margin: 0;\n    padding: 0;\" width=\"100%\">\n <tbody>\n   <tr>\n      <td align=\"center\">\n     <table cellpadding=\"0\" cellspacing=\"0\" class=\"email-content\" style=\"width: 100%;\n      margin: 0;\n      padding: 0;\" width=\"100%\"><!-- Logo -->\n       <tbody><!-- Email Body -->\n          <tr>\n            <td class=\"email-body\" style=\"width: 100%;\n    margin: 0;\n    padding: 0;\n    border-top: 1px solid #edeef2;\n    border-bottom: 1px solid #edeef2;\n    background-color: #edeef2;\" width=\"100%\">\n           <table align=\"center\" cellpadding=\"0\" cellspacing=\"0\" class=\"email-body_inner\" style=\" width: 570px;\n    margin:  14px auto;\n    background: #fff;\n    padding: 0;\n    border: 1px outset rgba(136, 131, 131, 0.26);\n    box-shadow: 0px 6px 38px rgb(0, 0, 0);\n       \" width=\"570\"><!-- Body content -->\n              <thead style=\"background: #3869d4;\">\n                <tr>\n                  <th>\n                  <div align=\"center\" style=\"padding: 15px; color: #000;\"><a class=\"email-masthead_name\" href=\"{var_action_url}\" style=\"font-size: 16px;\n      font-weight: bold;\n      color: #bbbfc3;\n      text-decoration: none;\n      text-shadow: 0 1px 0 white;\">{var_sender_name}</a></div>\n                 </th>\n               </tr>\n             </thead>\n              <tbody>\n               <tr>\n                  <td class=\"content-cell\" style=\"padding: 35px;\">\n                  <h1>Hi {var_user_name},</h1>\n\n                  <p>Message: you have {var_unread_noti} unread posts.</p>\n\n                  <p>&nbsp;</p>\n                 <!-- Action -->\n\n                 <p><br />\n                 Thanks,</p>\n\n                 <p>Expence Manager&nbsp;Team</p>\n                  </td>\n               </tr>\n             </tbody>\n            </table>\n            </td>\n         </tr>\n       </tbody>\n      </table>\n      </td>\n   </tr>\n </tbody>\n</table>\n'),
(14, 'Document maker', 'document_maker', 'Document maker', '<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\"><meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">\r\n<style media=\"all\" rel=\"stylesheet\" type=\"text/css\">/* Base ------------------------------ */\r\n    *:not(br):not(tr):not(html) {\r\n      font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif;\r\n      -webkit-box-sizing: border-box;\r\n      box-sizing: border-box;\r\n    }\r\n    body {\r\n      \r\n    }\r\n    a {\r\n      color: #3869D4;\r\n    }\r\n\r\n\r\n    /* Masthead ----------------------- */\r\n    .email-masthead {\r\n      padding: 25px 0;\r\n      text-align: center;\r\n    }\r\n    .email-masthead_logo {\r\n      max-width: 400px;\r\n      border: 0;\r\n    }\r\n    .email-footer {\r\n      width: 570px;\r\n      margin: 0 auto;\r\n      padding: 0;\r\n      text-align: center;\r\n    }\r\n    .email-footer p {\r\n      color: #AEAEAE;\r\n    }\r\n  \r\n    .content-cell {\r\n      padding: 35px;\r\n    }\r\n    .align-right {\r\n      text-align: right;\r\n    }\r\n\r\n    /* Type ------------------------------ */\r\n    h1 {\r\n      margin-top: 0;\r\n      color: #2F3133;\r\n      font-size: 19px;\r\n      font-weight: bold;\r\n      text-align: left;\r\n    }\r\n    h2 {\r\n      margin-top: 0;\r\n      color: #2F3133;\r\n      font-size: 16px;\r\n      font-weight: bold;\r\n      text-align: left;\r\n    }\r\n    h3 {\r\n      margin-top: 0;\r\n      color: #2F3133;\r\n      font-size: 14px;\r\n      font-weight: bold;\r\n      text-align: left;\r\n    }\r\n    p {\r\n      margin-top: 0;\r\n      color: #74787E;\r\n      font-size: 16px;\r\n      line-height: 1.5em;\r\n      text-align: left;\r\n    }\r\n    p.sub {\r\n      font-size: 12px;\r\n    }\r\n    p.center {\r\n      text-align: center;\r\n    }\r\n\r\n    /* Buttons ------------------------------ */\r\n    .button {\r\n      display: inline-block;\r\n      width: 200px;\r\n      background-color: #3869D4;\r\n      border-radius: 3px;\r\n      color: #ffffff;\r\n      font-size: 15px;\r\n      line-height: 45px;\r\n      text-align: center;\r\n      text-decoration: none;\r\n      -webkit-text-size-adjust: none;\r\n      mso-hide: all;\r\n    }\r\n    .button--green {\r\n      background-color: #22BC66;\r\n    }\r\n    .button--red {\r\n      background-color: #dc4d2f;\r\n    }\r\n    .button--blue {\r\n      background-color: #3869D4;\r\n    }\r\n</style>\r\n<table cellpadding=\"0\" cellspacing=\"0\" class=\"email-wrapper\" style=\"\r\n    width: 100%;\r\n    margin: 0;\r\n    padding: 0;\" width=\"100%\">\r\n  <tbody>\r\n   <tr>\r\n      <td align=\"center\">\r\n     <table cellpadding=\"0\" cellspacing=\"0\" class=\"email-content\" style=\"width: 100%;\r\n      margin: 0;\r\n      padding: 0;\" width=\"100%\"><!-- Logo -->\r\n       <tbody><!-- Email Body -->\r\n          <tr>\r\n            <td class=\"email-body\" style=\"width: 100%;\r\n    margin: 0;\r\n    padding: 0;\r\n    border-top: 1px solid #edeef2;\r\n    border-bottom: 1px solid #edeef2;\r\n    background-color: #edeef2;\" width=\"100%\">\r\n           <table align=\"center\" cellpadding=\"0\" cellspacing=\"0\" class=\"email-body_inner\" style=\" width: 570px;\r\n    margin:  14px auto;\r\n    background: #fff;\r\n    padding: 0;\r\n    border: 1px outset rgba(136, 131, 131, 0.26);\r\n    box-shadow: 0px 6px 38px rgb(0, 0, 0);\r\n       \" width=\"570\"><!-- Body content -->\r\n              <thead style=\"background: #3869d4;\">\r\n                <tr>\r\n                  <th>\r\n                  <h2 align=\"center\" style=\"padding: 15px; color: rgb(0, 0, 0);\">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <code>&nbsp;<var>support-via-audit</var>​</code></h2>\r\n                  </th>\r\n               </tr>\r\n             </thead>\r\n              <tbody>\r\n               <tr>\r\n                  <td class=\"content-cell\" style=\"padding: 35px;\">\r\n                  <h1><font color=\"#333333\"><span style=\"font-size: 13px; font-weight: normal;\">Hi ,</span></font></h1>\r\n\r\n                 <p><font color=\"#333333\"><span style=\"font-size: 13px;\">PFA : This is a test message.</span></font></p>\r\n\r\n                 <p>&nbsp;</p>\r\n                 <!-- Action -->\r\n\r\n                 <p><br />\r\n                 <font color=\"#333333\"><span style=\"font-size: 13px;\">Thanks,</span></font></p>\r\n\r\n                  <p><font color=\"#333333\"><span style=\"font-size: 13px;\">Expence Manager&nbsp;Team</span></font></p>\r\n                 </td>\r\n               </tr>\r\n             </tbody>\r\n            </table>\r\n            </td>\r\n         </tr>\r\n       </tbody>\r\n      </table>\r\n      </td>\r\n   </tr>\r\n </tbody>\r\n</table>\r\n'),
(15, 'comment', 'comment', 'comment', '<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\"><meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">\r\n<style media=\"all\" rel=\"stylesheet\" type=\"text/css\">/* Base ------------------------------ */\r\n    *:not(br):not(tr):not(html) {\r\n      font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif;\r\n      -webkit-box-sizing: border-box;\r\n      box-sizing: border-box;\r\n    }\r\n    body {\r\n      \r\n    }\r\n    a {\r\n      color: #3869D4;\r\n    }\r\n\r\n\r\n    /* Masthead ----------------------- */\r\n    .email-masthead {\r\n      padding: 25px 0;\r\n      text-align: center;\r\n    }\r\n    .email-masthead_logo {\r\n      max-width: 400px;\r\n      border: 0;\r\n    }\r\n    .email-footer {\r\n      width: 570px;\r\n      margin: 0 auto;\r\n      padding: 0;\r\n      text-align: center;\r\n    }\r\n    .email-footer p {\r\n      color: #AEAEAE;\r\n    }\r\n  \r\n    .content-cell {\r\n      padding: 35px;\r\n    }\r\n    .align-right {\r\n      text-align: right;\r\n    }\r\n\r\n    /* Type ------------------------------ */\r\n    h1 {\r\n      margin-top: 0;\r\n      color: #2F3133;\r\n      font-size: 19px;\r\n      font-weight: bold;\r\n      text-align: left;\r\n    }\r\n    h2 {\r\n      margin-top: 0;\r\n      color: #2F3133;\r\n      font-size: 16px;\r\n      font-weight: bold;\r\n      text-align: left;\r\n    }\r\n    h3 {\r\n      margin-top: 0;\r\n      color: #2F3133;\r\n      font-size: 14px;\r\n      font-weight: bold;\r\n      text-align: left;\r\n    }\r\n    p {\r\n      margin-top: 0;\r\n      color: #74787E;\r\n      font-size: 16px;\r\n      line-height: 1.5em;\r\n      text-align: left;\r\n    }\r\n    p.sub {\r\n      font-size: 12px;\r\n    }\r\n    p.center {\r\n      text-align: center;\r\n    }\r\n\r\n    /* Buttons ------------------------------ */\r\n    .button {\r\n      display: inline-block;\r\n      width: 200px;\r\n      background-color: #3869D4;\r\n      border-radius: 3px;\r\n      color: #ffffff;\r\n      font-size: 15px;\r\n      line-height: 45px;\r\n      text-align: center;\r\n      text-decoration: none;\r\n      -webkit-text-size-adjust: none;\r\n      mso-hide: all;\r\n    }\r\n    .button--green {\r\n      background-color: #22BC66;\r\n    }\r\n    .button--red {\r\n      background-color: #dc4d2f;\r\n    }\r\n    .button--blue {\r\n      background-color: #3869D4;\r\n    }\r\n</style>\r\n<table cellpadding=\"0\" cellspacing=\"0\" class=\"email-wrapper\" style=\"\r\n    width: 100%;\r\n    margin: 0;\r\n    padding: 0;\" width=\"100%\">\r\n  <tbody>\r\n   <tr>\r\n      <td align=\"center\">\r\n     <table cellpadding=\"0\" cellspacing=\"0\" class=\"email-content\" style=\"width: 100%;\r\n      margin: 0;\r\n      padding: 0;\" width=\"100%\"><!-- Logo -->\r\n       <tbody><!-- Email Body -->\r\n          <tr>\r\n            <td class=\"email-body\" style=\"width: 100%;\r\n    margin: 0;\r\n    padding: 0;\r\n    border-top: 1px solid #edeef2;\r\n    border-bottom: 1px solid #edeef2;\r\n    background-color: #edeef2;\" width=\"100%\">\r\n           <table align=\"center\" cellpadding=\"0\" cellspacing=\"0\" class=\"email-body_inner\" style=\" width: 570px;\r\n    margin:  14px auto;\r\n    background: #fff;\r\n    padding: 0;\r\n    border: 1px outset rgba(136, 131, 131, 0.26);\r\n    box-shadow: 0px 6px 38px rgb(0, 0, 0);\r\n       \" width=\"570\"><!-- Body content -->\r\n              <thead style=\"background: #3869d4;\">\r\n                <tr>\r\n                  <th>\r\n                  <div align=\"center\" style=\"padding: 15px; color: #000;\"><a class=\"email-masthead_name\" href=\"{var_action_url}\" style=\"font-size: 16px;\r\n      font-weight: bold;\r\n      color: #bbbfc3;\r\n      text-decoration: none;\r\n      text-shadow: 0 1px 0 white;\">{var_sender_name}</a></div>\r\n                 </th>\r\n               </tr>\r\n             </thead>\r\n              <tbody>\r\n               <tr>\r\n                  <td class=\"content-cell\" style=\"padding: 35px;\">\r\n                  <h1>Hi {var_user_name},</h1>\r\n\r\n                  <p>Ticket Name: {var_ticket_name}</p>\r\n\r\n                 <p>Comments: {var_ticket_comment}</p>\r\n\r\n                 <p><span style=\"color: rgb(116, 120, 126); font-size: 16px;\">Pour r&eacute;pondre &agrave; cet email, merci de cliquer sur le lien suivant :</span></p>\r\n\r\n                 <p>&nbsp;</p>\r\n                 <!-- Action -->\r\n\r\n                 <table align=\"center\" cellpadding=\"0\" cellspacing=\"0\" class=\"body-action\" style=\"\r\n      width: 100%;\r\n      margin: 30px auto;\r\n      padding: 0;\r\n      text-align: center;\" width=\"100%\">\r\n                    <tbody>\r\n                     <tr>\r\n                        <td align=\"center\">\r\n                       <div><a href=\"{var_ticket_view_link}\" style=\"color: #000;\r\n      font-size: 15px;\r\n      text-align: center;\">Show Ticket</a>&nbsp;&nbsp;</div>\r\n                       </td>\r\n                     </tr>\r\n                   </tbody>\r\n                  </table>\r\n\r\n                  <p>&nbsp;</p>\r\n\r\n                 <p>Thanks,<br />\r\n                  Expence Manager&nbsp;Team</p>\r\n                 <!-- Sub copy -->\r\n\r\n                 <table class=\"body-sub\" style=\"margin-top: 25px;\r\n      padding-top: 25px;\r\n      border-top: 1px solid #EDEFF2;\">\r\n                    <tbody>\r\n                     <tr>\r\n                        <td>\r\n                        <p class=\"sub\" style=\"font-size:12px;\">If you are having trouble clicking the button, copy and paste the URL below into your web browser.</p>\r\n\r\n                       <p class=\"sub\" style=\"font-size:12px;\"><a href=\"{var_direct_link}\">{var_direct_link}</a></p>\r\n                        </td>\r\n                     </tr>\r\n                   </tbody>\r\n                  </table>\r\n                  </td>\r\n               </tr>\r\n             </tbody>\r\n            </table>\r\n            </td>\r\n         </tr>\r\n       </tbody>\r\n      </table>\r\n      </td>\r\n   </tr>\r\n </tbody>\r\n</table>\r\n'),
(16, 'Close ticket', 'close_ticket', 'Close ticket', '<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\"><meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">\r\n<style media=\"all\" rel=\"stylesheet\" type=\"text/css\">/* Base ------------------------------ */\r\n    *:not(br):not(tr):not(html) {\r\n      font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif;\r\n      -webkit-box-sizing: border-box;\r\n      box-sizing: border-box;\r\n    }\r\n    body {\r\n      \r\n    }\r\n    a {\r\n      color: #3869D4;\r\n    }\r\n\r\n\r\n    /* Masthead ----------------------- */\r\n    .email-masthead {\r\n      padding: 25px 0;\r\n      text-align: center;\r\n    }\r\n    .email-masthead_logo {\r\n      max-width: 400px;\r\n      border: 0;\r\n    }\r\n    .email-footer {\r\n      width: 570px;\r\n      margin: 0 auto;\r\n      padding: 0;\r\n      text-align: center;\r\n    }\r\n    .email-footer p {\r\n      color: #AEAEAE;\r\n    }\r\n  \r\n    .content-cell {\r\n      padding: 35px;\r\n    }\r\n    .align-right {\r\n      text-align: right;\r\n    }\r\n\r\n    /* Type ------------------------------ */\r\n    h1 {\r\n      margin-top: 0;\r\n      color: #2F3133;\r\n      font-size: 19px;\r\n      font-weight: bold;\r\n      text-align: left;\r\n    }\r\n    h2 {\r\n      margin-top: 0;\r\n      color: #2F3133;\r\n      font-size: 16px;\r\n      font-weight: bold;\r\n      text-align: left;\r\n    }\r\n    h3 {\r\n      margin-top: 0;\r\n      color: #2F3133;\r\n      font-size: 14px;\r\n      font-weight: bold;\r\n      text-align: left;\r\n    }\r\n    p {\r\n      margin-top: 0;\r\n      color: #74787E;\r\n      font-size: 16px;\r\n      line-height: 1.5em;\r\n      text-align: left;\r\n    }\r\n    p.sub {\r\n      font-size: 12px;\r\n    }\r\n    p.center {\r\n      text-align: center;\r\n    }\r\n\r\n    /* Buttons ------------------------------ */\r\n    .button {\r\n      display: inline-block;\r\n      width: 200px;\r\n      background-color: #3869D4;\r\n      border-radius: 3px;\r\n      color: #ffffff;\r\n      font-size: 15px;\r\n      line-height: 45px;\r\n      text-align: center;\r\n      text-decoration: none;\r\n      -webkit-text-size-adjust: none;\r\n      mso-hide: all;\r\n    }\r\n    .button--green {\r\n      background-color: #22BC66;\r\n    }\r\n    .button--red {\r\n      background-color: #dc4d2f;\r\n    }\r\n    .button--blue {\r\n      background-color: #3869D4;\r\n    }\r\n</style>\r\n<table cellpadding=\"0\" cellspacing=\"0\" class=\"email-wrapper\" style=\"\r\n    width: 100%;\r\n    margin: 0;\r\n    padding: 0;\" width=\"100%\">\r\n  <tbody>\r\n   <tr>\r\n      <td align=\"center\">\r\n     <table cellpadding=\"0\" cellspacing=\"0\" class=\"email-content\" style=\"width: 100%;\r\n      margin: 0;\r\n      padding: 0;\" width=\"100%\"><!-- Logo -->\r\n       <tbody><!-- Email Body -->\r\n          <tr>\r\n            <td class=\"email-body\" style=\"width: 100%;\r\n    margin: 0;\r\n    padding: 0;\r\n    border-top: 1px solid #edeef2;\r\n    border-bottom: 1px solid #edeef2;\r\n    background-color: #edeef2;\" width=\"100%\">\r\n           <table align=\"center\" cellpadding=\"0\" cellspacing=\"0\" class=\"email-body_inner\" style=\" width: 570px;\r\n    margin:  14px auto;\r\n    background: #fff;\r\n    padding: 0;\r\n    border: 1px outset rgba(136, 131, 131, 0.26);\r\n    box-shadow: 0px 6px 38px rgb(0, 0, 0);\r\n       \" width=\"570\"><!-- Body content -->\r\n              <thead style=\"background: #3869d4;\">\r\n                <tr>\r\n                  <th>\r\n                  <div align=\"center\" style=\"padding: 15px; color: #000;\"><a class=\"email-masthead_name\" href=\"{var_action_url}\" style=\"font-size: 16px;\r\n      font-weight: bold;\r\n      color: #bbbfc3;\r\n      text-decoration: none;\r\n      text-shadow: 0 1px 0 white;\">{var_sender_name}</a></div>\r\n                 </th>\r\n               </tr>\r\n             </thead>\r\n              <tbody>\r\n               <tr>\r\n                  <td class=\"content-cell\" style=\"padding: 35px;\">\r\n                  <h1>Hi {var_user_name},</h1>\r\n\r\n                  <p>Ticket Name: {var_ticket_name}</p>\r\n\r\n                 <p>Message: {var_close_message}</p>\r\n\r\n                 <p>&nbsp;</p>\r\n                 <!-- Action -->\r\n\r\n                 <table align=\"center\" cellpadding=\"0\" cellspacing=\"0\" class=\"body-action\" style=\"\r\n      width: 100%;\r\n      margin: 30px auto;\r\n      padding: 0;\r\n      text-align: center;\" width=\"100%\">\r\n                    <tbody>\r\n                     <tr>\r\n                        <td align=\"center\">\r\n                       <div><a href=\"{var_ticket_view_link}\" style=\"color: #000;\r\n      font-size: 15px;\r\n      text-align: center;\">Show Ticket</a>&nbsp;&nbsp;</div>\r\n                       </td>\r\n                     </tr>\r\n                   </tbody>\r\n                  </table>\r\n\r\n                  <p>&nbsp;</p>\r\n\r\n                 <p>Thanks,<br />\r\n                  Expence Manager&nbsp;Team</p>\r\n                 <!-- Sub copy -->\r\n\r\n                 <table class=\"body-sub\" style=\"margin-top: 25px;\r\n      padding-top: 25px;\r\n      border-top: 1px solid #EDEFF2;\">\r\n                    <tbody>\r\n                     <tr>\r\n                        <td>\r\n                        <p class=\"sub\" style=\"font-size:12px;\">If you are having trouble clicking the button, copy and paste the URL below into your web browser.</p>\r\n\r\n                       <p class=\"sub\" style=\"font-size:12px;\"><a href=\"{var_direct_link}\">{var_direct_link}</a></p>\r\n                        </td>\r\n                     </tr>\r\n                   </tbody>\r\n                  </table>\r\n                  </td>\r\n               </tr>\r\n             </tbody>\r\n            </table>\r\n            </td>\r\n         </tr>\r\n       </tbody>\r\n      </table>\r\n      </td>\r\n   </tr>\r\n </tbody>\r\n</table>\r\n'),
(17, 'Ticket Recurring', 'ticket_recurring', 'Ticket Recurring', '<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\"><meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">\r\n<style media=\"all\" rel=\"stylesheet\" type=\"text/css\">/* Base ------------------------------ */\r\n    *:not(br):not(tr):not(html) {\r\n      font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif;\r\n      -webkit-box-sizing: border-box;\r\n      box-sizing: border-box;\r\n    }\r\n    body {\r\n      \r\n    }\r\n    a {\r\n      color: #3869D4;\r\n    }\r\n\r\n\r\n    /* Masthead ----------------------- */\r\n    .email-masthead {\r\n      padding: 25px 0;\r\n      text-align: center;\r\n    }\r\n    .email-masthead_logo {\r\n      max-width: 400px;\r\n      border: 0;\r\n    }\r\n    .email-footer {\r\n      width: 570px;\r\n      margin: 0 auto;\r\n      padding: 0;\r\n      text-align: center;\r\n    }\r\n    .email-footer p {\r\n      color: #AEAEAE;\r\n    }\r\n  \r\n    .content-cell {\r\n      padding: 35px;\r\n    }\r\n    .align-right {\r\n      text-align: right;\r\n    }\r\n\r\n    /* Type ------------------------------ */\r\n    h1 {\r\n      margin-top: 0;\r\n      color: #2F3133;\r\n      font-size: 19px;\r\n      font-weight: bold;\r\n      text-align: left;\r\n    }\r\n    h2 {\r\n      margin-top: 0;\r\n      color: #2F3133;\r\n      font-size: 16px;\r\n      font-weight: bold;\r\n      text-align: left;\r\n    }\r\n    h3 {\r\n      margin-top: 0;\r\n      color: #2F3133;\r\n      font-size: 14px;\r\n      font-weight: bold;\r\n      text-align: left;\r\n    }\r\n    p {\r\n      margin-top: 0;\r\n      color: #74787E;\r\n      font-size: 16px;\r\n      line-height: 1.5em;\r\n      text-align: left;\r\n    }\r\n    p.sub {\r\n      font-size: 12px;\r\n    }\r\n    p.center {\r\n      text-align: center;\r\n    }\r\n\r\n    /* Buttons ------------------------------ */\r\n    .button {\r\n      display: inline-block;\r\n      width: 200px;\r\n      background-color: #3869D4;\r\n      border-radius: 3px;\r\n      color: #ffffff;\r\n      font-size: 15px;\r\n      line-height: 45px;\r\n      text-align: center;\r\n      text-decoration: none;\r\n      -webkit-text-size-adjust: none;\r\n      mso-hide: all;\r\n    }\r\n    .button--green {\r\n      background-color: #22BC66;\r\n    }\r\n    .button--red {\r\n      background-color: #dc4d2f;\r\n    }\r\n    .button--blue {\r\n      background-color: #3869D4;\r\n    }\r\n</style>\r\n<table cellpadding=\"0\" cellspacing=\"0\" class=\"email-wrapper\" style=\"\r\n    width: 100%;\r\n    margin: 0;\r\n    padding: 0;\" width=\"100%\">\r\n  <tbody>\r\n   <tr>\r\n      <td align=\"center\">\r\n     <table cellpadding=\"0\" cellspacing=\"0\" class=\"email-content\" style=\"width: 100%;\r\n      margin: 0;\r\n      padding: 0;\" width=\"100%\"><!-- Logo -->\r\n       <tbody><!-- Email Body -->\r\n          <tr>\r\n            <td class=\"email-body\" style=\"width: 100%;\r\n    margin: 0;\r\n    padding: 0;\r\n    border-top: 1px solid #edeef2;\r\n    border-bottom: 1px solid #edeef2;\r\n    background-color: #edeef2;\" width=\"100%\">\r\n           <table align=\"center\" cellpadding=\"0\" cellspacing=\"0\" class=\"email-body_inner\" style=\" width: 570px;\r\n    margin:  14px auto;\r\n    background: #fff;\r\n    padding: 0;\r\n    border: 1px outset rgba(136, 131, 131, 0.26);\r\n    box-shadow: 0px 6px 38px rgb(0, 0, 0);\r\n       \" width=\"570\"><!-- Body content -->\r\n              <thead style=\"background: #3869d4;\">\r\n                <tr>\r\n                  <th>\r\n                  <div align=\"center\" style=\"padding: 15px; color: #000;\"><a class=\"email-masthead_name\" href=\"{var_action_url}\" style=\"font-size: 16px;\r\n      font-weight: bold;\r\n      color: #bbbfc3;\r\n      text-decoration: none;\r\n      text-shadow: 0 1px 0 white;\">{var_sender_name}</a></div>\r\n                 </th>\r\n               </tr>\r\n             </thead>\r\n              <tbody>\r\n               <tr>\r\n                  <td class=\"content-cell\" style=\"padding: 35px;\">\r\n                  <h1>Hi {var_user_name},</h1>\r\n\r\n                  <p>Ticket Name: {var_ticket_name}</p>\r\n\r\n                 <p>Message: This is test message</p>\r\n\r\n                  <p>&nbsp;</p>\r\n                 <!-- Action -->\r\n\r\n                 <table align=\"center\" cellpadding=\"0\" cellspacing=\"0\" class=\"body-action\" style=\"\r\n      width: 100%;\r\n      margin: 30px auto;\r\n      padding: 0;\r\n      text-align: center;\" width=\"100%\">\r\n                    <tbody>\r\n                     <tr>\r\n                        <td align=\"center\">\r\n                       <div><a href=\"{var_ticket_view_link}\" style=\"color: #000;\r\n      font-size: 15px;\r\n      text-align: center;\">Show Ticket</a>&nbsp;&nbsp;</div>\r\n                       </td>\r\n                     </tr>\r\n                   </tbody>\r\n                  </table>\r\n\r\n                  <p>&nbsp;</p>\r\n\r\n                 <p>Thanks,<br />\r\n                  Expence Manager&nbsp;Team</p>\r\n                 <!-- Sub copy -->\r\n\r\n                 <table class=\"body-sub\" style=\"margin-top: 25px;\r\n      padding-top: 25px;\r\n      border-top: 1px solid #EDEFF2;\">\r\n                    <tbody>\r\n                     <tr>\r\n                        <td>\r\n                        <p class=\"sub\" style=\"font-size:12px;\">If you are having trouble clicking the button, copy and paste the URL below into your web browser.</p>\r\n\r\n                       <p class=\"sub\" style=\"font-size:12px;\"><a href=\"{var_direct_link}\">{var_direct_link}</a></p>\r\n                        </td>\r\n                     </tr>\r\n                   </tbody>\r\n                  </table>\r\n                  </td>\r\n               </tr>\r\n             </tbody>\r\n            </table>\r\n            </td>\r\n         </tr>\r\n       </tbody>\r\n      </table>\r\n      </td>\r\n   </tr>\r\n </tbody>\r\n</table>\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `ia_menu`
--

CREATE TABLE `ia_menu` (
  `id` int(122) UNSIGNED NOT NULL,
  `menu_name` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `module_name` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `parent_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ia_menu`
--

INSERT INTO `ia_menu` (`id`, `menu_name`, `icon`, `slug`, `module_name`, `status`, `parent_id`) VALUES
(2, 'timeline', 'glyphicon glyphicon-road', 'timeline', 'timeline', 1, 0),
(6, 'document_maker', 'glyphicon glyphicon-list-alt', 'document_maker', 'document_maker', 1, 0),
(7, 'Tasks', 'glyphicon glyphicon-certificate', 'tasks', 'tasks', 1, 0),
(8, 'todo', 'glyphicon glyphicon-list', 'todo', 'todo', 1, 0),
(9, 'projects', 'glyphicon glyphicon-certificate', 'projects', 'projects', 1, 0),
(10, 'invoice', 'glyphicon glyphicon-modal-window', 'invoice', 'invoice', 1, 0),
(11, 'invoice_list', '', 'invoice/view', 'invoice', 1, 10),
(12, 'invoice_setting', '', 'invoice/setting', 'invoice', 1, 10),
(13, 'customers', '', 'invoice/customers_index', 'invoice', 1, 10),
(14, 'products', '', 'invoice/products_index', 'invoice', 1, 10),
(15, 'ticket', 'glyphicon glyphicon-dashboard', 'ticket', 'ticket', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ia_permission`
--

CREATE TABLE `ia_permission` (
  `id` int(122) UNSIGNED NOT NULL,
  `user_type` varchar(250) DEFAULT NULL,
  `data` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ia_permission`
--

INSERT INTO `ia_permission` (`id`, `user_type`, `data`) VALUES
(1, 'admin', '{\"user\":\"user\",\"timeline\":\"timeline\",\"document_maker\":\"document_maker\",\"demo\":\"demo\",\"todo\":\"todo\",\"project\":\"project\",\"invoice\":\"invoice\",\"ticket\":\"ticket\"}'),
(2, 'user', '{\"user\":\"user\",\"timeline\":\"timeline\",\"document_maker\":\"document_maker\",\"demo\":\"demo\",\"todo\":\"todo\",\"project\":\"project\",\"invoice\":\"invoice\",\"ticket\":\"ticket\"}');

-- --------------------------------------------------------

--
-- Table structure for table `ia_plugins`
--

CREATE TABLE `ia_plugins` (
  `plugins_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(250) DEFAULT NULL,
  `db_tables` varchar(250) DEFAULT NULL,
  `status` varchar(250) DEFAULT NULL,
  `inst_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `rm_queries` longtext,
  `version` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ia_plugins`
--

INSERT INTO `ia_plugins` (`plugins_id`, `name`, `db_tables`, `status`, `inst_date`, `rm_queries`, `version`) VALUES
(2, 'timeline', 'ia_posts, ia_post_comments, ia_post_notification', '1', '2019-08-10 02:54:02', 'DELETE FROM `ia_email_templates` WHERE `code` = \'undead_post_notification\'', NULL),
(6, 'document_maker', 'ia_document_maker, ia_document_makerfield_type, ia_document_settings', '1', '2019-08-12 09:46:03', 'DELETE FROM `ia_email_templates` WHERE `code` = \'document_maker\'', NULL),
(7, 'demo', 'ia_demo_plugin', '1', '2019-08-12 09:49:55', NULL, NULL),
(8, 'todo', 'ia_todo', '1', '2019-08-13 09:34:12', NULL, NULL),
(9, 'project', 'project,project_comments,project_files,project_members,project_settings,project_time', '1', '2019-08-22 04:13:45', NULL, NULL),
(10, 'invoice', 'customers,invoice,invoice_settings,products,templates', '1', '2019-08-22 06:36:35', NULL, NULL),
(11, 'ticket', 'ia_ticket, ia_ticket_comments', '1', '2019-08-24 03:36:42', 'DELETE FROM `ia_email_templates` WHERE `code` IN (\'comment\', \'close_ticket\', \'ticket_recurring\')', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ia_posts`
--

CREATE TABLE `ia_posts` (
  `id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `post_id` int(11) NOT NULL,
  `share_with` text COLLATE utf8_unicode_ci,
  `files` longtext COLLATE utf8_unicode_ci,
  `deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ia_posts`
--

INSERT INTO `ia_posts` (`id`, `created_by`, `created_at`, `description`, `post_id`, `share_with`, `files`, `deleted`) VALUES
(1, 1, '2019-09-03 07:53:25', 'Hello, Good morning', 0, '0', '[\"timeline_last-phot14-large.jpg\"]', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ia_post_comments`
--

CREATE TABLE `ia_post_comments` (
  `id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `comment` varchar(250) DEFAULT NULL,
  `createdate` timestamp NULL DEFAULT NULL,
  `deleted` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ia_post_notification`
--

CREATE TABLE `ia_post_notification` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ia_sessions`
--

CREATE TABLE `ia_sessions` (
  `id` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `ip_address` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ia_sessions`
--

INSERT INTO `ia_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('4k6vvg9o3n1n3has1jlcui6bvg5o1it7', '::1', 1566478576, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363437383537363b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b),
('430kaj39t0ddkmuv73g3btvcsdr0h495', '::1', 1566478068, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363437383036383b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b),
('e7u5lt9s7lob0as0m7u3mvqtl29v9o0m', '::1', 1566477281, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363437373238313b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b),
('kpvr7q2mtdlb0iqbkn1lvnmlnhjr980d', '::1', 1566476887, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363437363838373b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b),
('sbu3i4u1q5nn0mfo6avmc7odduh9kr24', '::1', 1566475034, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363437353033343b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b),
('k0atfr8v2jeg402ee11c9g7tphhk8un9', '::1', 1566475660, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363437353636303b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b),
('j96qmaf7iivc9u1im2mvqfkbefdgq9sc', '::1', 1566474378, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363437343337383b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b),
('slgcs9juq9qs2ahmbt4fvpnvgr2a6502', '::1', 1566473953, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363437333935333b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b),
('tqo7a5sgf9a34dmbprfdciro7hkm0hjp', '::1', 1566473624, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363437333632343b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b),
('gh3skn77rlrea2uofgu39ctv275mg3kr', '::1', 1566472867, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363437323836373b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b),
('k5s7hq08siingnvfcrhfv1v3c54r2cuq', '::1', 1566471609, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363437313630393b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b),
('cr5erb3044j4iopq1bvl3vm6i8q7a89i', '::1', 1566471135, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363437313133353b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b),
('gsao5cn2s1c2ceoq47i1tfmv89qe8sga', '::1', 1566470540, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363437303534303b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b),
('l8g8hgt3h64ad2gvkbopjdl78re9v7g2', '::1', 1566469944, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363436393934343b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b),
('3l9q9mi4hriqerq138uv4bo31kg0h1ds', '::1', 1566469210, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363436393231303b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b),
('742mkrub8h1ufmqr8p8rgrhncccnrike', '::1', 1566469633, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363436393633333b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b),
('uf7mf4adee2tkdj1hepjaje9467mb3ac', '::1', 1566468689, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363436383638393b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b),
('bdhmhng5h642rsr7uea6128tps5tefr2', '::1', 1566468371, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363436383337313b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b),
('j199eul8fmrdrque49ka9kdi9pun0ihu', '::1', 1566467909, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363436373930393b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b),
('s2l9d1e2sicunqpg9l9n399271oj66k5', '::1', 1566467447, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363436373434373b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b),
('20lud1j1gpbm9jmq7kvkks5r44o14t7l', '::1', 1566467083, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363436373038333b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b),
('tvv4go7mj58of8l92dv0j02g0fi1dpp9', '::1', 1566466762, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363436363736323b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b),
('cqprqcfqujl8f0puk10ua6p5e4p2toud', '::1', 1566462227, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363436323232373b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b),
('bncp87k5mrci21vetdab09nn8vb1r8ag', '::1', 1566298348, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363239383334383b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b),
('i5eqlks75cfb8j6k28ln7bougn63eesk', '::1', 1566297977, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363239373937373b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b),
('0849v0sou1qmqj9entas7ovp3dv3vesl', '::1', 1566296991, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363239363939313b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b),
('rcv2miv324a3m2njl0aicutuqa90jqnp', '::1', 1566296398, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363239363339383b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b),
('tfjkj6e7mshtjk0jkienkcsu2uartabv', '::1', 1566296057, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363239363035373b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b6d6573736167657c733a33333a22596f7572206461746120696e736572746564205375636365737366756c6c792e2e223b5f5f63695f766172737c613a313a7b733a373a226d657373616765223b733a333a226e6577223b7d),
('ms7s0b4ootdhvut3nbsj507osc05mpo2', '::1', 1566295622, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363239353632323b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b6d6573736167657c733a33333a22596f7572206461746120696e736572746564205375636365737366756c6c792e2e223b5f5f63695f766172737c613a313a7b733a373a226d657373616765223b733a333a226e6577223b7d),
('8unv1r0128f20m0gk7lfrrei7tu4gtnt', '::1', 1566294880, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363239343838303b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b),
('v8mtfdih7osahkadsp8p9uavm5ti0fe2', '::1', 1566461448, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363436313434383b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b),
('b3bjfdjsr0927n35sc7r0pea3e5qgjfa', '::1', 1566461788, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363436313738383b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b),
('h61fr37s1pq9qkl20fa2ud1ppjcs4qtp', '::1', 1566461083, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363436313038333b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b),
('bq5h2hj2bu4ebgfqco538o5lr145is2s', '::1', 1566460757, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363436303735373b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b),
('iockrgttocilqqe2fk758eg28eldvd4j', '::1', 1566460213, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363436303231333b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b),
('tkea5vukao84ntjbrevodlhp37hr5u0p', '::1', 1566459791, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363435393739313b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b),
('tcfhdg31v9bosr170qbh3crim945f9kc', '::1', 1566449390, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363434393337353b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b),
('titqs61av1l2jgk1nv5fpc2o7pkn3t66', '::1', 1566371310, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363337313330373b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b),
('o5jmvveqn72m45iei6uon6kpt1q76k7j', '::1', 1566371307, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363337313330373b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b),
('depnvo2ocqrdbd02chmv2r5gvbbiksrs', '::1', 1566310143, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363330353132343b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b),
('jj5b9ul4bp84aigse30fb6f588lqqcuu', '::1', 1566305124, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363330353132343b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b),
('fgugevpti6smuksha9idmalk5rfpairn', '::1', 1566304439, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363330343433393b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b),
('q8r8168eu88qlubt6gjbqs7ch3st5382', '::1', 1566303828, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363330333832383b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b),
('o9fpkr9r0vhup4petq4o0vrvj3jbjtts', '::1', 1566363888, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363336333834323b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b),
('23lcd1vehhpebhkil1i57oitk8s38ao0', '::1', 1566302629, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363330323632393b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b),
('dvjfanr39hsu61spuh9q0hdo9rek6ei2', '::1', 1566302328, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363330323332383b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b),
('tfudbeid4tija9ni5oeohnspa52rn8ln', '::1', 1566301817, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363330313831373b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b),
('8i5da6rm9a12v641genka8q36uq9b50r', '::1', 1566301502, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363330313530323b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b),
('ll1gs7f6fvfkj75u4j0i7sa71cu7scdm', '::1', 1566301126, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363330313132363b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b),
('utgfubogb9vtfg5l106cnn3p0ul7ddju', '::1', 1566300808, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363330303830383b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b),
('pp1qactthdhqumd63il06tm5uolrklhh', '::1', 1566300228, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363330303232383b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b),
('1ovbl50mfq13j7h5rq09vri314h3mr4q', '::1', 1566299765, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363239393736353b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b),
('ka2ecnvntrikf87ki8gofduu7bdvo6oi', '::1', 1566299429, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363239393432393b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b);
INSERT INTO `ia_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('jcq2vuh6jsc8ihnn1jcsl5dmd20o0aoa', '::1', 1566298896, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363239383839363b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b),
('qhebk5hcskvqn5h5hp2b1djnmkc5jgcs', '::1', 1566478976, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363437383937363b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b),
('cf5ulut8dght80g5fglvgm3mf06gjmqb', '::1', 1566479394, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363437393339343b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b),
('2hvvnrnjng496o3ktvbhhtlcjja15oit', '::1', 1566480197, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363438303139373b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b),
('pjltic3pofe7krlejke3v1uui3bc478m', '::1', 1566480775, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363438303737353b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b),
('r51po049qch2u6gh4gbuulliln3560ao', '::1', 1566481156, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363438313135363b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b),
('upeg3a4bj3co1m6hr09aq6ibaes5ikng', '::1', 1566481596, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363438313539363b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b),
('qus1dlqjrlh2ukr1347m3b921buffu7b', '::1', 1566481922, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363438313932323b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b),
('e9hlmgc7cmhkgtapgj4rte6m7h5m68ul', '::1', 1566482327, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363438323332373b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b),
('np4ni0ck02svbbgtgfg0iou2lon34u7o', '::1', 1566482634, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363438323633343b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b),
('o39g7fu27gi90rsal9d5letj0mlfbmki', '::1', 1566482965, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363438323936353b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b),
('7ap3gg6m2episqodiprugor7fl40jq00', '::1', 1566482988, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363438323936353b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b),
('5ot9l6uh41ii135sm5rlims6sj4ggor7', '::1', 1566542909, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363534323930393b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b),
('9tphockptij9hbk4l6p7e3s4ts7enpcm', '::1', 1566543163, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363534323930393b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b),
('fe1p6v6meun7bfg6qesvjtrncingpem2', '::1', 1566567032, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363536373033323b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b),
('ccmt2fqkq18k5dgi7fuas1itcup5oev9', '::1', 1566568001, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363536383030313b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b),
('v6in9qrifus0m8epasnh40gp76b83hqg', '::1', 1566568002, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363536383030313b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b),
('ppu304tq5p4p2ev2883n7uhmm733ohrl', '::1', 1566630681, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363633303638313b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b),
('7ihrihvg9mjov6m2s337u75b1oo24gma', '::1', 1566630825, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363633303638313b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b),
('orgs9ih41tf75ij9hutpbt8ul5usmvqc', '::1', 1566632090, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363633323039303b),
('l0imf5qe021clhpc6l998bt5r0agoaih', '::1', 1567435078, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373433353037383b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b),
('gfcadrqiptt3visd8onfoujcucnvlu26', '::1', 1567435084, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373433353037383b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b),
('s6mv3rmnmuo02tfpsaa70jn1urmmmnjn', '::1', 1567487518, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373438373531313b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b),
('im8dnbk3ft913otb0epnoi7dq8bpggke', '::1', 1567490006, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373438393933373b757365725f64657461696c737c613a313a7b693a303b4f3a383a22737464436c617373223a31313a7b733a31313a2269615f75736572735f6964223b733a313a2231223b733a373a22757365725f6964223b733a313a2231223b733a373a227661725f6b6579223b4e3b733a363a22737461747573223b733a363a22616374697665223b733a31303a2269735f64656c65746564223b733a313a2230223b733a343a226e616d65223b733a353a2241646d696e223b733a383a2270617373776f7264223b733a36303a22243279243130243058666a4d435646693652445077423034394e36344f48795a43736c64644542704437436c58774f71546b59797735353165364e6d223b733a353a22656d61696c223b733a31353a2261646d696e4061646d696e2e636f6d223b733a31313a2270726f66696c655f706963223b733a383a22757365722e706e67223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a31313a226372656174655f64617465223b4e3b7d7d56657273696f6e436865636b696e677c693a313b);

-- --------------------------------------------------------

--
-- Table structure for table `ia_setting`
--

CREATE TABLE `ia_setting` (
  `id` int(122) UNSIGNED NOT NULL,
  `keys` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ia_setting`
--

INSERT INTO `ia_setting` (`id`, `keys`, `value`) VALUES
(1, 'website', 'Igniter Admin'),
(2, 'logo', 'logo_white_text4_1518007532.png'),
(3, 'favicon', 'olalquiaga-arquitectos-social-housing-3_1517468350.jpg'),
(4, 'SMTP_EMAIL', 'ibr.suhel@gmail.com'),
(5, 'HOST', 'ssl://smtp.gmail.com'),
(6, 'PORT', '465'),
(7, 'SMTP_SECURE', 'ibr.suhel@gmail.com'),
(8, 'SMTP_PASSWORD', 'Test321$#'),
(9, 'mail_setting', 'php_mailer'),
(10, 'company_name', 'Igniter Admin'),
(11, 'crud_list', 'User'),
(12, 'EMAIL', ''),
(13, 'UserModules', 'yes'),
(14, 'register_allowed', '1'),
(15, 'email_invitation', '1'),
(16, 'admin_approval', '0'),
(17, 'language', 'english'),
(18, 'user_type', '[\"user\"]'),
(19, 'date_formate', ''),
(20, 'version', '1.0.1');

-- --------------------------------------------------------

--
-- Table structure for table `ia_ticket`
--

CREATE TABLE `ia_ticket` (
  `ticket_id` int(11) NOT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `ticket_ticket_id` varchar(255) DEFAULT NULL,
  `ticket_ticket_title` varchar(255) DEFAULT NULL,
  `ticket_client` varchar(255) DEFAULT NULL,
  `ticket_ticket_type` varchar(255) DEFAULT NULL,
  `ticket_description` text,
  `ticket_status` varchar(255) DEFAULT NULL,
  `ticket_upload_document` varchar(255) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `close_date` timestamp NULL DEFAULT NULL,
  `close_by` int(11) DEFAULT NULL,
  `recurring` int(11) NOT NULL,
  `recurring_type` varchar(250) DEFAULT NULL,
  `repeat_every` int(11) DEFAULT NULL,
  `recurring_ends_on` date DEFAULT NULL,
  `custom_recurring` int(11) NOT NULL,
  `last_recurring_date` date DEFAULT NULL,
  `recurring_from` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ia_ticket`
--

INSERT INTO `ia_ticket` (`ticket_id`, `user_id`, `ticket_ticket_id`, `ticket_ticket_title`, `ticket_client`, `ticket_ticket_type`, `ticket_description`, `ticket_status`, `ticket_upload_document`, `created`, `close_date`, `close_by`, `recurring`, `recurring_type`, `repeat_every`, `recurring_ends_on`, `custom_recurring`, `last_recurring_date`, `recurring_from`) VALUES
(1, '1', NULL, 'Ticket title 3', '1', 'General support', '123465', 'Open', '', '2019-08-24 03:37:14', NULL, NULL, 1, 'month', 2, '2019-10-31', 0, NULL, NULL),
(2, '1', NULL, 'utyut', '1', 'General support', 'rtytryr', 'Close', '', '2019-08-24 03:39:01', '2019-08-24 03:41:28', 1, 1, 'month', 1, '2019-09-30', 0, NULL, NULL),
(3, '1', NULL, 'Ticket title 3', '1', 'General support', 'cvcbzvz', 'Open', '', '2019-08-24 03:43:40', NULL, NULL, 1, 'week', 2, '2019-09-14', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ia_ticket_comments`
--

CREATE TABLE `ia_ticket_comments` (
  `id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `files` longtext COLLATE utf8_unicode_ci,
  `deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ia_todo`
--

CREATE TABLE `ia_todo` (
  `todo_id` int(11) NOT NULL,
  `description` longtext,
  `user_id` int(11) DEFAULT NULL,
  `dateadded` datetime DEFAULT NULL,
  `finished` tinyint(4) NOT NULL,
  `datefinished` datetime DEFAULT NULL,
  `item_order` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ia_todo`
--

INSERT INTO `ia_todo` (`todo_id`, `description`, `user_id`, `dateadded`, `finished`, `datefinished`, `item_order`) VALUES
(3, 'wea df dx ghghth', 1, '2019-08-14 13:09:00', 0, '2019-08-20 10:01:47', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ia_users`
--

CREATE TABLE `ia_users` (
  `ia_users_id` int(121) NOT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `var_key` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `is_deleted` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `profile_pic` varchar(255) DEFAULT NULL,
  `user_type` varchar(255) DEFAULT NULL,
  `create_date` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ia_users`
--

INSERT INTO `ia_users` (`ia_users_id`, `user_id`, `var_key`, `status`, `is_deleted`, `name`, `password`, `email`, `profile_pic`, `user_type`, `create_date`) VALUES
(1, '1', NULL, 'active', '0', 'Admin', '$2y$10$0XfjMCVFi6RDPwB049N64OHyZCslddEBpD7ClXwOqTkYyw551e6Nm', 'admin@admin.com', 'user.png', 'admin', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `invoice_id` int(11) UNSIGNED NOT NULL,
  `invoice_no` varchar(250) NOT NULL,
  `customer_name` varchar(250) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `status` varchar(250) DEFAULT NULL,
  `subtotal` double DEFAULT NULL,
  `total` double DEFAULT NULL,
  `discount` float DEFAULT NULL,
  `discount_type` varchar(25) DEFAULT NULL,
  `product_details` text,
  `file_name` varchar(250) DEFAULT NULL,
  `build_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`invoice_id`, `invoice_no`, `customer_name`, `user_id`, `status`, `subtotal`, `total`, `discount`, `discount_type`, `product_details`, `file_name`, `build_date`, `due_date`, `date`) VALUES
(1, 'INV-1001', '1', 1, 'Fully Paid', 2100, 2650, 17, 'ft', '[{\"product_id\":\"1\",\"product_name\":\"a\",\"quantity\":\"6\",\"unitprice\":\"350\",\"total\":\"2100\",\"unit\":null}]', 'Invoice-1566567035.pdf', '2019-08-23', '2019-09-07', '2019-08-23 13:30:32');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_settings`
--

CREATE TABLE `invoice_settings` (
  `id` int(11) UNSIGNED NOT NULL,
  `invoice_prefix` varchar(250) DEFAULT NULL,
  `currency` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `date_formate` varchar(250) DEFAULT NULL,
  `taxes` varchar(250) DEFAULT NULL,
  `invoice_status` text,
  `header` longtext,
  `logo` varchar(250) DEFAULT NULL,
  `contant` longtext,
  `footer` longtext
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoice_settings`
--

INSERT INTO `invoice_settings` (`id`, `invoice_prefix`, `currency`, `date_formate`, `taxes`, `invoice_status`, `header`, `logo`, `contant`, `footer`) VALUES
(1, 'INV-1000', 'INR', 'Y-m-d', '[{\"tax_key\":\"service_tax\",\"tax_value\":\"15\",\"calculate_on\":\"sub_total\"},{\"tax_key\":\"Tax_2\",\"tax_value\":\"12\",\"calculate_on\":\"sub_total\"}]', 'Overdue, Draft, Not Paid, Partially Paid, Fully Paid', '<table class=\"table\">\r\n\n  <tbody>\r\n\n    <tr>\r\n\n      <td width=\"40%\">\r\n\n      <h2><strong style=\"color: #111215;\">Your Company Name</strong></h2>\r\n\n      123 Your Street,<br />\r\n\n      Your Town<br />\r\n\n      Address Line 3<br />\r\n\n      <br />\r\n\n      (+91) 1111111111<br />\r\n\n      test@example.com</td>\r\n\n      <td width=\"24%\">&nbsp;</td>\r\n\n      <td width=\"30%\">\r\n\n      <h1 style=\"color: #111215;text-align: right;\"><strong>INVOICE</strong></h1>\r\n\n\r\n\n      <p style=\"text-align: right;\">{order_date}<br />\r\n\n      <strong>Invoice #</strong>{invoice_id}</p>\r\n\n\r\n\n      <p style=\"text-align: right;\"><strong>Att: {user_name}</strong><br />\r\n\n      &nbsp;</p>\r\n\n      </td>\r\n\n    </tr>\r\n\n  </tbody>\r\n\n</table>\r\n\n', '', '<div class=\"row\">\r\n\n<div style=\"padding:30px;\">\r\n\n<p>Dear {user_name}</p>\r\n\n&nbsp;\r\n\n\r\n\n<p>Please find below a cost-breakdown for the recent work completed. Please make payment at your earliest convenience, and do not hesitate to contact me with any questions.</p>\r\n\n&nbsp;\r\n\n\r\n\n<p>Many thanks,<br />\r\n\nYour Name</p>\r\n\n</div>\r\n\n</div>\r\n\n', '<div class=\"row\">\r\n\n<table class=\"table m-t-30\">\r\n\n  <tbody>\r\n\n    <tr>\r\n\n      <td width=\"10%\">\r\n\n      <h5 class=\"small text-inverse font-600\">PAYMENT TERMS AND POLICIES</h5>\r\n\n      </td>\r\n\n    </tr>\r\n\n    <tr width=\"100%\">\r\n\n      <td width=\"90%\">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Veritatis aspernatur vero veniam magnam voluptatibus ipsum,&nbsp;</td>\r\n\n    </tr>\r\n\n  </tbody>\r\n\n</table>\r\n\n</div>\r\n\n');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `products_id` int(121) NOT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `quantity` varchar(255) DEFAULT NULL,
  `unit_price` varchar(255) DEFAULT NULL,
  `product_details` text,
  `product_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`products_id`, `user_id`, `product_name`, `quantity`, `unit_price`, `product_details`, `product_image`) VALUES
(1, '1', 'a', '999988', '350', 'csdcdfsf', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci,
  `start_date` date DEFAULT NULL,
  `deadline` date DEFAULT NULL,
  `client_id` int(11) NOT NULL,
  `created_date` date DEFAULT NULL,
  `created_by` int(11) NOT NULL DEFAULT '0',
  `status` enum('open','completed','hold','cancelled') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'open',
  `labels` text COLLATE utf8_unicode_ci,
  `price` double NOT NULL DEFAULT '0',
  `starred_by` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `estimate_id` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `title`, `description`, `start_date`, `deadline`, `client_id`, `created_date`, `created_by`, `status`, `labels`, `price`, `starred_by`, `estimate_id`, `deleted`) VALUES
(1, 'Project 1', 'asdf', '2019-07-22', '2020-01-01', 1, NULL, 1, 'completed', 'None', 150000, '', 0, 0),
(2, 'Project 2', 'qwert', '2019-08-22', '2019-10-31', 1, NULL, 1, 'open', 'None', 20000, '', 0, 0),
(3, 'Project 3', 'zxcv', '2019-08-01', '2019-08-31', 1, NULL, 1, 'open', 'None', 5000, '', 0, 0),
(4, 'Project 4', 'asqwzx', '2019-08-22', '2021-01-01', 1, NULL, 1, 'open', 'None', 200000, '', 0, 0),
(5, 'Project 5', 'aaaaa', '2019-08-22', '2020-02-24', 1, NULL, 1, 'open', 'None', 40000, '', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `project_comments`
--

CREATE TABLE `project_comments` (
  `id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `project_id` int(11) NOT NULL DEFAULT '0',
  `comment_id` int(11) NOT NULL DEFAULT '0',
  `task_id` int(11) NOT NULL DEFAULT '0',
  `file_id` int(11) NOT NULL DEFAULT '0',
  `customer_feedback_id` int(11) NOT NULL DEFAULT '0',
  `files` longtext COLLATE utf8_unicode_ci,
  `deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_files`
--

CREATE TABLE `project_files` (
  `id` int(11) NOT NULL,
  `file_name` text COLLATE utf8_unicode_ci NOT NULL,
  `file_id` text COLLATE utf8_unicode_ci,
  `service_type` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci,
  `file_size` double NOT NULL,
  `created_at` datetime NOT NULL,
  `project_id` int(11) NOT NULL,
  `uploaded_by` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_members`
--

CREATE TABLE `project_members` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `is_leader` tinyint(1) DEFAULT '0',
  `deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_settings`
--

CREATE TABLE `project_settings` (
  `project_id` int(11) NOT NULL,
  `setting_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `setting_value` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_time`
--

CREATE TABLE `project_time` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime DEFAULT NULL,
  `status` enum('open','logged','approved') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'logged',
  `note` text COLLATE utf8_unicode_ci,
  `task_id` int(11) NOT NULL DEFAULT '0',
  `deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci,
  `project_id` int(11) NOT NULL,
  `milestone_id` int(11) NOT NULL DEFAULT '0',
  `assigned_to` int(11) NOT NULL,
  `deadline` date DEFAULT NULL,
  `labels` text COLLATE utf8_unicode_ci,
  `points` tinyint(4) NOT NULL DEFAULT '1',
  `status` enum('to_do','in_progress','done') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'to_do',
  `status_id` int(11) NOT NULL,
  `start_date` date DEFAULT NULL,
  `collaborators` text COLLATE utf8_unicode_ci NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '0',
  `ticket_id` int(11) NOT NULL,
  `deleted` tinyint(11) NOT NULL DEFAULT '0',
  `finished` int(11) DEFAULT NULL,
  `item_order` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `title`, `description`, `project_id`, `milestone_id`, `assigned_to`, `deadline`, `labels`, `points`, `status`, `status_id`, `start_date`, `collaborators`, `sort`, `ticket_id`, `deleted`, `finished`, `item_order`) VALUES
(14, 'Project 1', 'fsfdv rtet tregtey', 1, 0, 1, '2019-08-23', 'None', 1, 'in_progress', 2, '2019-08-20', 'None', 0, 0, 0, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `task_status`
--

CREATE TABLE `task_status` (
  `id` int(11) NOT NULL,
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `key_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `color` varchar(7) COLLATE utf8_unicode_ci NOT NULL,
  `sort` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `task_status`
--

INSERT INTO `task_status` (`id`, `title`, `key_name`, `color`, `sort`, `deleted`) VALUES
(1, 'To Do', 'to_do', '#F9A52D', 0, 0),
(2, 'In progress', 'in_progress', '#1672B9', 1, 0),
(3, 'Done', 'done', '#00B393', 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `templates`
--

CREATE TABLE `templates` (
  `id` int(121) UNSIGNED NOT NULL,
  `module` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `template_name` varchar(255) DEFAULT NULL,
  `html` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `templates`
--

INSERT INTO `templates` (`id`, `module`, `code`, `template_name`, `html`) VALUES
(1, 'forgot_pass', 'forgot_password', 'Forgot password', '<html xmlns=\"http://www.w3.org/1999/xhtml\"><head>\r\n\n  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\r\n\n  <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">\r\n\n  <style type=\"text/css\" rel=\"stylesheet\" media=\"all\">\r\n\n    /* Base ------------------------------ */\r\n\n    *:not(br):not(tr):not(html) {\r\n\n      font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif;\r\n\n      -webkit-box-sizing: border-box;\r\n\n      box-sizing: border-box;\r\n\n    }\r\n\n    body {\r\n\n      \r\n\n    }\r\n\n    a {\r\n\n      color: #3869D4;\r\n\n    }\r\n\n\r\n\n\r\n\n    /* Masthead ----------------------- */\r\n\n    .email-masthead {\r\n\n      padding: 25px 0;\r\n\n      text-align: center;\r\n\n    }\r\n\n    .email-masthead_logo {\r\n\n      max-width: 400px;\r\n\n      border: 0;\r\n\n    }\r\n\n    .email-footer {\r\n\n      width: 570px;\r\n\n      margin: 0 auto;\r\n\n      padding: 0;\r\n\n      text-align: center;\r\n\n    }\r\n\n    .email-footer p {\r\n\n      color: #AEAEAE;\r\n\n    }\r\n\n  \r\n\n    .content-cell {\r\n\n      padding: 35px;\r\n\n    }\r\n\n    .align-right {\r\n\n      text-align: right;\r\n\n    }\r\n\n\r\n\n    /* Type ------------------------------ */\r\n\n    h1 {\r\n\n      margin-top: 0;\r\n\n      color: #2F3133;\r\n\n      font-size: 19px;\r\n\n      font-weight: bold;\r\n\n      text-align: left;\r\n\n    }\r\n\n    h2 {\r\n\n      margin-top: 0;\r\n\n      color: #2F3133;\r\n\n      font-size: 16px;\r\n\n      font-weight: bold;\r\n\n      text-align: left;\r\n\n    }\r\n\n    h3 {\r\n\n      margin-top: 0;\r\n\n      color: #2F3133;\r\n\n      font-size: 14px;\r\n\n      font-weight: bold;\r\n\n      text-align: left;\r\n\n    }\r\n\n    p {\r\n\n      margin-top: 0;\r\n\n      color: #74787E;\r\n\n      font-size: 16px;\r\n\n      line-height: 1.5em;\r\n\n      text-align: left;\r\n\n    }\r\n\n    p.sub {\r\n\n      font-size: 12px;\r\n\n    }\r\n\n    p.center {\r\n\n      text-align: center;\r\n\n    }\r\n\n\r\n\n    /* Buttons ------------------------------ */\r\n\n    .button {\r\n\n      display: inline-block;\r\n\n      width: 200px;\r\n\n      background-color: #3869D4;\r\n\n      border-radius: 3px;\r\n\n      color: #ffffff;\r\n\n      font-size: 15px;\r\n\n      line-height: 45px;\r\n\n      text-align: center;\r\n\n      text-decoration: none;\r\n\n      -webkit-text-size-adjust: none;\r\n\n      mso-hide: all;\r\n\n    }\r\n\n    .button--green {\r\n\n      background-color: #22BC66;\r\n\n    }\r\n\n    .button--red {\r\n\n      background-color: #dc4d2f;\r\n\n    }\r\n\n    .button--blue {\r\n\n      background-color: #3869D4;\r\n\n    }\r\n\n  </style>\r\n\n</head>\r\n\n<body style=\"width: 100% !important;\r\n\n      height: 100%;\r\n\n      margin: 0;\r\n\n      line-height: 1.4;\r\n\n      background-color: #F2F4F6;\r\n\n      color: #74787E;\r\n\n      -webkit-text-size-adjust: none;\">\r\n\n  <table class=\"email-wrapper\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" style=\"\r\n\n    width: 100%;\r\n\n    margin: 0;\r\n\n    padding: 0;\">\r\n\n    <tbody><tr>\r\n\n      <td align=\"center\">\r\n\n        <table class=\"email-content\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" style=\"width: 100%;\r\n\n      margin: 0;\r\n\n      padding: 0;\">\r\n\n          <!-- Logo -->\r\n\n\r\n\n          <tbody>\r\n\n          <!-- Email Body -->\r\n\n          <tr>\r\n\n            <td class=\"email-body\" width=\"100%\" style=\"width: 100%;\r\n\n    margin: 0;\r\n\n    padding: 0;\r\n\n    border-top: 1px solid #edeef2;\r\n\n    border-bottom: 1px solid #edeef2;\r\n\n    background-color: #edeef2;\">\r\n\n              <table class=\"email-body_inner\" align=\"center\" width=\"570\" cellpadding=\"0\" cellspacing=\"0\" style=\" width: 570px;\r\n\n    margin:  14px auto;\r\n\n    background: #fff;\r\n\n    padding: 0;\r\n\n    border: 1px outset rgba(136, 131, 131, 0.26);\r\n\n    box-shadow: 0px 6px 38px rgb(0, 0, 0);\r\n\n       \">\r\n\n                <!-- Body content -->\r\n\n                <thead style=\"background: #3869d4;\"><tr><th><div align=\"center\" style=\"padding: 15px; color: #000;\"><a href=\"{var_action_url}\" class=\"email-masthead_name\" style=\"font-size: 16px;\r\n\n      font-weight: bold;\r\n\n      color: #bbbfc3;\r\n\n      text-decoration: none;\r\n\n      text-shadow: 0 1px 0 white;\">{var_sender_name}</a></div></th></tr>\r\n\n                </thead>\r\n\n                <tbody><tr>\r\n\n                  <td class=\"content-cell\" style=\"padding: 35px;\">\r\n\n                    <h1>Hi {var_user_name},</h1>\r\n\n                    <p>You recently requested to reset your password for your {var_website_name} account. Click the button below to reset it.</p>\r\n\n                    <!-- Action -->\r\n\n                    <table class=\"body-action\" align=\"center\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" style=\"\r\n\n      width: 100%;\r\n\n      margin: 30px auto;\r\n\n      padding: 0;\r\n\n      text-align: center;\">\r\n\n                      <tbody><tr>\r\n\n                        <td align=\"center\">\r\n\n                          <div>\r\n\n                            <!--[if mso]><v:roundrect xmlns:v=\"urn:schemas-microsoft-com:vml\" xmlns:w=\"urn:schemas-microsoft-com:office:word\" href=\"{{var_action_url}}\" style=\"height:45px;v-text-anchor:middle;width:200px;\" arcsize=\"7%\" stroke=\"f\" fill=\"t\">\r\n\n                              <v:fill type=\"tile\" color=\"#dc4d2f\" />\r\n\n                              <w:anchorlock/>\r\n\n                              <center style=\"color:#ffffff;font-family:sans-serif;font-size:15px;\">Reset your password</center>\r\n\n                            </v:roundrect><![endif]-->\r\n\n                            <a href=\"{var_varification_link}\" class=\"button button--red\" style=\"background-color: #dc4d2f;display: inline-block;\r\n\n      width: 200px;\r\n\n      background-color: #3869D4;\r\n\n      border-radius: 3px;\r\n\n      color: #ffffff;\r\n\n      font-size: 15px;\r\n\n      line-height: 45px;\r\n\n      text-align: center;\r\n\n      text-decoration: none;\r\n\n      -webkit-text-size-adjust: none;\r\n\n      mso-hide: all;\">Reset your password</a>\r\n\n                          </div>\r\n\n                        </td>\r\n\n                      </tr>\r\n\n                    </tbody></table>\r\n\n                    <p>If you did not request a password reset, please ignore this email or reply to let us know.</p>\r\n\n                    <p>Thanks,<br>{var_sender_name} and the {var_website_name} Team</p>\r\n\n                   <!-- Sub copy -->\r\n\n                    <table class=\"body-sub\" style=\"margin-top: 25px;\r\n\n      padding-top: 25px;\r\n\n      border-top: 1px solid #EDEFF2;\">\r\n\n                      <tbody><tr>\r\n\n                        <td> \r\n\n                          <p class=\"sub\" style=\"font-size:12px;\">If you are having trouble clicking the password reset button, copy and paste the URL below into your web browser.</p>\r\n\n                          <p class=\"sub\"  style=\"font-size:12px;\"><a href=\"{var_varification_link}\">{var_varification_link}</a></p>\r\n\n                        </td>\r\n\n                      </tr>\r\n\n                    </tbody></table>\r\n\n                  </td>\r\n\n                </tr>\r\n\n              </tbody></table>\r\n\n            </td>\r\n\n          </tr>\r\n\n        </tbody></table>\r\n\n      </td>\r\n\n    </tr>\r\n\n  </tbody></table>\r\n\n\r\n\n\r\n\n</body></html>'),
(2, 'users', 'invitation', 'Invitation', '<p>Hello <strong>{var_user_email}</strong></p>\r\n\n\r\n\n<p>Click below link to register&nbsp;<br />\r\n\n{var_inviation_link}</p>\r\n\n\r\n\n<p>Thanks&nbsp;</p>\r\n\n'),
(3, 'registration', 'registration', 'Registration', '<p>Hello <strong>{var_user_name}</strong></p>\r\n\n<p>Welcome to Notes&nbsp;<br />\r\n\n<p>To complete your registration&nbsp;<br /><br />\r\n\n<a href=\"{var_varification_link}\">please click here</a></p>\r\n\n\n<p>Thanks&nbsp;</p>');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customers_id`);

--
-- Indexes for table `ia_custom_fields`
--
ALTER TABLE `ia_custom_fields`
  ADD PRIMARY KEY (`ia_custom_fields_id`);

--
-- Indexes for table `ia_custom_fields_values`
--
ALTER TABLE `ia_custom_fields_values`
  ADD PRIMARY KEY (`ia_custom_fields_values_id`);

--
-- Indexes for table `ia_demo_plugin`
--
ALTER TABLE `ia_demo_plugin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ia_document_maker`
--
ALTER TABLE `ia_document_maker`
  ADD PRIMARY KEY (`document_maker_id`);

--
-- Indexes for table `ia_document_makerfield_type`
--
ALTER TABLE `ia_document_makerfield_type`
  ADD PRIMARY KEY (`field_type_id`);

--
-- Indexes for table `ia_document_settings`
--
ALTER TABLE `ia_document_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ia_email_templates`
--
ALTER TABLE `ia_email_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ia_menu`
--
ALTER TABLE `ia_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ia_permission`
--
ALTER TABLE `ia_permission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ia_plugins`
--
ALTER TABLE `ia_plugins`
  ADD PRIMARY KEY (`plugins_id`);

--
-- Indexes for table `ia_posts`
--
ALTER TABLE `ia_posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ia_post_comments`
--
ALTER TABLE `ia_post_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ia_post_notification`
--
ALTER TABLE `ia_post_notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ia_sessions`
--
ALTER TABLE `ia_sessions`
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `ia_setting`
--
ALTER TABLE `ia_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ia_ticket`
--
ALTER TABLE `ia_ticket`
  ADD PRIMARY KEY (`ticket_id`);

--
-- Indexes for table `ia_ticket_comments`
--
ALTER TABLE `ia_ticket_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ia_todo`
--
ALTER TABLE `ia_todo`
  ADD PRIMARY KEY (`todo_id`);

--
-- Indexes for table `ia_users`
--
ALTER TABLE `ia_users`
  ADD PRIMARY KEY (`ia_users_id`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`invoice_id`);

--
-- Indexes for table `invoice_settings`
--
ALTER TABLE `invoice_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`products_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_comments`
--
ALTER TABLE `project_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_files`
--
ALTER TABLE `project_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_members`
--
ALTER TABLE `project_members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_settings`
--
ALTER TABLE `project_settings`
  ADD UNIQUE KEY `unique_index` (`project_id`,`setting_name`);

--
-- Indexes for table `project_time`
--
ALTER TABLE `project_time`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `task_status`
--
ALTER TABLE `task_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `templates`
--
ALTER TABLE `templates`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customers_id` int(121) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ia_custom_fields`
--
ALTER TABLE `ia_custom_fields`
  MODIFY `ia_custom_fields_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ia_custom_fields_values`
--
ALTER TABLE `ia_custom_fields_values`
  MODIFY `ia_custom_fields_values_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ia_demo_plugin`
--
ALTER TABLE `ia_demo_plugin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ia_document_maker`
--
ALTER TABLE `ia_document_maker`
  MODIFY `document_maker_id` int(121) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ia_document_makerfield_type`
--
ALTER TABLE `ia_document_makerfield_type`
  MODIFY `field_type_id` int(121) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ia_document_settings`
--
ALTER TABLE `ia_document_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ia_email_templates`
--
ALTER TABLE `ia_email_templates`
  MODIFY `id` int(121) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `ia_menu`
--
ALTER TABLE `ia_menu`
  MODIFY `id` int(122) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `ia_permission`
--
ALTER TABLE `ia_permission`
  MODIFY `id` int(122) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ia_plugins`
--
ALTER TABLE `ia_plugins`
  MODIFY `plugins_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `ia_posts`
--
ALTER TABLE `ia_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ia_post_comments`
--
ALTER TABLE `ia_post_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ia_post_notification`
--
ALTER TABLE `ia_post_notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ia_setting`
--
ALTER TABLE `ia_setting`
  MODIFY `id` int(122) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `ia_ticket`
--
ALTER TABLE `ia_ticket`
  MODIFY `ticket_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ia_ticket_comments`
--
ALTER TABLE `ia_ticket_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ia_todo`
--
ALTER TABLE `ia_todo`
  MODIFY `todo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ia_users`
--
ALTER TABLE `ia_users`
  MODIFY `ia_users_id` int(121) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `invoice_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `invoice_settings`
--
ALTER TABLE `invoice_settings`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `products_id` int(121) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `project_comments`
--
ALTER TABLE `project_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_files`
--
ALTER TABLE `project_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_members`
--
ALTER TABLE `project_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_time`
--
ALTER TABLE `project_time`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `task_status`
--
ALTER TABLE `task_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `templates`
--
ALTER TABLE `templates`
  MODIFY `id` int(121) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
