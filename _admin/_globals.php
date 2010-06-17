<?php
                                                                                                                                                                                                                                                            /*
MARKETPLACE SOFTWARE                                             
PRODUCED BY: Joe Boydston  (http://joeboydston.com)              
PROGRAMMING BY: Daniel Brown, INC.  (http://danielbrowninc.com)  
																																		
Version 2.1                                                      
This is open source software.                                    
To ensure this software works correctly, update                  
Sections 1 through 3                                             
                                                                                                                                                                                                                                                            */ 
                                                                                                                                                                                                                                                            /*
SECTION 1  -> GOOGLEMAPKEY & GOOGLEVERIFYKEY
              In order for the maps to work correctly, you need to add your domains google map key.  You can 
              get the GOOGLEMAPKEY by going to:  http://code.google.com/apis/maps/signup.html and filling out the 
              required information.  Copy and paste the key into GOOGLEMAPKEY.  If you have a webmasters account with Google,
              you can get a key to verify your site.  This is not require, but makes indexing your site with Google faster.  
                                                                                                                                                                                                                                                            */ 
              define (GOOGLEMAPKEY,    "ABQIAAAAZo1B7JJRVHurmXSaOm46lxTLzLChOvbICPg0xQzQ904yIb2ITRQMc6GF7KDYSjGR1Wo0lqli54MeNQ");
              define (GOOGLEVERIFYKEY, "");
                                                                                                                                                                                                                                                                          /*
SECTION 2  -> CUSTOM PAGE TITLES & OTHER GENERAL SETTINGS
              These setting allow you to customize the page titles for marketplace with out having to modify your templates.   
              PAGETITLE      = The general page title of Marketplace.
              PAGETITLELUNCH = The title of the lunch special page (no change required)
              PAGETITLEADMIN = The title of the admin pages (no change required)
                                                                                                                                                                                                                                                            */ 
              define (COMPANYNAME,      "Marketplace");
              define (COMPANYEMAIL,     "marketplace@marketplace.com");
              define (CONTACTPHONE,     "8005551212");
              
              // No change required for remainder of Section 2, continue to Section 3
              define (PAGETITLE,        COMPANYNAME);
              define (PAGETITLELUNCH,   PAGETITLE." - Lunch Specials");
              define (PAGETITLEADMIN,   PAGETITLE." - Settings");
              define (COPYRIGHT,        "&copy; ".date("Y")." ".COMPANYNAME);
              define (GIFTCARD_PROGRAM, COMPANYNAME." Half Off");
              define (PAGE_DESCRIPTION, "Your Area's Local Business Directory.  Find what you need fast!");
              define (PAGE_KEYWORDS,    "Video Rental Stores, Bars and Clubs information, Automotive information center, Towing Wreckers Services, Restaurants Directory, Sweets and Desserts Stores, home healthcare service, Health and Fitness Clubs, health care provider directory, Health Clubs Directory, Real Estate Agents directory, Retail Electronic Stores Directory, Arts and Crafts Stores, Hauling and Shipping Services, Architects Informations, Home and Garden Directory, Housewares Stores, Outdoor Equipment Stores Directory");
                                                                                                                                                                                                                                                                          /*
SECTION 3  -> PAYMENT SETTINGS
              These setting allow you to customize the page titles for marketplace with out having to modify your templates.   
              PAYMENT_CLASS    = authorize.net
              PAYMENT_USER     = User name for payment gateway
              PAYMENT_KEY      = Private key for payment gateway
              PAYMENT_VERSION  = Version number if required
              PAYMENT_TESTCARD = If this card number is entered, the system automatically goes into test mode even if mode is set to 'live'
              PAYMENT_MODE     = test | live
                                                                                                                                                                                                                                                            */ 
              define (PAYMENT_CLASS,    "");
              define (PAYMENT_USER,     "");
              define (PAYMENT_KEY,      "");
              define (PAYMENT_VERSION,  "");
              define (PAYMENT_TESTCARD, "5424000000000001");
              define (PAYMENT_MODE,     "test");
                                                                                                                                                                                                                                                            /*
------------------------------------------------------------------------------------------------------------------------------------------------------------------------
Everything below this line is customizable, but require a more advance knowledge of this system.  Feel free to change anything you want, but no changes are required.
                                                                                                                                                                                                                                                            */ 
                                                                                                                                                                                                                                                            /*
SECTION 4  -> SMTP & MAIL SETTINGS
              These settings allow you to customize the email handler for marketplace.   
              SEND_SMTP_TO      = The email address you which to recieve marketplace emails.
              SMTP_FROM_NAME    = Custom "from display name" for filtering your email (no change required)
              SMTP_FROM_EMAIL   = Custom "from email" for filtering your email (no change required)
              SMTP_REPLY_EMAIL  = Custom "reply to email" (no change required)
              SMTP_RETURN_EMAIL = Custom "return email" (no change required)
              SMTP_BCC_EMAIL    = Custom "blind carbon copy" if you require a BCC (no change required)
              SMTP_HEADERS      = This is what the additional headers will look like.  If you are not familiar with these, don't change them.
                                                                                                                                                                                                                                                            */ 
              define (SEND_SMTP_TO,      COMPANYEMAIL);
              define (SMTP_FROM_NAME,    PAGETITLE);
              define (SMTP_FROM_EMAIL,   "no-reply@".$_SERVER["SERVER_NAME"]);
              define (SMTP_REPLY_EMAIL,  "no-reply@".$_SERVER["SERVER_NAME"]);
              define (SMTP_RETURN_EMAIL, "no-reply@".$_SERVER["SERVER_NAME"]);
              define (SMTP_HEADERS,      "From: \"".SMTP_FROM_NAME."\" <".SMTP_FROM_EMAIL.">\n"."Reply-To: ".SMTP_REPLY_EMAIL."\n"."Return-Path: ".SMTP_RETURN_EMAIL."\n"."Content-Type: text/html; charset=\"UTF-8\"\n");
              // To enable BCC, comment out the one line above this statement and uncomment the two lines below this statement
              //define (SMTP_BCC_EMAIL,    "no-reply@".$_SERVER["SERVER_NAME"]);
              //define (SMTP_HEADERS,      "From: \"".SMTP_FROM_NAME."\" <".SMTP_FROM_EMAIL.">\n"."Bcc: ".SMTP_BCC_EMAIL."\n"."Reply-To: ".SMTP_REPLY_EMAIL."\n"."Return-Path: ".SMTP_RETURN_EMAIL."\n"."Content-Type: text/html; charset=\"UTF-8\"\n");
                                                                                                                                                                                                                                                            /*
SECTION 5  -> MYSQL DATABASE TABLE NAMES
              If you want something other than the default table names, you can specify that here.   
              MP_TABLE_NAME        = Business information for Marketplace. This is the primary table.
              CAT_TABLE_NAME       = Category information for Marketplace.   
              AD_TABLE_NAME        = Holds records for all the ads listed in Marketplace.
              PROFILES_TABLE_NAME  = Profiles for each company.
              SD_TABLE_NAME        = Defines the categories for the Service Directory portion of Marketplace.
              DB_LUNCHSPECIALADS   = Specifies which ads are to be placed in the lunch menus.
              DB_LUNCHSPECIALMENUS = Designs the menu for each day.
                                                                                                                                                                                                                                                            */ 
              define (MP_TABLE_NAME,        "marketplace");
              define (CAT_TABLE_NAME,       "guide");
              define (AD_TABLE_NAME,        "ad_schedule");
              define (SD_TABLE_NAME,        "service_directory_cats");
              define (ADMIN_TABLE_NAME,     "admin_accounts");
              define (ICON_TABLE_NAME,      "icons");
              define (DB_LUNCHSPECIALADS,   "lunch_special_ads");
              define (DB_LUNCHSPECIALMENUS, "lunch_special_menus");
              define (GC_TABLE_NAME,        "giftcards");
              define (GC_CARDS_NAME,        "giftcards_cards");
              define (GC_INVOICES,          "giftcards_invoices");
              define (GENERAL_CATEGORIES,   "general_categories");
                                                                                                                                                                                                                                                            /*
SECTION 6  -> REQUIRED FILES
              Each of these files are required by the system.  If you want customize functions, classes or configurations,
              you can change which file it pulls by updating this section.
                                                                                                                                                                                                                                                            */ 
              define (PATHTOADMIN,              "/_admin");
              define (INSTALLED_FOLDER,         str_replace(PATHTOADMIN, "", dirname($_SERVER["SCRIPT_NAME"])));
              define (PATHTODIR,                $_SERVER["DOCUMENT_ROOT"].INSTALLED_FOLDER);
              define (PATHTOHTML,               "http://".$_SERVER["SERVER_NAME"].INSTALLED_FOLDER);
              define (MYSQL_SETTINGS,           PATHTODIR.PATHTOADMIN."/_includes/mysql_settings.inc.php");
              define (CLASS_LUNCHSPECIAL,       PATHTODIR.PATHTOADMIN."/_classes/lunch_special.class.php");
              define (CLASS_MP_BUSINESS,        PATHTODIR.PATHTOADMIN."/_classes/business.class.php");
              define (CLASS_GENERAL_CATEGORIES, PATHTODIR.PATHTOADMIN."/_classes/general_categories.class.php");
              define (CLASS_GIFT_CARDS,         PATHTODIR.PATHTOADMIN."/_classes/giftcards.class.php");
              define (CLASS_SHOPPING_CART,      PATHTODIR.PATHTOADMIN."/_classes/shoppingcart.class.php");
              define (CLASS_USERS,              PATHTODIR.PATHTOADMIN."/_classes/user.class.php");
              define (CLASS_ADS,                PATHTODIR.PATHTOADMIN."/_classes/ad.class.php");
              define (CLASS_ICONS,              PATHTODIR.PATHTOADMIN."/_classes/icon.class.php");
              define (TRACKER_GOOGLE,           PATHTODIR.PATHTOADMIN."/_trackers/google.track.php");
              define (SECURITY,                 PATHTODIR.PATHTOADMIN."/_includes/security.inc.php");
              define (FUNCTIONS,                PATHTODIR.PATHTOADMIN."/_includes/functions.inc.php");
              define (EMAILFUNCTIONS,           PATHTODIR.PATHTOADMIN."/_includes/email_functions.inc.php");
              define (CONFIG,                   PATHTODIR.PATHTOADMIN."/_includes/config.inc.php");
              define (GOOGLEMAPS,			          PATHTODIR.PATHTOADMIN."/_includes/google_maps.inc.php");
              define (SITEBUILDERSFOLDER,       PATHTODIR.PATHTOADMIN."/_site_builders");
              define (SEARCHEDMERCHANTSFILE,    SITEBUILDERSFOLDER."/search_merchants.txt");
              define (SEARCHEDTERMSFILE,        SITEBUILDERSFOLDER."/search_terms.txt");
              define (ADCHEATSHEET,             SITEBUILDERSFOLDER."/ad_sheet.inc.php");
              define (PATHTODATADIR,            PATHTODIR."/_data");
              define (HTMLTODATADIR,            PATHTOHTML."/_data");
              define (AUTHORIZE_PCLASS,         PATHTODIR.PATHTOADMIN."/_classes/authorize.pclass.php");
                                                                                                                                                                                                                                                            /*
SECTION 7  -> GENERAL FOLDERS & TEMPLATES
              Points to each template used by Marketplace, image, styles & scripts folders.
                                                                                                                                                                                                                                                            */ 
              define (STYLEDIR,            PATHTOHTML.PATHTOADMIN."/_styles");
              define (JAVASCRIPTDIR,       PATHTOHTML.PATHTOADMIN."/_scripts");
              define (IMAGEDIR,            PATHTOHTML.PATHTOADMIN."/_images");
              define (HTMLTOICONDIR,       IMAGEDIR."/icons");
              define (PATHTOICONDIR,       PATHTODIR.PATHTOADMIN."/_images/icons");
              define (PATHTOTEMPLATES,     PATHTODIR.PATHTOADMIN."/_templates");
              define (PATHTOTEMPLATESEDIT, PATHTODIR.PATHTOADMIN."/_templates_editable");
              define (ADMINHEADERFILE,     PATHTOTEMPLATES."/admin_header.php");
              define (ADMINFOOTERFILE,     PATHTOTEMPLATES."/admin_footer.php");
              define (SITEHEADERFILE,      PATHTOTEMPLATES."/site_header.php");
              define (SITEFOOTERFILE,      PATHTOTEMPLATES."/site_footer.php");
              define (LUNCHHEADERFILE,     PATHTOTEMPLATES."/lunch_header.php");
              define (LUNCHFOOTERFILE,     PATHTOTEMPLATES."/lunch_footer.php");
              define (PRINTHEADERFILE,     PATHTOTEMPLATES."/print_header.php");
              define (PRINTFOOTERFILE,     PATHTOTEMPLATES."/print_footer.php");
                                                                                                                                                                                                                                                            /*
SECTION 8  -> OTHER DEFINITIONS
              Other definitions used by Marketplace
                                                                                                                                                                                                                                                            */ 
              define (P_SESSION_ID, "session_id");
              define (SHOPPING_SESSION_ID, "mp_shopping_cart");
              define (TODAY, date("Ymd"));
              define (PASSWORDSEED, "mp");
              define (MYSQL_CRYPT_KEY, "mpcrypt");
                                                                                                                                                                                                                                                            /*
SECTION 9  -> GLOBAL INCLUDES/REQUIRES
              Anything that is included/required is defined here.
                                                                                                                                                                                                                                                            */ 
              if(!is_file(MYSQL_SETTINGS)){
              	header("location: ".PATHTOHTML.PATHTOADMIN."/_install_db.php");
              	exit;
              	}
              include MYSQL_SETTINGS;
              include CONFIG;
              include FUNCTIONS;


?>
